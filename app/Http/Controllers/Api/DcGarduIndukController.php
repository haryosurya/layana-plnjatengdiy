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
            $result = Dc_gardu_induk::orderBy('GARDU_INDUK_ID','DESC')->join('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID');  
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
            $total_records=Dc_gardu_induk::count(); 
            return response()->json(array(  
                'status'=>true,          
                'data' => $result->paginate(12),
                'total_records' => $total_records,
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
