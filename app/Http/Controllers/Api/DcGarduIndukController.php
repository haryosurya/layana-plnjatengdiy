<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_gardu_induk;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcGarduIndukController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $result = Dc_gardu_induk::orderBy('GARDU_INDUK_ID','DESC')
            ->join('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')
            ->leftJoin('dc_incoming_feeder','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')
            ->selectRaw(
                'dc_gardu_induk.*, count(dc_incoming_feeder.INCOMING_ID) as TOTAL_INCOMING'
            )
            ->groupBy('dc_gardu_induk.GARDU_INDUK_ID')
            ;  
            if ($request->get('APJ_ID'))  
            {
                $keyword = $request->get('APJ_ID');   
                $result =$result->where('dc_apj.APJ_ID', $keyword ) ;
            } 
            
            if ($request->get('APJ_DCC'))  
            {
                $keyword = $request->get('APJ_DCC');   
                $result =$result->where('APJ_DCC', $keyword ) ;
            } 

            if ($request->get('GARDU_INDUK_NAMA'))  
            {
                $keyword = $request->get('GARDU_INDUK_NAMA');   
                $result =$result->where('GARDU_INDUK_NAMA', $keyword ) ;
            }  
            return response()->json(array(  
                'status'=>true,          
                'data' => $result->paginate(12), 
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
