<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_incoming_feeder;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcIncomingFeederController extends Controller
{
    //
    public function index(Request $request)
    {
        try{
            $result =Dc_incoming_feeder::orderBy('INCOMING_ID','DESC');
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID', $keyword );  
            }
            if ($request->get('INCOMING_NAME'))
            {
                $keyword = $request->get('INCOMING_NAME');    
                $result = $result->where('INCOMING_NAME', 'LIKE', "%{$keyword}%" );  
            }
            if ($request->get('MERK_TRAFO'))
            {
                $keyword = $request->get('MERK_TRAFO');    
                $result = $result->where('MERK_TRAFO', 'LIKE', "%{$keyword}%"  );  
            }  
            return response()->json(array( 
                'status' => true, 
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
    public function single($id){

    }
}
