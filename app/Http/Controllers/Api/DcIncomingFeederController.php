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
        // $get_data=isset($_POST['data']); 
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
            $result = Dc_incoming_feeder::orderBy('INCOMING_ID','DESC')->paginate(12);
        } 
        $total_records=Dc_incoming_feeder::count(); 
        return ApiResponse::make(array(            
            'data' => $result,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }
}
