<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\DcCubicleDatatable;
use App\DataTables\DC\InspeksiPdDatatable;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use App\Models\Dc_inspeksi_asset;
use App\Models\Dc_inspeksi_pd;
use App\Models\Dc_operasi_pmt_scada;
use Illuminate\Http\Request;

class CubicleController extends AccountBaseController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.cubicle'; 
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_cubicle') == 'all'));
            return $next($request);
        });
    }
    public function index(DcCubicleDatatable $dataTable)
    {
        //
        return $dataTable->render('dc.cubicle.index', $this->data);

    }

    public function show($id)
    { 
        $this->cubicle = Dc_cubicle:: 
        withoutGlobalScope('active') 
        ->findOrFail($id);
        
        $this->viewPermission = user()->permission('view_cubicle');

        // if (!$this->employee->hasRole('employee')) {
        //     abort(404);
        // }


        abort_403(!(
            $this->viewPermission == 'all'
            || ($this->viewPermission == 'added' )
            || ($this->viewPermission == 'owned' )
            || ($this->viewPermission == 'both')
        ));


        $this->pageTitle = ucfirst($this->cubicle->CUBICLE_NAME);
 
        $this->countIndspeksiPd = Dc_inspeksi_pd::where('OUTGOING_ID',$id)->count(); 

        $tab = request('tab');

        switch ($tab) {
        case 'InspeksiPd':
            return $this->InspeksiPd(); 

        default:
            $this->view = 'dc.cubicle.ajax.show';
            break;
        }

        if (request()->ajax()) {
            $html = view($this->view, $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        $this->activeTab = ($tab == '') ? 'profile' : $tab;

        return view('dc.cubicle.show', $this->data);
    }
    public function InspeksiPd()
    {
        $viewPermission = user()->permission('view_cubicle');
        abort_403(!in_array($viewPermission, ['all']));

        $tab = request('tab');
        $this->activeTab = ($tab == '') ? 'profile' : $tab;
        $this->view = 'dc.cubicle.ajax.inspeksipd';

        $dataTable = new InspeksiPdDatatable();

        return $dataTable->render('dc.cubicle.show', $this->data);
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
