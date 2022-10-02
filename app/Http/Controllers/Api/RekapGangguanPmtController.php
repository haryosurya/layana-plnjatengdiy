<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_operasi_pmt_scada;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class RekapGangguanPmtController extends Controller
{ 
    public function index(Request $request){

        try{
            $rekap_gangguan = Dc_operasi_pmt_scada:: join('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
            ;  
            if ($request->this_month !== null && $request->this_month != 'null' && $request->this_month != '' && $request->this_month == 1) { 
                $m = Carbon::parse(now()->month)->format('Y-m-d');
                $y = Carbon::parse(now()->year)->format('Y-m-d'); 
                $rekap_gangguan = $rekap_gangguan->whereMonth( 'dc_operasi_pmt_scada.TGL_OPERASI_PMT' ,'=', $m)->whereYear( 'dc_operasi_pmt_scada.TGL_OPERASI_PMT' ,'=', $y) ;
            } 
            if ($request->nama_tipe_gangguan !== null && $request->nama_tipe_gangguan != 'null' && $request->nama_tipe_gangguan != '') { 
                $keyword = $request->get('nama_tipe_gangguan'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_tipe_gangguan.NAMA_TIPE_GANGGUAN', 'LIKE','%' .$keyword . '%') ;
                $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
            } 
            // if ($request->dateRequest !== null && $request->dateRequest != 'null' && $request->dateRequest != '') {
            //     $dateRequest = Carbon::createFromFormat($this->global->date_format, $request->dateRequest)->toDateString(); 
            //     $rekap_gangguan = $rekap_gangguan->having(DB::raw('DATE(Dc_operasi_pmt_scada.`TGL_OPERASI_PMT`)'), '==', $dateRequest);
            // }  
            if ($request->startDate && $request->endDate) {
                $startDate =  Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate =  Carbon::parse($request->endDate)->format('Y-m-d');
                $rekap_gangguan = $rekap_gangguan->whereBetween(DB::raw('DATE(Dc_operasi_pmt_scada.`TGL_OPERASI_PMT`)')   , [$startDate, $endDate]);
            }

            return response()->json(array(        
                'status'=>true,    
                'data' => $rekap_gangguan->orderBy('dc_operasi_pmt_scada.OPERASI_PMT_ID','ASC')->paginate(10), 
                'status_code' => 200
            ));
        } 
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
