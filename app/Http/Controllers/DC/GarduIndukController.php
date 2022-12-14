<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\DcGarduIndukDatatable;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GarduIndukController extends AccountBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.gardu-induk'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_gardu') == 'all'));
            abort_403(!(in_array('gardu-induk', user_modules())) );

            return $next($request);
        });
    }
    public function index(DcGarduIndukDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.gardu_induk.index', $this->data);

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
