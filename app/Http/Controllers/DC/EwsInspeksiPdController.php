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
    public function update(Request $request, $id)
    {
       
        $inspectPd = ews_inspeksi_pd::withoutGlobalScope('active')->findOrFail($id);
 
        // $cubicle = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
        // $inspectPd->id_outgoing = $cubicle['OUTGOING_ID'] ;
        // $inspectPd->id_user = Auth::user()->id;
        // $inspectPd->id_gardu_induk = $cubicle->dcIncomingFeeder->GARDU_INDUK_ID;
        // $inspectPd->tgl_entry = Carbon::createFromFormat($this->global->date_format , $request->tgl_entry)->format('Y-m-d H:i:s'); 
        // $inspectPd->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s'); 
        $inspectPd->citicality = $request->citicality;
        $inspectPd->level_pd = $request->level_pd;
        $inspectPd->keterangan = $request->keterangan;
        $inspectPd->id_update = $request->id_update;
        $inspectPd->last_update = Carbon::now()->format('Y-m-d H:i:s') ;
        /* image */
        // $inspectPd->foto_pelaksanaan = json_encode($foto_pelaksanaanResponse);
        // $inspectPd->foto_pengukuran = json_encode($foto_pengukuranResponse);
        $inspectPd->save(); 

        /* update PD LEVEl dc cubicle */
        $cubicleLevel = Dc_cubicle::where('OUTGOING_ID',$inspectPd->id_outgoing)->first(); 
        $cubicleLevel->PD_LEVEL = $request->level_pd; 
        $cubicleLevel->save();
  
        return Reply::successWithData(__('messages.updateSuccess'), ['redirectUrl' => route('inspeksi-pd.index')]);
    }
}
