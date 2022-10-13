<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_incoming_feeder;
use App\Models\Dc_inspeksi_asset;
use App\Models\Dc_inspeksi_pd;
use App\Models\Dc_tipe_gangguan;
use App\Models\Ews_history_meter;
use App\Models\ews_inspeksi_aset;
use App\Models\ews_inspeksi_pd;
use App\Models\Sm_meter_gi;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcCubicleController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $result = Dc_cubicle::
            orderBy('dc_cubicle.OUTGOING_ID','ASC') 
            ->join('dc_apj','dc_apj.APJ_ID','dc_cubicle.APJ_ID') 
            ->join('dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
            ->leftJoin('dc_gardu_induk','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
            ->selectRaw(
                'dc_cubicle.OUTGOING_ID as ID,
                dc_apj.APJ_ID as APJ_ID,
                dc_apj.APJ_NAMA as APJ_NAMA,
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_ID,
                dc_gardu_induk.GARDU_INDUK_NAMA,
                dc_cubicle.CUBICLE_NAME,
                dc_cubicle.INCOMING_ID as INCOMING_ID, 
                dc_cubicle.PD_LEVEL, 
                ROUND((dc_cubicle.IA+dc_cubicle.IB+dc_cubicle.IC)/3,2) as TEMPERATURE,
                dc_cubicle.HUMIDITY,
                dc_cubicle.PD_CRITICAL'
                ) ;
            if ($request->get('CUBICLE_NAME')) 
            {
                $keyword = $request->get('CUBICLE_NAME');    
                $result = $result-> where('CUBICLE_NAME', 'LIKE','%' .$keyword . '%' ) ;
            }
            if ($request->get('INCOMING_ID')) 
            {
                $keyword = $request->get('INCOMING_ID');    
                $result = $result->where('dc_cubicle.INCOMING_ID', $keyword ) ;
            } 
            return response()->json(array(    
                'status'=>true,        
                'data' =>  $result->paginate(10),  
                'status_code' => 200
            ));
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function single($id){
        // Status ini diambil dari dc_cubicle.SCB & dc_cubicle.SCB_INV.
        // SCB = 0 & SCB_INV = 0 adalah kondisi OPEN, pewarnaan HIJAU
        // SCB = 1 & SCB_INV = 0 adalah kondisi CLOSE, pewarnaan MERAH
        // SCB = 0 & SCB_INV = 1 adalah kondisi CLOSE, pewarnaan MERAH
        // SCB = 1 & SCB_INV = 1 adalah kondisi OPEN, pewarnaan HIJAU 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
         
            if ($result['SCB'] == 0 && $result['SCB_INV'] == 0) 
            {
                $condition = 'open';
            }
            elseif ($result['SCB'] == 1 && $result['SCB_INV'] == 0) 
            {
                $condition = 'close';
            }
            elseif ($result['SCB'] == 0 && $result['SCB_INV'] == 1) 
            {
                $condition = 'close';
            }
            else{
                $condition = 'open';
            } 
            if ($result['SLR'] == 0 && $result['SLR_INV'] == 0) 
            {
                $lr = 'LOKAL';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 0) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 0 && $result['SLR_INV'] == 1) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 1) 
            {
                $lr = 'LOKAL';
            }
            else{
                $lr = '';
            }
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->firstorFail();
            $history_pd = ews_inspeksi_pd::where('id_outgoing',$id)->limit(1) ->orderBy('id_inspeksi_pd','DESC')->get(); 
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)->limit(1) ->orderBy('OUTGOING_METER_ID','DESC')->get();
            $history_asset = ews_inspeksi_aset::where('id_outgoing',$id)->limit(1) ->orderBy('id_inspeksi_aset','DESC')->get();
            return response()->json(array(    
                'status'=>true,  
                'data' => array (
                    'topstatus' => $result['PD_LEVEL'],
                    'condition' => $condition,      
                    'lokal_remote' => $lr,
                    'total_beban' => array(
                        'phasa_r' => $result['IA'],
                        'phasa_s' => $result['IB'],
                        'phasa_t' => $result['IC'],
                        'tegangan' => $result['VLL'],
                    ),
                    'gi' => $gi->dcGarduInduk['NAMA_ALIAS_GARDU_INDUK'],
                    'incoming_name' => $gi['INCOMING_NAME'],
                    'incoming_alias' => $gi['NAMA_ALIAS_INCOMING'],
                    'combine_gardu_dan_incoming' => $gi->dcGarduInduk['NAMA_ALIAS_GARDU_INDUK'].' '.$gi['NAMA_ALIAS_INCOMING'],
                    'temperatur_a' =>$gi['TEMP_A'],
                    'temperatur_b' =>$gi['TEMP_B'],
                    'temperatur_c' =>$gi['TEMP_C'],
                    'humidity' => $gi['HUMIDITY'],
                    'history_pd' => array(
                        "id_inspeksi_pd"=>  $history_pd->id_inspeksi_pd,
                        "id_outgoing"=>  $history_pd->id_outgoing,
                        "id_user"=>  $history_pd->id_user,
                        "id_gardu_induk"=>  $history_pd->id_gardu_induk,
                        "tgl_entry"=>  $history_pd->tgl_entry,
                        "tgl_inspeksi"=>  $history_pd->tgl_inspeksi,
                        "citicality"=>  $history_pd->citicality,
                        "level_pd"=>  $history_pd->level_pd,
                        "foto_pelaksanaan"=> json_decode($history_pd->foto_pelaksanaan),
                        "foto_pengukuran"=>  json_decode($history_pd->foto_pengukuran),
                        "keterangan" =>  $history_pd->keterangan,
                        "id_update"=>  $history_pd->id_update,
                        "last_update"=>  $history_pd->last_update
                    ),
                    'history_pmt' => $history_pmt,
                    'history_asset' => $history_asset,
                ), 
                'status_code' => 200
            ));
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
    public function Pmt(Request $request) {
        if (auth('sanctum')->check()){  
            $result = Dc_cubicle:: 
            orderBy('dc_cubicle.OUTGOING_ID','ASC') 
            ->join('Dc_apj','dc_apj.APJ_ID','dc_cubicle.APJ_ID') 
            ->join('Dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
            ->leftJoin('dc_gardu_induk','Dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
            ->select('dc_cubicle.OUTGOING_ID as ID','dc_apj.APJ_ID as APJ_ID','dc_apj.APJ_NAMA as APJ_NAMA','dc_gardu_induk.GARDU_INDUK_ID as GARDU_ID','dc_gardu_induk.GARDU_INDUK_NAMA','dc_cubicle.CUBICLE_NAME','dc_cubicle.PD_LEVEL','dc_cubicle.PD_CRITICAL') ;

            if($request->APJ_NAMA){
                $keyword = $request->get('APJ_NAMA');    
                $result = $result->where('dc_apj.APJ_NAMA', 'LIKE','%' .$keyword . '%') ;
            }
            if($request->APJ_ID){
                $keyword = $request->get('APJ_ID');    
                $result = $result->where('dc_apj.APJ_ID', $keyword ) ;
            }
            if($request->GARDU_INDUK_ID){
                $keyword = $request->get('GARDU_ID');    
                $result = $result->where('GARDU_ID', $keyword ) ;
            }
            if($request->GARDU_INDUK_NAMA){
                $keyword = $request->get('GARDU_INDUK_NAMA');    
                $result = $result->where('dc_gardu_induk.GARDU_INDUK_NAMA', $keyword ) ;
            }
            if($request->PD_CRITICAL){
                $keyword = $request->get('PD_CRITICAL');    
                $result = $result->where('dc_cubicle.PD_CRITICAL', $keyword ) ;
            }

            $result = $result->paginate(10); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function singleRealtime($id){ 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
         
            if ($result['SCB'] == 0 && $result['SCB_INV'] == 0) 
            {
                $condition = 'open';
            }
            elseif ($result['SCB'] == 1 && $result['SCB_INV'] == 0) 
            {
                $condition = 'close';
            }
            elseif ($result['SCB'] == 0 && $result['SCB_INV'] == 1) 
            {
                $condition = 'close';
            }
            else{
                $condition = 'open';
            } 
            if ($result['SLR'] == 0 && $result['SLR_INV'] == 0) 
            {
                $lr = 'LOKAL';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 0) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 0 && $result['SLR_INV'] == 1) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 1) 
            {
                $lr = 'LOKAL';
            }
            else{
                $lr = '';
            }
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->first();
            $history_pd = Dc_inspeksi_pd::where('OUTGOING_ID',$id)->limit('10')->orderBy('id','DESC')->get();
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)->orderBy('OUTGOING_METER_ID','DESC')->limit('10')->get();
            $history_asset = Dc_inspeksi_asset::where('OUTGOING_ID',$id)->limit('10')->orderBy('id','DESC')->get();
            return response()->json(array(    
                'status'=>true,  
                'data' => array(
                    'topstatus' => $result['PD_LEVEL'],
                    'condition' => $condition,      
                    'lokal_remote' => $lr,
                    'total_beban' => array(
                        'phasa_r' => '',
                        'phasa_s' => '',
                        'phasa_t' => '',
                        'tegangan' => ''
                    ),
                    'gi' => $gi->dcGarduInduk['GARDU_INDUK_NAMA'],
                    'incoming_name' => $gi['INCOMING_NAME'],
                    'combine_gardu_dan_incoming' =>'GI '. $gi->dcGarduInduk['GARDU_INDUK_NAMA'].' Incoming '.$gi['INCOMING_NAME'],
                    'temperatur_a' =>$gi['TEMP_A'],
                    'temperatur_b' =>$gi['TEMP_B'],
                    'temperatur_c' =>$gi['TEMP_C'],
                    'history_pd' => $history_pd,
                    'history_pmt' => $history_pmt,
                    'history_asset' => $history_asset,
                ), 
                'status_code' => 200
            ));
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
    public function singleSmoke($id){ 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
         
            if ($result['SCB'] == 0 && $result['SCB_INV'] == 0) 
            {
                $condition = 'open';
            }
            elseif ($result['SCB'] == 1 && $result['SCB_INV'] == 0) 
            {
                $condition = 'close';
            }
            elseif ($result['SCB'] == 0 && $result['SCB_INV'] == 1) 
            {
                $condition = 'close';
            }
            else{
                $condition = 'open';
            } 
            if ($result['SLR'] == 0 && $result['SLR_INV'] == 0) 
            {
                $lr = 'LOKAL';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 0) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 0 && $result['SLR_INV'] == 1) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 1) 
            {
                $lr = 'LOKAL';
            }
            else{
                $lr = '';
            }
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->first();
            $history_pd = Dc_inspeksi_pd::where('OUTGOING_ID',$id)->limit('10')->orderBy('id','DESC')->get();
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)->orderBy('OUTGOING_METER_ID','DESC')->limit('10')->get();
            $history_asset = Dc_inspeksi_asset::where('OUTGOING_ID',$id)->limit('10')->orderBy('id','DESC')->get();
            return response()->json(array(    
                'status'=>true,  
                'data' => array(
                    'topstatus' => $result['PD_LEVEL'],
                    'condition' => $condition,      
                    'lokal_remote' => $lr,
                    'total_beban' => array(
                        'phasa_r' => '',
                        'phasa_s' => '',
                        'phasa_t' => '',
                        'tegangan' => ''
                    ),
                    'gi' => $gi->dcGarduInduk['GARDU_INDUK_NAMA'],
                    'incoming_name' => $gi['INCOMING_NAME'],
                    'combine_gardu_dan_incoming' =>'GI '. $gi->dcGarduInduk['GARDU_INDUK_NAMA'].' Incoming '.$gi['INCOMING_NAME'],
                    'temperatur_a' =>$gi['TEMP_A'],
                    'temperatur_b' =>$gi['TEMP_B'],
                    'temperatur_c' =>$gi['TEMP_C'],
                    'history_pd' => $history_pd,
                    'history_pmt' => $history_pmt,
                    'history_asset' => $history_asset,
                ), 
                'status_code' => 200
            ));
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
