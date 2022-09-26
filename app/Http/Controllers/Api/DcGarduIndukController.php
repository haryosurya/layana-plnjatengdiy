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
            if ($request->get('GARDU_INDUK_NAMA'))  
            {
                $keyword = $request->get('GARDU_INDUK_NAMA');    
                $result = Dc_gardu_induk::where('GARDU_INDUK_NAMA', $keyword )->orderBy('GARDU_INDUK_ID','DESC')->paginate(12);  
            }
            else
            {
                $result = Dc_gardu_induk::orderBy('GARDU_INDUK_ID','DESC')->paginate(12);
            } 
            $total_records=Dc_gardu_induk::count(); 
            return ApiResponse::make(array(  
                'status'=>true,          
                'data' => $result,
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
