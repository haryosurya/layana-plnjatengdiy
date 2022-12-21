<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_gardu_induk;
use App\Models\ews_ssd_gedung;
use App\Models\sm_material_panel;
use Illuminate\Http\Request;

class SmokeDetectorController extends Controller
{
    //
    public function list_dcc(Request $request){
        try{
            $result = Dc_apj::orderBy('APJ_ID','ASC')
            ->leftJoin('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw('dc_apj.APJ_ID,dc_apj.APJ_NAMA,dc_apj.APJ_ALIAS,dc_apj.APJ_DCC,count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU
            ,dc_gardu_induk.GARDU_INDUK_ID')  
            ->where('dc_apj.APJ_ID','!=','12')
            ->where('dc_apj.APJ_ID','!=','13')
            ->groupBy('dc_apj.APJ_ID');

            if ($request->get('APJ_DCC'))
            {
                $keyword = $request->get('APJ_DCC');    
                $result = $result->where('APJ_DCC', $keyword ) ;
            } 
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID', $keyword ) ;
            } 

            $result = $result->paginate(12); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list_smoke(Request $request, $id){
        try{
            $result = ews_ssd_gedung::orderBy('ews_ssd_gedung.GEDUNG_ID','DESC')
            ->groupBy('ews_ssd_gedung.GEDUNG_ID')
            ->join('dc_gardu_induk','ews_ssd_gedung.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
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
                ) ; 
                  
            if ($request->get('APJ_DCC'))
            {
                $keyword = $request->get('APJ_DCC');    
                $result = $result->where('APJ_DCC', $keyword ) ;
            } 
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID', $keyword ) ;
            } 
            if ($request->get('STATUS'))
            {
                $keyword = $request->get('STATUS');    
                $result = $result->HAVING('STATUS', $keyword ) ;
            } 

            $result = $result->paginate(12); 

                
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function detail_smoke($id){
        try{ 
            $result = [];
            $result = ews_ssd_gedung::where('GEDUNG_ID',$id)
            ->join('dc_gardu_induk','ews_ssd_gedung.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')->first();  
 
                if(
                 $result['SSD_1'] == '' | $result['SSD_1'] == null |$result['SSD_1'] == "null"|$result['SSD_1'] == "0"|
                 $result['SSD_3'] == '' | $result['SSD_3'] == null |$result['SSD_3'] == "null"|$result['SSD_3'] == "0"|
                 $result['SSD_4'] == '' | $result['SSD_4'] == null |$result['SSD_4'] == "null"|$result['SSD_4'] == "0"
                ){
                    $s = "No Smoke"; 
                }else{
                    $s = "smoke"; 
                }
               $res = array(
                "GEDUNG_ID" => $result->GEDUNG_ID,
                "SMOKE_LABEL" => $s,
                "GARDU_INDUK_ID" => $result->GARDU_INDUK_ID,
                "GEDUNG" => $result->GEDUNG,  
                "SSD_1" => $result->SSD_1,
                "SSD_1_TIME" => $result->SSD_1_TIME,
                "SSD_2" => $result->SSD_2,
                "SSD_2_TIME" => $result->SSD_2_TIME,
                "SSD_3" => $result->SSD_3,
                "SSD_3_TIME" => $result->SSD_3_TIME,
                "SSD_4" => $result->SSD_4,
                "SSD_4_TIME" => $result->SSD_4_TIME,
                "APJ_ID" => $result->APJ_ID,
                "GARDU_INDUK_NAMA" => $result->GARDU_INDUK_NAMA,
                "GARDU_INDUK_KODE" => $result->GARDU_INDUK_KODE,
                "GARDU_INDUK_RTU_ID" => $result->GARDU_INDUK_RTU_ID,
                "GARDU_INDUK_ALIAS" => $result->GARDU_INDUK_ALIAS,
                "GARDU_INDUK_ALIAS_ROPO" => $result->GARDU_INDUK_ALIAS_ROPO,
                "GARDU_INDUK_ALAMAT" => $result->GARDU_INDUK_ALAMAT,
                "UPT_ID" => $result->UPT_ID,
                "NAMA_ALIAS_GARDU_INDUK" => $result->NAMA_ALIAS_GARDU_INDUK,
                "PEMELIHARAAN_GI" => $result->PEMELIHARAAN_GI,
                "BATAS_TEGANGAN_BAWAH" => $result->BATAS_TEGANGAN_BAWAH,
                "BATAS_TEGANGAN_ATAS" => $result->BATAS_TEGANGAN_ATAS,
                "APJ_NAMA" => $result->APJ_NAMA,
                "APJ_ALIAS" => $result->APJ_ALIAS,
                "APJ_DCC" => $result->APJ_DCC,
                "APJ_ALAMAT" => $result->APJ_ALAMAT,
                "APJ_KODE" => $result->APJ_KODE,
                "TELEGRAM_ID" => $result->TELEGRAM_ID, 
               ) ;
            return response()->json( [           
                'status' => true, 
                'data' => $res,  
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
