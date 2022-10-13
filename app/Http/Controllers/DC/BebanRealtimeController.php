<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\BebanRealtimeDatatable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BebanRealtimeController extends AccountBaseController
{
    //
     
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.beban-realtime'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_cubicle') == 'all'));
            return $next($request);
        });
    }
    public function index(BebanRealtimeDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.beban-realtime.index', $this->data);

    }

}
