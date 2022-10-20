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
            Dc_operasi_pmt_scada::join('dc_apj','dc_apj.APJ_ID','dc_operasi_pmt_scada.APJ_ID')
            ->join('dc_cubicle','dc_cubicle.CUBICLE_NAME','dc_operasi_pmt_scada.DETAIL_LOKASI')
            ->join('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
            ->join('dc_indikasi_gangguan','dc_indikasi_gangguan.ID_INDIKASI_GANGGUAN','dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN')
            ->join('dc_speedjardist_cuaca','dc_speedjardist_cuaca.ID_CUACA','dc_operasi_pmt_scada.CUACA') 
            ->join('dc_jenis_keadaan_pmt','dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID','dc_operasi_pmt_scada.JENIS_OPERASI_PMT') 
            ;  
 
             
            if ($request->nama_tipe_gangguan !== null && $request->nama_tipe_gangguan != 'null' && $request->nama_tipe_gangguan != '') { 
                $keyword = $request->get('nama_tipe_gangguan'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_tipe_gangguan.NAMA_TIPE_GANGGUAN', 'LIKE','%' .$keyword . '%') ;
                $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
                 
            }  
            if ($request->get('startDate') && $request->get('endDate')   ) {
 
                $rekap_gangguan = $rekap_gangguan  
                ->whereBetween('dc_operasi_pmt_scada.TGL_OPERASI_PMT',[date('Y-m-d', strtotime( $request->get('startDate')  )),date('Y-m-d', strtotime( $request->get('endDate') ))])
                ;
                // ->whereDate('dc_operasi_pmt_scada.TGL_OPERASI_PMT', '>=', date('Y-m-d', strtotime( $request->startDate )))
                // ->whereDate('dc_operasi_pmt_scada.TGL_OPERASI_PMT', '<=', date('Y-m-d', strtotime( $request->endDate )))
            }else{

                $m = now()->format('m');
                $y = now()->format('Y');  
                $rekap_gangguan = $rekap_gangguan->whereMonth('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $m)->whereYear('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $y); 
            }
            
            $reslt = $rekap_gangguan->orderBy('dc_operasi_pmt_scada.OPERASI_PMT_ID','DESC')->paginate(10);
            if ($request->get('startDate') && $request->get('endDate')   ) {
                return response()->json(array(        
                    'status'=>true,     
                    'data' => $reslt , 
                    'req' => $request->startDate , 
                    'req2' => $request->endDate , 
                    'status_code' => 200
                ));
            }
            return response()->json(array(        
                'status'=>true,     
                'data' => $reslt , 
                're'=>'',
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
            if($request->this_month == null && $request->this_month == 'null' && $request->this_month == '' && $request->this_month == 0){
                $rekap_gangguan = $rekap_gangguan->whereMonth('ews_inspeksi_pd.tgl_entry','=', $m)->whereYear('ews_inspeksi_pd.tgl_entry','=', $y);
            }
  
            if ($request->this_month !== null && $request->this_month != 'null' && $request->this_month != '' && $request->this_month == 1) { 
                $m = Carbon::parse(now()->month)->format('Y-m-d');
                $y = Carbon::parse(now()->year)->format('Y-m-d'); 
                $rekap_gangguan = $rekap_gangguan->whereMonth( 'ews_inspeksi_pd.tgl_entry' ,'=', $m)->whereYear( 'ews_inspeksi_pd.tgl_entry' ,'=', $y) ;
            }  
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
