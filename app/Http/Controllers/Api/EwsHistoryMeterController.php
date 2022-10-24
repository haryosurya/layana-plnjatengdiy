<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ews_history_meter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class EwsHistoryMeterController extends Controller
{
    //
    public function ListEwsHistoryMeter(Request $request){
        //
        try{ 
            $result = Ews_history_meter::orderBy('history_ews_id','DESC');
            if ($request->get('outgoing_id'))
            {
                $keyword = $request->get('outgoing_id');    
                $result = $result->where('outgoing_id', 'LIKE', "%{$keyword}%" );  
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

    public function storeEwsHistoryMeter(Request $request){
        //
        try{ 
            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                'outgoing_id' => 'required',
                'temp_A_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'temp_B_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'temp_C_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'humid_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(), 
            ]); 
            if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 500); 
            }  
            $EwsHistoryMeter = new Ews_history_meter();
            $EwsHistoryMeter->outgoing_id = $request->outgoing_id;
            $EwsHistoryMeter->temp_A =  $request->temp_A ;
            $EwsHistoryMeter->temp_A_time = Carbon::createFromFormat($this->global->date_format , $request->temp_A_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->temp_B =  $request->temp_B ;
            $EwsHistoryMeter->temp_B_time = Carbon::createFromFormat($this->global->date_format , $request->temp_B_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->temp_C =  $request->temp_C ;
            $EwsHistoryMeter->temp_C_time = Carbon::createFromFormat($this->global->date_format , $request->temp_C_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->humid =  $request->humid ;
            $EwsHistoryMeter->humid_time = Carbon::createFromFormat($this->global->date_format , $request->humid_time)->format('Y-m-d H:i:s'); 
            $EwsHistoryMeter->save();
            // DB::commit();
            return response()->json(array(   
                'status'=>true,         
                'data' => $EwsHistoryMeter, 
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

    public function updateEwsHistoryMeter(Request $request,$id ){
        //
        try{  
            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                // 'ews_meter_id' => 'required',
                'outgoing_id' => 'required',
                'temp_A_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'temp_B_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'temp_C_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'humid_time' => 'required|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(), 
            ]); 


            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 500); 
            }  
            $EwsHistoryMeter = Ews_history_meter::findOrFail($id);    
            $EwsHistoryMeter->outgoing_id = $request->outgoing_id;
            $EwsHistoryMeter->temp_A =  $request->temp_A ;
            $EwsHistoryMeter->temp_A_time = Carbon::createFromFormat($this->global->date_format , $request->temp_A_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->temp_B =  $request->temp_B ;
            $EwsHistoryMeter->temp_B_time = Carbon::createFromFormat($this->global->date_format , $request->temp_B_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->temp_C =  $request->temp_C ;
            $EwsHistoryMeter->temp_C_time = Carbon::createFromFormat($this->global->date_format , $request->temp_C_time)->format('Y-m-d H:i:s');
            $EwsHistoryMeter->humid =  $request->humid ;
            $EwsHistoryMeter->humid_time = Carbon::createFromFormat($this->global->date_format , $request->humid_time)->format('Y-m-d H:i:s');  
            $EwsHistoryMeter->save();
            return response()->json(array(   
                'status'=>true,         
                'data' => $EwsHistoryMeter, 
                'status_code' => 200
            ));  
             
        }
        catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function destroyEwsHistoryMeter($id)
    {
        //
        try{   
            $get = Ews_history_meter::find($id);
            if(!empty($get)){ 
                Ews_history_meter::destroy($id); 
                return response()->json(array(   
                    'status'=>true,     
                    'message' => 'success', 
                    'status_code' => 200
                ));  
            }
            return response()->json(array(   
                'status'=>true,     
                'message' => 'file not found', 
                'status_code' => 500
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
