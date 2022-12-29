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
        $date_now= date('Y-m-d H:i',strtotime(' + 1 Minutes')); 
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
                ews_ssd_gedung.GEDUNG_NOMOR,
                ews_ssd_gedung.SSD_1 as SSD_1, 
                ews_ssd_gedung.SSD_2 as SSD_2, 
                ews_ssd_gedung.SSD_3 as SSD_3, 
                ews_ssd_gedung.SSD_4 as SSD_4,  
                ews_ssd_gedung.SSD_1_TIME as SSD_1_TIME, 
                ews_ssd_gedung.SSD_2_TIME as SSD_2_TIME, 
                ews_ssd_gedung.SSD_3_TIME as SSD_3_TIME, 
                ews_ssd_gedung.SSD_4_TIME as SSD_4_TIME,  
                dc_apj.APJ_ID,
                dc_apj.APJ_NAMA,  
                dc_apj.APJ_DCC as APJ_DCC,  
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_INDUK_ID'
                ) 
            ->get()->toArray() ;  
        if(!empty($smokeDetect)){
            foreach ($smokeDetect as $s) {
                $title = "Smoke Detector"; 
                if ($s['SSD_1'] == '1' ) { 
                    $time_smoke= date('Y-m-d H:i',strtotime($s['SSD_1_TIME']));
                    $time_smoke= date('Y-m-d H:i',strtotime($time_smoke.' + 1 Minutes')); 
                    // if ($time_smoke == $date_now){
                        // <strong></strong>
                        $msg = "Terdeteksi ASAP di GI ".$s['GARDU_INDUK_ID']." Gedung ".$s['GEDUNG_NOMOR']." pada ".$s['SSD_1_TIME'];
                        push_notification_android($tokens,$title,$msg);     
                    // }
                }
                // sleep(2); 
                if($s['SSD_2'] == '1' ) { 
                    $time_smoke= date('Y-m-d H:i',strtotime($s['SSD_2_TIME']));
                    $time_smoke= date('Y-m-d H:i',strtotime($time_smoke.' + 1 Minutes')); 
                    if ($time_smoke == $date_now){
                        $msga = 'Terdeteksi ASAP di GI '.$s['GARDU_INDUK_ID'].' Gedung '.$s['GEDUNG_NOMOR'].' pada '.$s['SSD_2_TIME'];
                        push_notification_android($tokens,$title,$msga);    
                    }
                }
                if($s['SSD_3'] == '1' ) { 
                    $time_smoke= date('Y-m-d H:i',strtotime($s['SSD_3_TIME']));
                    $time_smoke= date('Y-m-d H:i',strtotime($time_smoke.' + 1 Minutes')); 
                    if ($time_smoke == $date_now){
                        $msgz = 'Terdeteksi ASAP di GI '.$s['GARDU_INDUK_ID'].' Gedung '.$s['GEDUNG_NOMOR'].' pada '.$s['SSD_3_TIME'];
                        push_notification_android($tokens,$title,$msgz);    
                    }
                }
                if($s['SSD_4'] == '1' ){ 
                    $time_smoke= date('Y-m-d H:i',strtotime($s['SSD_4_TIME']));
                    $time_smoke= date('Y-m-d H:i',strtotime($time_smoke.' + 1 Minutes')); 
                    if ($time_smoke == $date_now){
                        $msgsss = 'Terdeteksi ASAP di GI '.$s['GARDU_INDUK_ID'].' Gedung '.$s['GEDUNG_NOMOR'].' pada '.$s['SSD_4_TIME'];
                        // dd($msgsss);
                        push_notification_android($tokens,$title,$msgsss);    
                    }
                }  
            }
        }



        $cub =  
        Dc_cubicle::where('TEMP_A','>','LIMIT_UPPER_TIME')
        ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME')
        ->orWhere('TEMP_C','>=','LIMIT_UPPER_TIME')  
        ->orWhere('TEMP_B','>=','LIMIT_UPPER_TIME') 
        ->get();  
        // dd($cub);
        if(!empty($cub)){
            
            foreach ($cub as $c) { 
                {
                    // dd($c);
                    $titl = "Temperatur";
                    if ($c['TEMP_A'] >= $c['LIMIT_UPPER_TIME'] ) {
                        $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_A_TIME']));
                        $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes')); 
                        if ($time_temp == $date_now){
                            $time = $c['TEMP_A_TIME'];
                            $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa A mencapai '.$c['TEMP_A'].'° C pada '.$time;
                            $send = push_notification_android($tokens,$titl,$msgs);   
                        }
                    } 
                    if($c['TEMP_B'] >= $c['LIMIT_UPPER_TIME'] ) {
                        $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_B_TIME']));
                        $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes'));
                        if ($time_temp == $date_now){
                            $time = $c['TEMP_B_TIME']; 
                            $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa B mencapai '.$c['TEMP_B'].'° C pada '.$c['TEMP_B_TIME']; 
                            $send = push_notification_android($tokens,$titl,$msgs);     
                        }
                    }
                    if($c['TEMP_C'] >= $c['LIMIT_UPPER_TIME'] ) {
                        $time_temp= date('Y-m-d H:i',strtotime($c['TEMP_C_TIME']));
                        $time_temp= date('Y-m-d H:i',strtotime($time_temp.' + 1 Minutes'));
                        if ($time_temp == $date_now){
                            $time = $c['TEMP_C_TIME'];
                            $msgs = 'Suhu Kabel Power '.$c['CUBICLE_NAME'].' Phasa C mencapai '.$c['TEMP_C'].'° C pada '.$c['TEMP_C_TIME']; 
                            $send = push_notification_android($tokens,$titl,$msgs); 
                        }    
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
                    $time_humidity= date('Y-m-d H:i',strtotime($h['HUMIDITY_TIME']));
                    $time_humidity= date('Y-m-d H:i',strtotime($time_humidity.' + 1 Minutes')); 
                    if ($time_humidity == $date_now){
                        $times = $h['HUMIDITY_TIME'];
                        $msgss = 'Kelembaban '.$h['CUBICLE_NAME'].' mencapai '.$h['HUMIDITY'].'% pada '.$times;
                        // echo($msgss);
                        push_notification_android($tokens,$titles,$msgss); 
                    }
                }
            }
        }


    }
}
