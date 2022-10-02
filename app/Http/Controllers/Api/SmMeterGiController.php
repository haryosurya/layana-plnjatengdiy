<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sm_meter_gi;
use Auth;
use Carbon\Carbon;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class SmMeterGiController extends Controller
{
    public function index(Request $request)
    { 
        
        if(auth('sanctum')->check() == true){ 

            try{
                $result = Sm_meter_gi::orderBy('OUTGOING_METER_ID','DESC');
                if ($request->get('IA_TIME_FROM') && !empty($request->get('IA_TIME_TO')))
                    {
                        $from = Carbon::parse($request->get('IA_TIME_FROM'))->toDateTimeString();    
                        $to = Carbon::parse($request->get('IA_TIME_TO'))->toDateTimeString();    
                        $result = $result-> whereBetween('IA_TIME',[$from,$to]);  
                    } 
                if ($request->get('IB_TIME_FROM') && !empty($request->get('IB_TIME_TO')))
                    {
                        $from = Carbon::parse($request->get('IB_TIME_FROM'))->toDateTimeString();    
                        $to = Carbon::parse($request->get('IB_TIME_TO'))->toDateTimeString();    
                        $result = $result-> whereBetween('IB_TIME',[$from,$to]) ;  
                    } 
                if ($request->get('IC_TIME_FROM') && !empty($request->get('IC_TIME_TO')))
                    {
                        $from = Carbon::parse($request->get('IC_TIME_FROM'))->toDateTimeString();    
                        $to = Carbon::parse($request->get('IC_TIME_TO'))->toDateTimeString();    
                        $result = $result-> whereBetween('IC_TIME',[$from,$to])  ;  
                    } 
                if ($request->get('IN_TIME_FROM') && !empty($request->get('IN_TIME_TO')))
                    {
                        $from = Carbon::parse($request->get('IN_TIME_FROM'))->toDateTimeString();    
                        $to = Carbon::parse($request->get('IN_TIME_TO'))->toDateTimeString();    
                        $result = $result-> whereBetween('IN_TIME',[$from,$to])  ;  
                    }  
                $result = $result->paginate(10);
                // $total_records=Sm_meter_gi::count(); 
                return response()->json(array(  
                    'status'=>true,          
                    'data' => $result, 
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
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
}
