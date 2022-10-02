<?php

namespace App\Http\Controllers\Api;

use App\Helper\Files;
use App\Http\Controllers\Controller;
use App\Models\Dc_inspeksi_asset;
use App\Models\Dc_inspeksi_pd;
use App\Models\Dc_Inspeksi_Penyulang;
use App\Models\Ews_history_meter;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DcInspeksiPenyulangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try{ 
            $result = Dc_inspeksi_asset::orderBy('id','DESC');
            if ($request->get('OUTGOING_ID'))
            {
                $keyword = $request->get('OUTGOING_ID');    
                $result = $result->where('OUTGOING_ID', 'LIKE', "%{$keyword}%" );  
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
    public function store(Request $request)
    {
        //
        try{

            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                'tgl_inspeksi' => 'nullable|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'foto_pelaksanaan' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
                'foto_asset' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]); 
            if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 500); 
            } 
            $foto_pelaksanaan = $request->file('foto_pelaksanaan'); 
            $storeuploadfoto_pelaksanaan = Files::uploadLocalOrS3(request()->foto_pelaksanaan, 'inspect');
    
            $foto_pelaksanaanResponse = array(
                "image_name" => basename($storeuploadfoto_pelaksanaan),
                "image_url" => asset('user-uploads/inspect/'. basename($storeuploadfoto_pelaksanaan)),
                "mime" => $foto_pelaksanaan->getClientMimeType()
            );
    
            $foto_asset = $request->file('foto_asset'); 
            $storeuploadfoto_asset = Files::uploadLocalOrS3(request()->foto_asset, 'inspect'); 
            $foto_assetResponse = array(
                "image_name" => basename($storeuploadfoto_asset),
                "image_url" => asset('user-uploads/inspect/'. basename($storeuploadfoto_asset)),
                "mime" => $foto_asset->getClientMimeType()
            );
    
     
            $inspectAsset = new Dc_inspeksi_asset();
            $inspectAsset->OUTGOING_ID = $request->OUTGOING_ID;
            $inspectAsset->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s');
            $inspectAsset->body_cubicle = $request->body_cubicle;
            $inspectAsset->lv_compartment = $request->lv_compartment;
            $inspectAsset->cb_compartment = $request->cb_compartment;
            $inspectAsset->busbar_compartment = $request->busbar_compartment;
            $inspectAsset->kabel_power_compartment = $request->kabel_power_compartment;
            $inspectAsset->pmt_cb20kv = $request->pmt_cb20kv;
            $inspectAsset->annoinciater = $request->annoinciater;
            $inspectAsset->lampu_indikasi = $request->lampu_indikasi;
            $inspectAsset->indikasi_tegangan_cvd = $request->indikasi_tegangan_cvd;
            $inspectAsset->supply_ac220v = $request->supply_ac220v;
            $inspectAsset->supply_dc110v = $request->supply_dc110v;
            $inspectAsset->suara_desis = $request->suara_desis;
            $inspectAsset->suara_dengung = $request->suara_dengung;
            $inspectAsset->suara_ngeter = $request->suara_ngeter;
            $inspectAsset->flash_over = $request->flash_over;
            $inspectAsset->bau_sangit = $request->bau_sangit;
            $inspectAsset->bau_amis = $request->bau_amis;
            $inspectAsset->feeder_st_cb20kv = $request->feeder_st_cb20kv;
            $inspectAsset->kubikel_st_cb20kv = $request->kubikel_st_cb20kv;
            $inspectAsset->pmt_st_cb20kv = $request->pmt_st_cb20kv;
            $inspectAsset->grounding_st_cb20kv = $request->grounding_st_cb20kv;
            $inspectAsset->bau_sangit_st_cb20kv = $request->bau_sangit_st_cb20kv;
            $inspectAsset->switch_local_remote_st_cb20kv = $request->switch_local_remote_st_cb20kv;
            $inspectAsset->switch_auto_reclose_st_cb20kv = $request->switch_auto_reclose_st_cb20kv;
            $inspectAsset->body_peralatan = $request->body_peralatan;
            $inspectAsset->kabel_wiring = $request->kabel_wiring;
            $inspectAsset->kondisi_wiring_proteksi = $request->kondisi_wiring_proteksi;
            $inspectAsset->kondisi_wiring_metering = $request->kondisi_wiring_metering;
            $inspectAsset->kondisi_wiring_aksesories = $request->kondisi_wiring_aksesories;
            $inspectAsset->lampu_indikasi_rele_ready = $request->lampu_indikasi_rele_ready;
            $inspectAsset->display_rele_proteksi = $request->display_rele_proteksi;
            $inspectAsset->display_rele_proteksi_phasa_s = $request->display_rele_proteksi_phasa_s;
            $inspectAsset->display_rele_proteksi_phasa_r = $request->display_rele_proteksi_phasa_r;
            $inspectAsset->display_rele_proteksi_phasa_t = $request->display_rele_proteksi_phasa_t;
            $inspectAsset->penunjukan_power_meter = $request->penunjukan_power_meter;
            $inspectAsset->penunjukan_power_meter_phasa_s = $request->penunjukan_power_meter_phasa_s;
            $inspectAsset->penunjukan_power_meter_phasa_r = $request->penunjukan_power_meter_phasa_r;
            $inspectAsset->penunjukan_power_meter_phasa_t = $request->penunjukan_power_meter_phasa_t;
            $inspectAsset->kwh_meter_kubel = $request->kwh_meter_kubel;
            $inspectAsset->kebersihan_panel_rtu = $request->kebersihan_panel_rtu;
            $inspectAsset->door_close = $request->door_close;
            $inspectAsset->exhaust_fan = $request->exhaust_fan;
            $inspectAsset->lampu_panel = $request->lampu_panel;
            $inspectAsset->grounding = $request->grounding;
            $inspectAsset->display_temperature_panel = $request->display_temperature_panel;
            $inspectAsset->kebersihan_peralatan = $request->kebersihan_peralatan;
            $inspectAsset->indikasi_power_on = $request->indikasi_power_on;
            $inspectAsset->indeksi_led_tx_rx = $request->indeksi_led_tx_rx;
            $inspectAsset->kondisi_kabel_ethernet = $request->kondisi_kabel_ethernet;
            /* image */
            $inspectAsset->foto_pelaksanaan = json_encode($foto_pelaksanaanResponse);
            $inspectAsset->foto_asset = json_encode($foto_assetResponse);
    
    
            $inspectAsset->save();
     
            return response()->json(array(   
                'status'=>true,         
                'data' => $inspectAsset, 
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
    public function ListEwsInspeksiPd(Request $request){
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

    public function storeEwsInspeksiPd(Request $request){
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
            $EwsInspeksiPd = new Ews_history_meter();
            $EwsInspeksiPd->outgoing_id = $request->outgoing_id;
            $EwsInspeksiPd->temp_A =  $request->temp_A ;
            $EwsInspeksiPd->temp_A_time = Carbon::createFromFormat($this->global->date_format , $request->temp_A_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->temp_B =  $request->temp_B ;
            $EwsInspeksiPd->temp_B_time = Carbon::createFromFormat($this->global->date_format , $request->temp_B_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->temp_C =  $request->temp_C ;
            $EwsInspeksiPd->temp_C_time = Carbon::createFromFormat($this->global->date_format , $request->temp_C_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->humid =  $request->humid ;
            $EwsInspeksiPd->humid_time = Carbon::createFromFormat($this->global->date_format , $request->humid_time)->format('Y-m-d H:i:s'); 
            $EwsInspeksiPd->save();
            // DB::commit();
            return response()->json(array(   
                'status'=>true,         
                'data' => $EwsInspeksiPd, 
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

    public function updateEwsInspeksiPd(Request $request,$id ){
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
            $EwsInspeksiPd = Ews_history_meter::findOrFail($id);    
            $EwsInspeksiPd->outgoing_id = $request->outgoing_id;
            $EwsInspeksiPd->temp_A =  $request->temp_A ;
            $EwsInspeksiPd->temp_A_time = Carbon::createFromFormat($this->global->date_format , $request->temp_A_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->temp_B =  $request->temp_B ;
            $EwsInspeksiPd->temp_B_time = Carbon::createFromFormat($this->global->date_format , $request->temp_B_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->temp_C =  $request->temp_C ;
            $EwsInspeksiPd->temp_C_time = Carbon::createFromFormat($this->global->date_format , $request->temp_C_time)->format('Y-m-d H:i:s');
            $EwsInspeksiPd->humid =  $request->humid ;
            $EwsInspeksiPd->humid_time = Carbon::createFromFormat($this->global->date_format , $request->humid_time)->format('Y-m-d H:i:s');  
            $EwsInspeksiPd->save();
            return response()->json(array(   
                'status'=>true,         
                'data' => $EwsInspeksiPd, 
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
    public function destroyEwsInspeksiPd($id)
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
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function indexInspeksiPd(Request $request)
    {
        //
        try{ 
            $result = Dc_inspeksi_pd::orderBy('id','DESC');
            if ($request->get('OUTGOING_ID'))
            {
                $keyword = $request->get('OUTGOING_ID');    
                $result = $result->where('OUTGOING_ID', 'LIKE', "%{$keyword}%" );  
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

    public function storeInspeksiPd(Request $request)
    {
        //
        try{

            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                'tgl_inspeksi' => 'nullable|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
                'foto_pelaksanaan' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
                'foto_output_level' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]); 
            if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 500); 
            } 
            $foto_pelaksanaan = $request->file('foto_pelaksanaan'); 
            $storeuploadfoto_pelaksanaan = Files::uploadLocalOrS3(request()->foto_pelaksanaan, 'pd');
    
            $foto_pelaksanaanResponse = array(
                "image_name" => basename($storeuploadfoto_pelaksanaan),
                "image_url" => asset('user-uploads/pd/'. basename($storeuploadfoto_pelaksanaan)),
                "mime" => $foto_pelaksanaan->getClientMimeType()
            );
    
            $foto_output_level = $request->file('foto_output_level'); 
            $storeuploadfoto_output_level = Files::uploadLocalOrS3(request()->foto_output_level, 'pd'); 
            $foto_output_levelResponse = array(
                "image_name" => basename($storeuploadfoto_output_level),
                "image_url" => asset('user-uploads/pd/'. basename($storeuploadfoto_output_level)),
                "mime" => $foto_output_level->getClientMimeType()
            );
    
     
            $inspectAsset = new Dc_inspeksi_pd();
            $inspectAsset->OUTGOING_ID = $request->OUTGOING_ID;
            $inspectAsset->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s'); 
            $inspectAsset->critical_pd = $request->critical_pd;
            $inspectAsset->ket_pelaksanaan = $request->ket_pelaksanaan;
            $inspectAsset->level_partial = $request->level_partial;
            /* image */
            $inspectAsset->foto_pelaksanaan = json_encode($foto_pelaksanaanResponse);
            $inspectAsset->foto_output_level = json_encode($foto_output_levelResponse);
    
    
            $inspectAsset->save();
     
            return response()->json(array(   
                'status'=>true,         
                'data' => $inspectAsset, 
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
