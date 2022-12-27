<?php

namespace App\Console\Commands;

use App\Models\ews_ssd_gedung;
use Google\Service\FirebaseCloudMessaging\Notification;
use Illuminate\Console\Command;

class SmokeDetector extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
                ews_ssd_gedung.GEDUNG_NOMOR as GEDUNG_NOMOR, 
                dc_apj.APJ_ID,
                dc_apj.APJ_NAMA,  
                dc_apj.APJ_DCC as APJ_DCC,  
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_INDUK_ID,
                
                (CASE  
                        WHEN ews_ssd_gedung.SSD_1 IS NULL OR (
                            ews_ssd_gedung.SSD_1 = NULL OR
                            ews_ssd_gedung.SSD_1 = "0" )
                        OR ews_ssd_gedung.SSD_2 IS NULL OR (
                            ews_ssd_gedung.SSD_2 = NULL OR
                            ews_ssd_gedung.SSD_2 = "0" )
                        OR ews_ssd_gedung.SSD_3 IS NULL OR (
                            ews_ssd_gedung.SSD_3 = NULL OR
                            ews_ssd_gedung.SSD_3 = "0" )
                        OR ews_ssd_gedung.SSD_4 IS NULL OR (
                            ews_ssd_gedung.SSD_4 = NULL OR
                            ews_ssd_gedung.SSD_4 = "0" )  
                        THEN "NO SMOKE"  
                        ELSE "SMOKE"  
                        END) AS STATUS
                        '
                ) 
            ->get() ; 
            
        if(!empty($smokeDetect)){
            foreach ($smokeDetect as $s) {
                {

                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $FcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();
                      
                    $serverKey = 'server key goes here';
              
                    $data = [ 
                        "notification" => [
                            "title" => $s->GEDUNG_NOMOR,
                            "body" => $request->GEDUNG_NOMOR,  
                        ]
                    ];
                    $encodedData = json_encode($data);
                
                    $headers = [
                        'Authorization:key=' . $serverKey,
                        'Content-Type: application/json',
                    ];
                
                    $ch = curl_init();
                  
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                    // Disabling SSL Certificate support temporarly
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
                    // Execute post
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        die('Curl failed: ' . curl_error($ch));
                    }        
                    // Close connection
                    curl_close($ch);
                    // FCM response
                    dd($result);   
                // $body = 'Terdeteksi ASAP di GI '.$s->GARDU_INDUK_ID.' Gedung '.$s->GEDUNG_NOMOR.' pada [SSD_1_TIME/ SSD_2_TIME/ SSD_3_TIME/ SSD_3_TIME/]'
                // Terdeteksi ASAP di GI [GARDU_INDUK_NAMA] Gedung [GEDUNG_NOMOR] pada [SSD_1_TIME/ SSD_2_TIME/ SSD_3_TIME/ SSD_3_TIME/]
                }
            }
        }
    }
}
