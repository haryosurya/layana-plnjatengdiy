<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\EwsInspeksiAsetDatatable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EwsInspeksiAsetController extends AccountBaseController
{
    //
     //
     public function __construct()
     {
         parent::__construct();
         $this->pageTitle = 'app.menu.inspeksi-aset'; 
         $this->middleware(function ($request, $next) {
             abort_403(!(user()->permission('view_inspeksi_aset') == 'all'));
             return $next($request);
         });
     }
     public function index(EwsInspeksiAsetDatatable $dataTable)
     {
         //
         return $dataTable->render('dc.inspeksi-aset.index', $this->data);
 
     }
}
