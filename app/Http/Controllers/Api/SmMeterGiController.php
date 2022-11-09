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
                $history_pmt = Sm_meter_gi::orderBy('OUTGOING_METER_ID','DESC')
                ->orderBy('IA_TIME','DESC')
                ->take('100') 
                ->select('IA','IB','IC','IN','IA_TIME')  
                ;
                if ($request->get('date'))
                {
                    $keyword = $request->get('date');    
                    $history_pmt = $history_pmt
                    ->whereDate('IA_TIME', date('Y-m-d', strtotime( $keyword ))) 
                    ;
                }
                else
                {
                    $history_pmt = $history_pmt
                    -> latest('IA_TIME') 
                    ;
                } 
                if ($request->get('OUTGOING_ID') && !empty($request->get('OUTGOING_ID')))
                    {    
                        $history_pmt = $history_pmt-> where('OUTGOING_ID',$request->get('OUTGOING_ID'));  
                    }  
                $result = $history_pmt->paginate(10);
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
