<?php

namespace App\Http\Controllers\Api;

use App\ews_inspeksi_aset as AppEws_inspeksi_aset;
use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\ews_inspeksi_aset;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class EwsInspeksiAsetController extends Controller
{
    //
    public function list(Request $request){
        if (auth('sanctum')->check()){   
            $result = 
            ews_inspeksi_aset::orderBy('ews_inspeksi_aset.id_inspeksi_aset','DESC')
            ->join('dc_cubicle','dc_cubicle.OUTGOING_ID','ews_inspeksi_aset.id_outgoing')
            ->join('users','users.id','ews_inspeksi_aset.id_user')
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','ews_inspeksi_aset.id_gardu_induk')
            ->select(['ews_inspeksi_aset.*']) 
            ;
            $m = now()->month;
            $y = now()->year; 
            $result = $result->whereMonth('TGL_OPERASI_PMT','=', $m)->whereYear('TGL_OPERASI_PMT','=', $y);
  
            if($request->id_outgoing){
                $keyword = $request->get('id_outgoing');    
                $result = $result->where('ews_inspeksi_aset.id_outgoing', 'LIKE','%' .$keyword . '%') ;
            }
            if($request->id_gardu_induk){
                $keyword = $request->get('id_gardu_induk');    
                $result = $result->where('ews_inspeksi_aset.id_gardu_induk', $keyword ) ;
            } 

            $result = $result->paginate(10); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function FormInput(Request $request, $id){
        try{ 
            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                // 'tgl_inspeksi' => 'nullable|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(), 
            ]); 
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 500); 
            } 
            $cubicle = Dc_cubicle::where('OUTGOING_ID',$id)->first();

            $inspectAsset = new ews_inspeksi_aset();

            $inspectAsset->id_outgoing = $cubicle['OUTGOING_ID'] ;
            $inspectAsset->id_user = Auth::user()->id;
            $inspectAsset->id_gardu_induk = $cubicle->dcIncomingFeeder->GARDU_INDUK_ID;
            $inspectAsset->tgl_entry = Carbon::createFromFormat($this->global->date_format , $request->tgl_entry)->format('Y-m-d H:i:s');   
            $inspectAsset->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s');
            $inspectAsset->body_cubicle = $request->body_cubicle;
            $inspectAsset->lv = $request->lv;
            $inspectAsset->cb = $request->cb;
            $inspectAsset->busbar = $request->busbar;
            $inspectAsset->power_cable = $request->power_cable;
            $inspectAsset->pmt_cb = $request->pmt_cb;
            $inspectAsset->announ = $request->announ;
            $inspectAsset->ind_lamp = $request->ind_lamp;
            $inspectAsset->ind_volt = $request->ind_volt;
            $inspectAsset->ac220 = $request->ac220;
            $inspectAsset->dc110 = $request->dc110;
            $inspectAsset->desis = $request->desis;
            $inspectAsset->dengung = $request->dengung;  
            $inspectAsset->ngeter = $request->ngeter;
            $inspectAsset->flash = $request->flash;
            $inspectAsset->sangit = $request->sangit;
            $inspectAsset->amis = $request->amis;
            $inspectAsset->feeder = $request->feeder;
            $inspectAsset->kubikel = $request->kubikel;
            $inspectAsset->pmt = $request->pmt;
            $inspectAsset->grounding = $request->grounding;
            $inspectAsset->sangit2 = $request->sangit2;
            $inspectAsset->slr = $request->slr;
            $inspectAsset->sar = $request->sar;
            $inspectAsset->body_alat = $request->body_alat;
            $inspectAsset->wiring = $request->wiring;
            $inspectAsset->w_prot = $request->w_prot;
            $inspectAsset->w_meter = $request->w_meter;
            $inspectAsset->w_acc = $request->w_acc;
            $inspectAsset->relay_ready = $request->relay_ready;
            $inspectAsset->relay_display = $request->relay_display;
            $inspectAsset->relay_mr = $request->relay_mr;
            $inspectAsset->relay_ms = $request->relay_ms;
            $inspectAsset->relay_mt = $request->relay_mt;
            $inspectAsset->pm_display = $request->pm_display;
            $inspectAsset->pm_mr = $request->pm_mr;
            $inspectAsset->pm_ms = $request->pm_ms;
            $inspectAsset->pm_mt = $request->pm_mt;
            $inspectAsset->kwh_meter = $request->kwh_meter;
            $inspectAsset->panel_rtu = $request->panel_rtu;
            $inspectAsset->door = $request->door;
            $inspectAsset->fan = $request->fan;
            $inspectAsset->lampu_panel = $request->lampu_panel;
            $inspectAsset->grounding_rtu = $request->grounding_rtu;
            $inspectAsset->temp_panel = $request->temp_panel;
            $inspectAsset->kebersihan = $request->kebersihan;
            $inspectAsset->power_on = $request->power_on;
            $inspectAsset->led_txrx = $request->led_txrx;
            $inspectAsset->ethernet = $request->ethernet;
            $inspectAsset->keterangan = $request->keterangan;
            $inspectAsset->id_update = $request->id_update;
            $inspectAsset->last_update = Carbon::createFromFormat($this->global->date_format , $request->last_update)->format('Y-m-d H:i:s') ; 
    
    
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
