<?php

namespace App\Http\Controllers\Api;

use App\Helper\Files;
use App\Http\Controllers\Controller;
use App\Models\Dc_Inspeksi_Penyulang;
use Carbon\Carbon;
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
            if ($request->get('OUTGOING_ID'))
            {
                $keyword = $request->get('OUTGOING_ID');    
                $result = Dc_Inspeksi_Penyulang::where('OUTGOING_ID', 'LIKE', "%{$keyword}%" )->orderBy('ID','DESC')->paginate(12);  
            }
             
            else
            {
                $result = Dc_Inspeksi_Penyulang::orderBy('id','DESC')->paginate(12);
            } 
            $total_records=Dc_Inspeksi_Penyulang::count(); 
            return response()->json(array(   
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $setting = global_setting();
        $validator = Validator::make($request->all(), [
            'tgl_inspeksi' => 'nullable|date_format:"' . $setting->date_format . '"|before_or_equal:'.now($setting->timezone)->toDateString(),
            'foto_pelakasanaan' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'foto_cek_output_level_pd' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
        ]); 
        if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()
        ], 500); 
        } 
        $foto_pelakasanaan = $request->file('foto_pelakasanaan'); 
        $storeuploadfoto_pelakasanaan = Files::uploadLocalOrS3(request()->foto_pelakasanaan, 'inspect');

        $foto_pelakasanaanResponse = array(
            "image_name" => basename($storeuploadfoto_pelakasanaan),
            "image_url" => asset('user-uploads/inspect/'. basename($storeuploadfoto_pelakasanaan)),
            "mime" => $foto_pelakasanaan->getClientMimeType()
        );

        $foto_cek_output_level_pd = $request->file('foto_cek_output_level_pd'); 
        $storeuploadfoto_cek_output_level_pd = Files::uploadLocalOrS3(request()->foto_cek_output_level_pd, 'inspect'); 
        $foto_cek_output_level_pdResponse = array(
            "image_name" => basename($storeuploadfoto_cek_output_level_pd),
            "image_url" => asset('user-uploads/inspect/'. basename($storeuploadfoto_cek_output_level_pd)),
            "mime" => $foto_cek_output_level_pd->getClientMimeType()
        );




        
        $inspectPenyulang = new Dc_Inspeksi_Penyulang();
        $inspectPenyulang->OUTGOING_ID = $request->OUTGOING_ID;
        $inspectPenyulang->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s');
        $inspectPenyulang->body_cubicle = $request->body_cubicle;
        $inspectPenyulang->lv_compartment = $request->lv_compartment;
        $inspectPenyulang->cb_compartment = $request->cb_compartment;
        $inspectPenyulang->busbar_compartment = $request->busbar_compartment;
        $inspectPenyulang->kabel_power_compartment = $request->kabel_power_compartment;
        $inspectPenyulang->pmt_cb20kv = $request->pmt_cb20kv;
        $inspectPenyulang->annoinciater = $request->annoinciater;
        $inspectPenyulang->lampu_indikasi = $request->lampu_indikasi;
        $inspectPenyulang->indikasi_tegangan_cvd = $request->indikasi_tegangan_cvd;
        $inspectPenyulang->supply_ac220v = $request->supply_ac220v;
        $inspectPenyulang->supply_dc110v = $request->supply_dc110v;
        $inspectPenyulang->suara_desis = $request->suara_desis;
        $inspectPenyulang->suara_dengung = $request->suara_dengung;
        $inspectPenyulang->suara_ngeter = $request->suara_ngeter;
        $inspectPenyulang->flash_over = $request->flash_over;
        $inspectPenyulang->bau_sangit = $request->bau_sangit;
        $inspectPenyulang->bau_amis = $request->bau_amis;
        $inspectPenyulang->feeder_st_cb20kv = $request->feeder_st_cb20kv;
        $inspectPenyulang->kubikel_st_cb20kv = $request->kubikel_st_cb20kv;
        $inspectPenyulang->pmt_st_cb20kv = $request->pmt_st_cb20kv;
        $inspectPenyulang->grounding_st_cb20kv = $request->grounding_st_cb20kv;
        $inspectPenyulang->bau_sangit_st_cb20kv = $request->bau_sangit_st_cb20kv;
        $inspectPenyulang->switch_local_remote_st_cb20kv = $request->switch_local_remote_st_cb20kv;
        $inspectPenyulang->switch_auto_reclose_st_cb20kv = $request->switch_auto_reclose_st_cb20kv;
        $inspectPenyulang->body_peralatan = $request->body_peralatan;
        $inspectPenyulang->kabel_wiring = $request->kabel_wiring;
        $inspectPenyulang->kondisi_wiring_proteksi = $request->kondisi_wiring_proteksi;
        $inspectPenyulang->kondisi_wiring_metering = $request->kondisi_wiring_metering;
        $inspectPenyulang->kondisi_wiring_aksesories = $request->kondisi_wiring_aksesories;
        $inspectPenyulang->lampu_indikasi_rele_ready = $request->lampu_indikasi_rele_ready;
        $inspectPenyulang->display_rele_proteksi = $request->display_rele_proteksi;
        $inspectPenyulang->display_rele_proteksi_phasa_s = $request->display_rele_proteksi_phasa_s;
        $inspectPenyulang->display_rele_proteksi_phasa_r = $request->display_rele_proteksi_phasa_r;
        $inspectPenyulang->display_rele_proteksi_phasa_t = $request->display_rele_proteksi_phasa_t;
        $inspectPenyulang->penunjukan_power_meter = $request->penunjukan_power_meter;
        $inspectPenyulang->penunjukan_power_meter_phasa_s = $request->penunjukan_power_meter_phasa_s;
        $inspectPenyulang->penunjukan_power_meter_phasa_r = $request->penunjukan_power_meter_phasa_r;
        $inspectPenyulang->penunjukan_power_meter_phasa_t = $request->penunjukan_power_meter_phasa_t;
        $inspectPenyulang->kwh_meter_kubel = $request->kwh_meter_kubel;
        $inspectPenyulang->kebersihan_panel_rtu = $request->kebersihan_panel_rtu;
        $inspectPenyulang->door_close = $request->door_close;
        $inspectPenyulang->exhaust_fan = $request->exhaust_fan;
        $inspectPenyulang->lampu_panel = $request->lampu_panel;
        $inspectPenyulang->grounding = $request->grounding;
        $inspectPenyulang->display_temperature_panel = $request->display_temperature_panel;
        $inspectPenyulang->kebersihan_peralatan = $request->kebersihan_peralatan;
        $inspectPenyulang->indikasi_power_on = $request->indikasi_power_on;
        $inspectPenyulang->indeksi_led_tx_tx = $request->indeksi_led_tx_tx;
        $inspectPenyulang->kondisi_kabel_ethernet = $request->kondisi_kabel_ethernet;
        /* image */
        $inspectPenyulang->foto_pelakasanaan = json_encode($foto_pelakasanaanResponse);
        $inspectPenyulang->foto_cek_output_level_pd = json_encode($foto_cek_output_level_pdResponse);


        $inspectPenyulang->save();
 
        return response()->json(array(   
            'status'=>true,         
            'data' => $inspectPenyulang, 
            'status_code' => 200
        )); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
