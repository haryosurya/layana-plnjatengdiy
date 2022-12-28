<?php

namespace App\Console\Commands;

use App\Models\Dc_cubicle;
use App\Models\ews_ssd_gedung;
use App\Models\User;
use Google\Service\FirebaseCloudMessaging\Notification;
use Illuminate\Console\Command;

class SmokeDetector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:noti';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'notification pln';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return 0;
        $tokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

        $smokeDetect =  
            ews_ssd_gedung::orderBy('ews_ssd_gedung.GEDUNG_ID','DESC')
            ->groupBy('ews_ssd_gedung.GEDUNG_ID')
            ->join('dc_gardu_induk','ews_ssd_gedung.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')
            ->where('ews_ssd_gedung.SSD_1','=','1')
            ->orWhere('ews_ssd_gedung.SSD_2','=','1')
            ->orWhere('ews_ssd_gedung.SSD_3','=','1')  
            ->orWhere('ews_ssd_gedung.SSD_4','=','1') 
            ->selectRaw( 
                'ews_ssd_gedung.GEDUNG_ID,
                ews_ssd_gedung.SSD_1 as SSD_1, 
                ews_ssd_gedung.SSD_2 as SSD_2, 
                ews_ssd_gedung.SSD_3 as SSD_3, 
                ews_ssd_gedung.SSD_4 as SSD_4,  
                ews_ssd_gedung.SSD_1 as SSD_1_TIME, 
                ews_ssd_gedung.SSD_2 as SSD_2_TIME, 
                ews_ssd_gedung.SSD_3 as SSD_3_TIME, 
                ews_ssd_gedung.SSD_4 as SSD_4_TIME,  
                dc_apj.APJ_ID,
                dc_apj.APJ_NAMA,  
                dc_apj.APJ_DCC as APJ_DCC,  
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_INDUK_ID'
                ) 
            ->get() ;  
        if(!empty($smokeDetect)){
            foreach ($smokeDetect as $s) {
                {
                    if ($s->SSD_1 == '1' ) {
                        $t = $s->SSD_1_TIME;
                    }
                    elseif($s->SSD_2 == '1' ) {
                        $t = $s->SSD_2_TIME;
                    }
                    elseif($s->SSD_3 == '1' ) {
                        $t = $s->SSD_3_TIME;
                    }
                    else{
                        $t = $s->SSD_4_TIME;
                    }
                    // User::get()->select('fcm_token');
                    $title = "Smoke Detector";
                    $msg = 'Terdeteksi ASAP di GI '.$s->GARDU_INDUK_ID.' Gedung '.$s->GEDUNG_NOMOR.' pada '.$t;
                   
                    push_notification_android($tokens,$title,$msg);    
                }
            }
        }
        $cub =  
            Dc_cubicle::orderBy('OUTGOING_ID','DESC') 
            ->where('TEMP_A','>=','LIMIT_UPPER_TIME')
            ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME')
            ->orWhere('TEMP_C','>=','LIMIT_UPPER_TIME')  
            ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME') 
            ->get() ;  
        if(!empty($cub)){
            foreach ($cub as $c) { 
                {
                    $titl = "Temperatur";
                    if ($c->TEMP_A >= $c->LIMIT_UPPER_TIME ) {
                        $time = $c->TEMP_A_TIME;
                        $msgs = 'Suhu Kabel Power '.$c->CUBICLE_NAME.' Phasa A mencapai '.$c->TEMP_A.'° C pada '.$c->TEMP_A_TIME;
                        push_notification_android($tokens,$titl,$msgs);    
                    }
                    if($c->TEMP_B >= $c->LIMIT_UPPER_TIME ) {
                        $time = $c->TEMP_B_TIME;
                        $msgs = 'Suhu Kabel Power '.$c->CUBICLE_NAME.' Phasa B mencapai '.$c->TEMP_B.'° C pada '.$c->TEMP_B_TIME; 
                        push_notification_android($tokens,$titl,$msgs);    
                    }
                    if($c->TEMP_C >= $c->LIMIT_UPPER_TIME ) {
                        $time = $c->TEMP_C_TIME;
                        $msgs = 'Suhu Kabel Power '.$c->CUBICLE_NAME.' Phasa C mencapai '.$c->TEMP_C.'° C pada '.$c->TEMP_C_TIME; 
                        push_notification_android($tokens,$titl,$msgs);     
                    }  
                }
            }
        }

        
        $hum =  
        Dc_cubicle::orderBy('OUTGOING_ID','DESC') 
        ->where('HUMIDITY','>=','LIMIT_UPPER_HUMIDITY') 
        ->get() ;  
        if(!empty($hum)){
            foreach ($hum as $h) { 
                {
                    $titles = "Humidity"; 
                    $times = $h->HUMIDITY_TIME;
                    $msgss = 'Kelembaban '.$c->CUBICLE_NAME.' mencapai '.$h->HUMIDITY.'% pada '.$times;
                    push_notification_android($tokens,$titles,$msgss); 
                }
            }
        }


    }
}
