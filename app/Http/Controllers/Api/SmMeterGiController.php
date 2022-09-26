<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sm_meter_gi;
use Carbon\Carbon;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class SmMeterGiController extends Controller
{
    public function index(Request $request)
    { try{

            if ($request->get('IA_TIME_FROM') && !empty($request->get('IA_TIME_TO')))
                {
                    $from = Carbon::parse($request->get('IA_TIME_FROM'))->toDateTimeString();    
                    $to = Carbon::parse($request->get('IA_TIME_TO'))->toDateTimeString();    
                    $result = Sm_meter_gi::
                    whereBetween('IA_TIME',[$from,$to]) 
                    ->orderBy('OUTGOING_METER_ID','ASC')->paginate(10);  
                } 
            elseif ($request->get('IB_TIME_FROM') && !empty($request->get('IB_TIME_TO')))
                {
                    $from = Carbon::parse($request->get('IB_TIME_FROM'))->toDateTimeString();    
                    $to = Carbon::parse($request->get('IB_TIME_TO'))->toDateTimeString();    
                    $result = Sm_meter_gi::
                    whereBetween('IB_TIME',[$from,$to]) 
                    ->orderBy('OUTGOING_METER_ID','ASC')->paginate(10);  
                } 
            elseif ($request->get('IC_TIME_FROM') && !empty($request->get('IC_TIME_TO')))
                {
                    $from = Carbon::parse($request->get('IC_TIME_FROM'))->toDateTimeString();    
                    $to = Carbon::parse($request->get('IC_TIME_TO'))->toDateTimeString();    
                    $result = Sm_meter_gi::
                    whereBetween('IC_TIME',[$from,$to]) 
                    ->orderBy('OUTGOING_METER_ID','ASC')->paginate(10);  
                } 
            elseif ($request->get('IN_TIME_FROM') && !empty($request->get('IN_TIME_TO')))
                {
                    $from = Carbon::parse($request->get('IN_TIME_FROM'))->toDateTimeString();    
                    $to = Carbon::parse($request->get('IN_TIME_TO'))->toDateTimeString();    
                    $result = Sm_meter_gi::
                    whereBetween('IN_TIME',[$from,$to]) 
                    ->orderBy('OUTGOING_METER_ID','ASC')->paginate(10);  
                } 
            else
                {
                    $result = Sm_meter_gi::orderBy('OUTGOING_METER_ID','DESC')->paginate(10);
                } 
            // $total_records=Sm_meter_gi::count(); 
            return ApiResponse::make(array(  
                'status'=>true,          
                'data' => $result,
                // 'total_records' => $total_records,
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
