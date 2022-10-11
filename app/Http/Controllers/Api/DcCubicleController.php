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
            if ($request->get('CUBICLE_NAME')) 
            {
                $keyword = $request->get('CUBICLE_NAME');    
                
                $result = Dc_cubicle::where('CUBICLE_NAME', $keyword ) 
                ->join('Dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
                ->leftJoin('dc_gardu_induk','Dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
                ->select('dc_cubicle.OUTGOING_ID','dc_cubicle.CUBICLE_NAME','dc_cubicle.PD_CRITICAL','dc_gardu_induk.GARDU_INDUK_NAMA') 
                
                ->orderBy('OUTGOING_ID','ASC')->paginate(12);  
            }
            else
            {
                $result = Dc_cubicle::orderBy('OUTGOING_ID','ASC')  
                ->join('Dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
                ->leftJoin('dc_gardu_induk','Dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
                ->select('dc_cubicle.OUTGOING_ID','dc_cubicle.CUBICLE_NAME','dc_cubicle.PD_LEVEL','dc_cubicle.PD_CRITICAL','dc_gardu_induk.GARDU_INDUK_NAMA') 
                ->paginate(12);
            } 
            $total_records=Dc_cubicle::count(); 
            return response()->json(array(    
                'status'=>true,        
                'data' => array(
                    'result' => $result,
                    'total_records' => $total_records,
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
            $history_pd = ews_inspeksi_pd::where('id_outgoing',$id) ->orderBy('id_inspeksi_pd','DESC')->firstorFail(); 
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)->orderBy('OUTGOING_METER_ID','DESC')->firstorFail();
            $history_asset = ews_inspeksi_aset::where('id_outgoing',$id)->orderBy('id_inspeksi_aset','DESC')->firstorFail();
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
}
