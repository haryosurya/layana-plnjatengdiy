<?php

namespace App\Http\Controllers\DC;

use App\DataTables\DC\RekapGangguanPMTscadaDatatable;
use App\Helper\Reply;
use App\Http\Controllers\AccountBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_operasi_pmt_scada;
use Illuminate\Http\Request;

class RekapGangguanPMTscadaController extends AccountBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.menu.rekap-gangguan-pmt';
        $this->middleware(function ($request, $next) {
            abort_403(!(user()->permission('view_rekap_gangguan_pmt') == 'all'));
            return $next($request);
        });
    }
    // public function __invoke()
    // {
    //     return redirect('rekap-gangguan-pmt');
    // }
    public function index(RekapGangguanPMTscadaDatatable $dataTable)
    {  
        return $dataTable->render('dc.rekap-gangguan-pmt.index', $this->data);
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
        // $this->employee = User::with(['employeeDetail', 'employeeDetail.designation', 'employeeDetail.department'])->withoutGlobalScope('active')->with('employee')->findOrFail($id);
        
        $this->rekapGangguan = Dc_operasi_pmt_scada::with(['dcUpj','dcApj','dcIndikasiGangguan','dcTipeGangguan','dcSpeedjardistCuaca'])->withoutGlobalScope('active')->findOrFail($id);
 
        $this->pageTitle = ucfirst($this->rekapGangguan->dcApj->APJ_DCC);
 
        if (request()->ajax()) {
            $html = view('dc.rekap-gangguan-pmt.ajax.detail', $this->data)->render();
            return Reply::dataOnly(['status' => 'success', 'html' => $html, 'title' => $this->pageTitle]);
        }

        return view('dc.rekap-gangguan-pmt.create', $this->data);
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
