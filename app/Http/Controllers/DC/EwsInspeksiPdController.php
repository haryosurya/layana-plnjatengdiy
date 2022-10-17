<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\EwsInspeksiPdDatatable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EwsInspeksiPdController extends AccountBaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.inspeksi-pd'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_inspeksi_pd') == 'all'));
            return $next($request);
        });
    }
    public function index(EwsInspeksiPdDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.inspeksi-pd.index', $this->data);

    }
}
