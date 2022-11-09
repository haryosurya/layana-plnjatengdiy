<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\DccDatatable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DccController extends AccountBaseController
{
    //
    
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.dcc'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_dcc') == 'all'));
            abort_403(!(in_array('dcc', user_modules())) ); 
            return $next($request);
        });
    }
    public function index(DccDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.dcc.index', $this->data); 
    }
}
