<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\EwsInspeksiPdDatatable;
use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\ews_inspeksi_aset;
use App\Models\ews_inspeksi_pd;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Validator;

class EwsInspeksiPdController extends AccountBaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.inspeksi-pd'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_inspeksi_pd') == 'all'));
            abort_403(!(in_array('inspeksi-pd', user_modules())) );

            return $next($request);
        });
    }
    public function index(EwsInspeksiPdDatatable $dataTable)
    {
        //
        $this->dcc = Dc_apj::get();
        $this->gi = Dc_gardu_induk::get();
        return $dataTable->render('dc.inspeksi-pd.index', $this->data);

    }
    public function destroy($id)
    { 
        $this->deletePermission = user()->permission('delete_inspeksi_pd');
 
        abort_403(!($this->deletePermission == 'all' || ($this->deletePermission == 'added'))); 
        ews_inspeksi_pd::withoutGlobalScope('active')->where('id_inspeksi_pd', $id)->delete();
        return Reply::success(__('messages.deleted')); 
    }
    public function update(Request $request, $id)
    {
       
        $inspectAsset = ews_inspeksi_aset::withoutGlobalScope('active')->findOrFail($id);
        
        // $inspectAsset->id_outgoing = $cubicle['OUTGOING_ID'] ;
        // $inspectAsset->id_user = Auth::user()->id;
        // $inspectAsset->id_gardu_induk = $cubicle->dcIncomingFeeder->GARDU_INDUK_ID;
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
  
        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => route('inspeksi-pd.index')]);
    }
    public function edit($id)
    {
        $this->pd = ews_inspeksi_pd::withoutGlobalScope('active')->findOrFail($id);

        $this->editPermission = user()->permission('edit_inspeksi_pd');

        abort_403(!($this->editPermission == 'all' 
        ));

        $this->pageTitle = __('app.update') . ' ' . __('app.menu.inspeksi-pd');  
        $this->dcc = Dc_apj::get();
        $this->gi = Dc_gardu_induk::get();

        if (request()->ajax()) {
            $html = view('dc.inspeksi-pd.ajax.edit', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->view = 'dc.inspeksi-pd.ajax.edit';

        return view('dc.inspeksi-pd.create', $this->data);

    }
     
}
