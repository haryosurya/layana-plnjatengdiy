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
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = Dc_incoming_feeder::where('GARDU_INDUK_ID', 'LIKE', "%{$keyword}%" )->orderBy('INCOMING_ID','DESC')->paginate(12);  
            }
            if ($request->get('INCOMING_NAME'))
            {
                $keyword = $request->get('INCOMING_NAME');    
                $result = Dc_incoming_feeder::where('INCOMING_NAME', 'LIKE', "%{$keyword}%" )->orderBy('INCOMING_ID','DESC')->paginate(12);  
            }
            if ($request->get('MERK_TRAFO'))
            {
                $keyword = $request->get('MERK_TRAFO');    
                $result = Dc_incoming_feeder::where('MERK_TRAFO', 'LIKE', "%{$keyword}%"  )->orderBy('INCOMING_ID','DESC')->paginate(12);  
            }
            else
            {
                $result = Dc_incoming_feeder::orderBy('INCOMING_ID','DESC') 
                ->select('dc_incoming_feeder.INCOMING_ID')
                ->paginate(12);
            } 
            $data = [];
            foreach($result as $r){
                $id = $r['INCOMING_ID'];
                $name = $r['INCOMING_ID'];

            }
            $total_records=Dc_incoming_feeder::count(); 
            return response()->json(array( 
                'status' => true, 
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
    public function single($id){

    }
}
