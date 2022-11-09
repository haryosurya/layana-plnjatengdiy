<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\BebanRealtimeDatatable;
use App\DataTables\DC\SmMeterGiDatatable;
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
            abort_403(!(user()->permission('view_beban_realtime') == 'all'));
            abort_403(!(in_array('beban-realtime', user_modules())) );   
            return $next($request);
        });
    }
    public function index(SmMeterGiDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.beban-realtime.index', $this->data); 
    }

}
