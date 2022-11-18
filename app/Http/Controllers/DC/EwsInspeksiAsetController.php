<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\EwsInspeksiAsetDatatable;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_gardu_induk;
use App\Models\ews_inspeksi_aset;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EwsInspeksiAsetController extends AccountBaseController
{ 
     public function __construct()
     {
         parent::__construct();
         $this->pageTitle = 'app.menu.inspeksi-aset'; 
         $this->dcc = Dc_apj::get();
         $this->gi = Dc_gardu_induk::get();
         $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_inspeksi_aset') == 'all'));
            abort_403(!(in_array('inspeksi-aset', user_modules())) );

            return $next($request);
         });
     }
     public function index(EwsInspeksiAsetDatatable $dataTable)
     {
        //
        $this->dcc = Dc_apj::get();
        $this->gi = Dc_gardu_induk::get();
        return $dataTable->render('dc.inspeksi-aset.index', $this->data);
 
     }
     public function destroy($id)
     { 
        //  $this->deletePermission = user()->permission('delete_inspeksi_aset'); 
        //  abort_403(!($this->deletePermission == 'all' || ($this->deletePermission == 'added'))); 
         ews_inspeksi_aset::withoutGlobalScope('active')->where('id_inspeksi_aset', $id)->delete();
         return Reply::success(__('messages.deleted')); 
     }
     public function edit($id)
     {
         $this->aset = ews_inspeksi_aset::withoutGlobalScope('active')->findOrFail($id);
 
         $this->editPermission = user()->permission('edit_inspeksi_aset');
 
         abort_403(!($this->editPermission == 'all' 
         ));
 
         $this->pageTitle = __('app.update') . ' ' . __('app.menu.inspeksi-aset');  
         $this->dcc = Dc_apj::get();
         $this->gi = Dc_gardu_induk::get();
 
         if (request()->ajax()) {
             $html = view('dc.inspeksi-aset.ajax.edit', $this->data)->render();
             return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
         }
 
         $this->view = 'dc.inspeksi-aset.ajax.edit';
 
         return view('dc.inspeksi-aset.create', $this->data);
 
     }
     public function update(Request $request, $id){
        // $inspectAsset = new ews_inspeksi_aset();
        $inspectAsset = ews_inspeksi_aset::withoutGlobalScope('active')->findOrFail($id);

        // $inspectAsset->id_outgoing = $cubicle['OUTGOING_ID'] ;
        // $inspectAsset->id_user = Auth::user()->id;
        // $inspectAsset->id_gardu_induk = $cubicle->dcIncomingFeeder->GARDU_INDUK_ID;
        // $inspectAsset->tgl_entry = Carbon::createFromFormat($this->global->date_format , $request->tgl_entry)->format('Y-m-d H:i:s');   
        // $inspectAsset->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s');
        $inspectAsset->body_cubicle = ucwords($request->body_cubicle);
        $inspectAsset->lv = ucwords($request->lv);
        $inspectAsset->cb = ucwords($request->cb);
        $inspectAsset->busbar = ucwords($request->busbar);
        $inspectAsset->power_cable = ucwords($request->power_cable);
        $inspectAsset->pmt_cb = ucwords($request->pmt_cb);
        $inspectAsset->announ = ucwords($request->announ);
        $inspectAsset->ind_lamp = ucwords($request->ind_lamp);
        $inspectAsset->ind_volt = ucwords($request->ind_volt);
        $inspectAsset->ac220 = ucwords($request->ac220);
        $inspectAsset->dc110 = ucwords($request->dc110);
        $inspectAsset->desis = ucwords($request->desis);
        $inspectAsset->dengung = ucwords($request->dengung);  
        $inspectAsset->ngeter = ucwords($request->ngeter);
        $inspectAsset->flash = ucwords($request->flash);
        $inspectAsset->sangit = ucwords($request->sangit);
        $inspectAsset->amis = ucwords($request->amis);
        $inspectAsset->feeder = ucwords($request->feeder);
        $inspectAsset->kubikel = ucwords($request->kubikel);
        $inspectAsset->pmt = ucwords($request->pmt);
        $inspectAsset->grounding = ucwords($request->grounding);
        $inspectAsset->sangit2 = ucwords($request->sangit2);
        $inspectAsset->slr = ucwords($request->slr);
        $inspectAsset->sar = ucwords($request->sar);
        $inspectAsset->body_alat = ucwords($request->body_alat);
        $inspectAsset->wiring = ucwords($request->wiring);
        $inspectAsset->w_prot = ucwords($request->w_prot);
        $inspectAsset->w_meter = ucwords($request->w_meter);
        $inspectAsset->w_acc = ucwords($request->w_acc);
        $inspectAsset->relay_ready = ucwords($request->relay_ready);
        $inspectAsset->relay_display = ucwords($request->relay_display);
        $inspectAsset->relay_mr = ucwords($request->relay_mr);
        $inspectAsset->relay_ms = ucwords($request->relay_ms);
        $inspectAsset->relay_mt = ucwords($request->relay_mt);
        $inspectAsset->pm_display = ucwords($request->pm_display);
        $inspectAsset->pm_mr = ucwords($request->pm_mr);
        $inspectAsset->pm_ms = ucwords($request->pm_ms);
        $inspectAsset->pm_mt = ucwords($request->pm_mt);
        $inspectAsset->kwh_meter = ucwords($request->kwh_meter);
        $inspectAsset->panel_rtu = ucwords($request->panel_rtu);
        $inspectAsset->door = ucwords($request->door);
        $inspectAsset->fan = ucwords($request->fan);
        $inspectAsset->lampu_panel = ucwords($request->lampu_panel);
        $inspectAsset->grounding_rtu = ucwords($request->grounding_rtu);
        $inspectAsset->temp_panel = ucwords($request->temp_panel);
        $inspectAsset->kebersihan = ucwords($request->kebersihan);
        $inspectAsset->power_on = ucwords($request->power_on);
        $inspectAsset->led_txrx = ucwords($request->led_txrx);
        $inspectAsset->ethernet = ucwords($request->ethernet);
        $inspectAsset->keterangan = ucwords($request->keterangan);
        $inspectAsset->id_update = $request->id_update;
        $inspectAsset->last_update = Carbon::now()->format('Y-m-d H:i:s') ; 


        $inspectAsset->save();

        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => route('inspeksi-aset.index')]);

     }
     public function download($id)
    { 
        $this->pd = ews_inspeksi_aset::withoutGlobalScope('active')->findOrFail($id); 

        $pdfOption = $this->domPdfObjectForDownload($id);
        $pdf = $pdfOption['pdf'];
        $filename = $pdfOption['fileName'];

        // return $pdf->download($filename . '.pdf');
        return view('dc.inspeksi-aset.pdf.print', $this->data);

    }

    public function domPdfObjectForDownload($id)
    {
        $this->pd = ews_inspeksi_aset::withoutGlobalScope('active')->findOrFail($id); 
        $pdf = app('dompdf.wrapper'); 
        $pdf->loadView('dc.inspeksi-aset.pdf.print', $this->data);
        $filename = $this->pd->id_inspeksi_pd;

        return [
            'pdf' => $pdf,
            'fileName' => $filename
        ];
    }
}
