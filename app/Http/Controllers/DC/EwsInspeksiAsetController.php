<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\EwsInspeksiAsetDatatable;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_gardu_induk;
use App\Models\ews_inspeksi_aset;
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
 
         $this->pageTitle = __('app.update') . ' ' . __('app.inspeksi-aset');  
         $this->dcc = Dc_apj::get();
         $this->gi = Dc_gardu_induk::get();
 
         if (request()->ajax()) {
             $html = view('dc.inspeksi-aset.ajax.edit', $this->data)->render();
             return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
         }
 
         $this->view = 'dc.inspeksi-aset.ajax.edit';
 
         return view('dc.inspeksi-aset.create', $this->data);
 
     }
}
