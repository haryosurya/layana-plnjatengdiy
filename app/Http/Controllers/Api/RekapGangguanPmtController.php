<?php

namespace App\Http\Controllers\Api;

use App\ews_inspeksi_aset as AppEws_inspeksi_aset;
use App\Http\Controllers\Controller;
use App\Models\Dc_operasi_pmt_scada;
use App\Models\ews_inspeksi_aset;
use App\Models\ews_inspeksi_pd;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class RekapGangguanPmtController extends Controller
{ 
    public function index(Request $request){
        try{
            
            $m = now()->format('m');
            $y = now()->format('Y'); 
            $rekap_gangguan_pmt = Dc_operasi_pmt_scada:: whereMonth('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $m)->whereYear('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $y)->count();
            $gangguan_inspeksi_pd = ews_inspeksi_pd:: whereMonth('tgl_entry','=', $m)->whereYear('tgl_entry','=', $y)->count();
            $gangguan_inspeksi_aset = ews_inspeksi_aset:: whereMonth('tgl_entry','=', $m)->whereYear('tgl_entry','=', $y)->count();
            return response()->json(array(        
                'status'=>true,    
                'data' => array(
                    'm' =>$m .'-'.$y,
                    // 'n' =>now()->format('m'),
                    'rekap_gangguan_pmt' => $rekap_gangguan_pmt , 
                    'gangguan_inspeksi_pd' => $gangguan_inspeksi_pd , 
                    'gangguan_inspeksi_aset' => $gangguan_inspeksi_aset , 
                ),
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
    public function rekapGangguanPMTscada (Request $request)
    {
        
        try{ 
            $rekap_gangguan = 
            Dc_operasi_pmt_scada:: 
            join('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
            ;  
            $m = now()->format('m');
            $y = now()->format('Y'); 
            $rekap_gangguan = $rekap_gangguan->whereMonth('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $m)->whereYear('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $y);
            $r = 'no req';
            if ($request->nama_tipe_gangguan !== null && $request->nama_tipe_gangguan != 'null' && $request->nama_tipe_gangguan != '') { 
                $keyword = $request->get('nama_tipe_gangguan'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_tipe_gangguan.NAMA_TIPE_GANGGUAN', 'LIKE','%' .$keyword . '%') ;
                $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
                $r = "nodate";
            }  
            if ($request->startDate !== null && $request->endDate !== null && $request->startDate != '' && $request->endDate != ''  ) {
                $startDate =  Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate =  Carbon::parse($request->endDate)->format('Y-m-d');
                
                $r = $startDate .' to '.$endDate;
                $rekap_gangguan = $rekap_gangguan 
                ->whereDate(Carbon::createFromFormat('Y-m-d', 'dc_operasi_pmt_scada.OPERASI_PMT_ID'), '>=', $startDate)                                 
                ->whereDate(Carbon::createFromFormat('Y-m-d', 'dc_operasi_pmt_scada.OPERASI_PMT_ID'), '<=', $endDate) 
                // ->whereBetween(DB::raw('DATE(dc_operasi_pmt_scada.`TGL_OPERASI_PMT`)')   , [$startDate, $endDate]) 
                ;
            }
            $reslt = $rekap_gangguan->orderBy(showDateString('dc_operasi_pmt_scada.OPERASI_PMT_ID','ASC'))->paginate(10);
            return response()->json(array(        
                'status'=>true,    
                'r' => $m .'.'.$y .' ---'.$r, 
                'data' => $reslt , 
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
    public function rekapGangguanPD (Request $request)
    {
        
        try{ 
            $rekap_gangguan = 
            ews_inspeksi_pd:: 
            join('dc_cubicle','dc_cubicle.OUTGOING_ID','ews_inspeksi_pd.id_outgoing')
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','ews_inspeksi_pd.id_gardu_induk')
            ;  
            $m = now()->month;
            $y = now()->year; 
            if($request->this_month == null && $request->this_month == 'null' && $request->this_month == '' && $request->this_month == 0){
                $rekap_gangguan = $rekap_gangguan->whereMonth('ews_inspeksi_pd.tgl_entry','=', $m)->whereYear('ews_inspeksi_pd.tgl_entry','=', $y);
            }
  
            if ($request->this_month !== null && $request->this_month != 'null' && $request->this_month != '' && $request->this_month == 1) { 
                $m = Carbon::parse(now()->month)->format('Y-m-d');
                $y = Carbon::parse(now()->year)->format('Y-m-d'); 
                $rekap_gangguan = $rekap_gangguan->whereMonth( 'ews_inspeksi_pd.tgl_entry' ,'=', $m)->whereYear( 'ews_inspeksi_pd.tgl_entry' ,'=', $y) ;
            } 
            // if ($request->outgoing_id !== null && $request->outgoing_id != 'null' && $request->outgoing_id != '') { 
            //     $keyword = $request->get('nama_tipe_gangguan'); 
            //     $rekap_gangguan = $rekap_gangguan->where('ews_inspeksi_pd.outgoing_id', 'LIKE','%' .$keyword . '%') ;
            //     $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
            // }  
            if ($request->startDate !== null && $request->endDate !== null && $request->startDate != '' && $request->endDate != ''  ) {
                $startDate =  Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate =  Carbon::parse($request->endDate)->format('Y-m-d');
                $rekap_gangguan = $rekap_gangguan->whereBetween(DB::raw('DATE(ews_inspeksi_pd.`tgl_entry`)')   , [$startDate, $endDate]);
            }
            $reslt = $rekap_gangguan
            ->orderBy('ews_inspeksi_pd.id_outgoing','ASC')
            ->paginate(10);
            return response()->json(array(        
                'status'=>true,    
                'data' => $reslt , 
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
    public function rekapInspeksiAset (Request $request)
    {
        
        try{ 
            $rekap_gangguan = 
            ews_inspeksi_aset:: 
            join('dc_cubicle','dc_cubicle.OUTGOING_ID','ews_inspeksi_aset.id_outgoing')
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','ews_inspeksi_aset.id_gardu_induk')
            ;  
            $m = now()->month;
            $y = now()->year; 
            if($request->this_month == null && $request->this_month == 'null' && $request->this_month == '' && $request->this_month == 0){
                $rekap_gangguan = $rekap_gangguan->whereMonth('ews_inspeksi_aset.tgl_entry','=', $m)->whereYear('ews_inspeksi_aset.tgl_entry','=', $y);
            }
  
            if ($request->this_month !== null && $request->this_month != 'null' && $request->this_month != '' && $request->this_month == 1) { 
                $m = Carbon::parse(now()->month)->format('Y-m-d');
                $y = Carbon::parse(now()->year)->format('Y-m-d'); 
                $rekap_gangguan = $rekap_gangguan->whereMonth( 'ews_inspeksi_aset.tgl_entry' ,'=', $m)->whereYear( 'ews_inspeksi_aset.tgl_entry' ,'=', $y) ;
            } 
            // if ($request->outgoing_id !== null && $request->outgoing_id != 'null' && $request->outgoing_id != '') { 
            //     $keyword = $request->get('nama_tipe_gangguan'); 
            //     $rekap_gangguan = $rekap_gangguan->where('ews_inspeksi_pd.outgoing_id', 'LIKE','%' .$keyword . '%') ;
            //     $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
            // }  
            if ($request->startDate !== null && $request->endDate !== null && $request->startDate != '' && $request->endDate != ''  ) {
                $startDate =  Carbon::parse($request->startDate)->format('Y-m-d');
                $endDate =  Carbon::parse($request->endDate)->format('Y-m-d');
                $rekap_gangguan = $rekap_gangguan->whereBetween(DB::raw('DATE(ews_inspeksi_aset.`tgl_entry`)')   , [$startDate, $endDate]);
            }
            $reslt = $rekap_gangguan
            ->orderBy('ews_inspeksi_aset.id_inspeksi_aset','ASC')
            ->paginate(10);
            return response()->json(array(        
                'status'=>true,    
                'data' => $reslt , 
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
