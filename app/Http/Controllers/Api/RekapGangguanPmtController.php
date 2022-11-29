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
            ->leftJoin('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
            ->leftJoin('dc_indikasi_gangguan','dc_indikasi_gangguan.ID_INDIKASI_GANGGUAN','dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN')
            ->leftJoin('dc_speedjardist_cuaca','dc_speedjardist_cuaca.ID_CUACA','dc_operasi_pmt_scada.CUACA') 
            ->leftJoin('dc_speedjardist_jarakgangguan','dc_speedjardist_jarakgangguan.ID_JARAK_GANGGUAN','dc_operasi_pmt_scada.JARAK_GANGGUAN') 
            ->leftJoin('dc_jenis_keadaan_pmt','dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID','dc_operasi_pmt_scada.JENIS_OPERASI_PMT') 
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','dc_operasi_pmt_scada.CAKUPAN_KERJA') 
            ;  
 
             
            if ($request->nama_tipe_gangguan !== null && $request->nama_tipe_gangguan != 'null' && $request->nama_tipe_gangguan != '') { 
                $keyword = $request->get('nama_tipe_gangguan'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_tipe_gangguan.NAMA_TIPE_GANGGUAN', 'LIKE','%' .$keyword . '%') ;
                $rekap_gangguan = $rekap_gangguan->orWhere('dc_operasi_pmt_scada.ALASAN_OPERASI_PMT', 'LIKE','%' .$keyword . '%') ;
                 
            }  
            if ($request->ID_INDIKASI_GANGGUAN !== null && $request->ID_INDIKASI_GANGGUAN != 'null' && $request->ID_INDIKASI_GANGGUAN != '') { 
                $keyword = $request->get('ID_INDIKASI_GANGGUAN'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN', '=',$keyword) ; 
                 
            }  
            if ($request->GARDU_INDUK_ID !== null && $request->GARDU_INDUK_ID != 'null' && $request->GARDU_INDUK_ID != '') { 
                $keyword = $request->get('GARDU_INDUK_ID'); 
                $rekap_gangguan = $rekap_gangguan->where('dc_gardu_induk.GARDU_INDUK_ID', '=',$keyword) ; 
                 
            }  
            if ($request->get('startDate') && $request->get('endDate')   ) {
 
                $rekap_gangguan = $rekap_gangguan  
                ->whereBetween('dc_operasi_pmt_scada.TGL_OPERASI_PMT',[date('Y-m-d', strtotime( $request->get('startDate')  )),date('Y-m-d', strtotime( $request->get('endDate') ))])
                ; 
            }else{

                $m = now()->format('m');
                $y = now()->format('Y');  
                $rekap_gangguan = $rekap_gangguan->whereMonth('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $m)->whereYear('dc_operasi_pmt_scada.TGL_OPERASI_PMT', $y); 
            }
            $rekap_gangguan = $rekap_gangguan->groupBy('dc_operasi_pmt_scada.OPERASI_PMT_ID')
            ->selectRaw(
                '

                dc_operasi_pmt_scada.OPERASI_PMT_ID,
                concat( date_format( dc_operasi_pmt_scada.TGL_OPERASI_PMT, _utf8 "%d-%m-%Y %H:%i" ), ":00" ) AS TGL_OPERASI,
                concat( date_format( dc_operasi_pmt_scada.TGL_NORMAL_PMT, _utf8 "%d-%m-%Y %H:%i" ), ":00" ) AS TGL_PENORMALAN_PMT,
                dc_operasi_pmt_scada.TGL_OPERASI_PMT,
                dc_operasi_pmt_scada.TGL_NORMAL_PMT,
                dc_operasi_pmt_scada.JENIS_OPERASI_PMT,
                dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT,
                dc_operasi_pmt_scada.APJ_ID,
                dc_apj.APJ_NAMA,
                dc_apj.APJ_DCC,
                dc_operasi_pmt_scada.CAKUPAN_KERJA, 
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_operasi_pmt_scada.DETAIL_LOKASI, 
                dc_cubicle.CUBICLE_NAME, 
                dc_operasi_pmt_scada.ALASAN_OPERASI_PMT, 
                dc_operasi_pmt_scada.ID_TIPE_GANGGUAN, 
                dc_tipe_gangguan.NAMA_TIPE_GANGGUAN, 
                dc_tipe_gangguan.KODE_GANGGUAN, 
                dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN, 
                dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN, 
                dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS, 
                dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS, 
                dc_operasi_pmt_scada.BEBAN_SSDH_PMT_LEPAS, 
                dc_operasi_pmt_scada.TEG_SSDH_PMT_LEPAS,
                round( ( ( ( dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS * dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS ) * 1.732 ) * 0.85 ), 2 )  AS ENERGI_HILANG,
                timestampdiff( MINUTE, dc_operasi_pmt_scada.TGL_OPERASI_PMT,dc_operasi_pmt_scada.TGL_NORMAL_PMT ) AS LAMA_PADAM,
                round((((((
                                    dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS * dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS 
                                    ) * 1.732 
                                ) * 0.92 
                            ) * timestampdiff( MINUTE, dc_operasi_pmt_scada.TGL_OPERASI_PMT, dc_operasi_pmt_scada.TGL_NORMAL_PMT )) / 60 
                    ),
                2 
                ) AS KWH_HILANG, 
                (concat( date_format( dc_operasi_pmt_scada.TGL_OPERASI_PMT, _utf8 "%H:%i" ), ":00" )) AS JAM_TRIP,
                (concat( date_format( dc_operasi_pmt_scada.TGL_NORMAL_PMT, _utf8 "%H:%i" ), ":00" )) AS JAM_NORMAL,
                dc_gardu_induk.GARDU_INDUK_ID AS GARDU_INDUK_ID, 
                dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID AS JENIS_KEADAAN_PMT_ID,  
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_A AS ARUS_GANGGUAN_PH_A,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_B AS ARUS_GANGGUAN_PH_B,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_C AS ARUS_GANGGUAN_PH_C,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_N AS ARUS_GANGGUAN_PH_N,
                dc_operasi_pmt_scada.KET_ARUS_GANGGUAN AS KET_ARUS_GANGGUAN,
                dc_operasi_pmt_scada.JARAK_GANGGUAN,
                dc_speedjardist_jarakgangguan.NAMA_JARAK_GANGGUAN AS NAMA_JARAK_GANGGUAN,
                dc_speedjardist_cuaca.CUACA_NAME AS CUACA_NAME,
                dc_operasi_pmt_scada.CUACA AS CUACA,
                dc_operasi_pmt_scada.LOKASI_GANGGUAN AS LOKASI_GANGGUAN, 
                dc_operasi_pmt_scada.NO_POLE_TIANG AS NO_POLE_TIANG  
                '); 
                /* 
                */
            $reslt = $rekap_gangguan->orderBy('dc_operasi_pmt_scada.OPERASI_PMT_ID','DESC')->paginate(5);
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
    public function rekapGangguanPMTscadaSingle($id){
        try{ 
            $rekap_gangguan = 
            Dc_operasi_pmt_scada::join('dc_apj','dc_apj.APJ_ID','dc_operasi_pmt_scada.APJ_ID')
            ->join('dc_cubicle','dc_cubicle.CUBICLE_NAME','dc_operasi_pmt_scada.DETAIL_LOKASI')
            ->leftJoin('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
            ->leftJoin('dc_indikasi_gangguan','dc_indikasi_gangguan.ID_INDIKASI_GANGGUAN','dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN')
            ->leftJoin('dc_speedjardist_cuaca','dc_speedjardist_cuaca.ID_CUACA','dc_operasi_pmt_scada.CUACA') 
            ->leftJoin('dc_speedjardist_jarakgangguan','dc_speedjardist_jarakgangguan.ID_JARAK_GANGGUAN','dc_operasi_pmt_scada.JARAK_GANGGUAN') 
            ->leftJoin('dc_jenis_keadaan_pmt','dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID','dc_operasi_pmt_scada.JENIS_OPERASI_PMT') 
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','dc_operasi_pmt_scada.CAKUPAN_KERJA') 
            ;   
            $rekap_gangguan = $rekap_gangguan
            ->selectRaw(
                ' 
                dc_operasi_pmt_scada.OPERASI_PMT_ID,
                concat( date_format( dc_operasi_pmt_scada.TGL_OPERASI_PMT, _utf8 "%d-%m-%Y %H:%i" ), ":00" ) AS TGL_OPERASI,
                concat( date_format( dc_operasi_pmt_scada.TGL_NORMAL_PMT, _utf8 "%d-%m-%Y %H:%i" ), ":00" ) AS TGL_PENORMALAN_PMT,
                dc_operasi_pmt_scada.TGL_OPERASI_PMT,
                dc_operasi_pmt_scada.TGL_NORMAL_PMT,
                dc_operasi_pmt_scada.JENIS_OPERASI_PMT,
                dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT,
                dc_operasi_pmt_scada.APJ_ID,
                dc_apj.APJ_NAMA,
                dc_apj.APJ_DCC,
                dc_operasi_pmt_scada.CAKUPAN_KERJA, 
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_operasi_pmt_scada.DETAIL_LOKASI, 
                dc_cubicle.CUBICLE_NAME, 
                dc_operasi_pmt_scada.ALASAN_OPERASI_PMT, 
                dc_operasi_pmt_scada.ID_TIPE_GANGGUAN, 
                dc_tipe_gangguan.NAMA_TIPE_GANGGUAN, 
                dc_tipe_gangguan.KODE_GANGGUAN, 
                dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN, 
                dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN, 
                dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS, 
                dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS, 
                dc_operasi_pmt_scada.BEBAN_SSDH_PMT_LEPAS, 
                dc_operasi_pmt_scada.TEG_SSDH_PMT_LEPAS,
                round( ( ( ( dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS * dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS ) * 1.732 ) * 0.85 ), 2 )  AS ENERGI_HILANG,
                timestampdiff( MINUTE, dc_operasi_pmt_scada.TGL_OPERASI_PMT,dc_operasi_pmt_scada.TGL_NORMAL_PMT ) AS LAMA_PADAM,
                round((((((
                                    dc_operasi_pmt_scada.BEBAN_SBLM_PMT_LEPAS * dc_operasi_pmt_scada.TEG_SBLM_PMT_LEPAS 
                                    ) * 1.732 
                                ) * 0.92 
                            ) * timestampdiff( MINUTE, dc_operasi_pmt_scada.TGL_OPERASI_PMT, dc_operasi_pmt_scada.TGL_NORMAL_PMT )) / 60 
                    ),
                2 
                ) AS KWH_HILANG, 
                (concat( date_format( dc_operasi_pmt_scada.TGL_OPERASI_PMT, _utf8 "%H:%i" ), ":00" )) AS JAM_TRIP,
                (concat( date_format( dc_operasi_pmt_scada.TGL_NORMAL_PMT, _utf8 "%H:%i" ), ":00" )) AS JAM_NORMAL,
                dc_gardu_induk.GARDU_INDUK_ID AS GARDU_INDUK_ID, 
                dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID AS JENIS_KEADAAN_PMT_ID,  
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_A AS ARUS_GANGGUAN_PH_A,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_B AS ARUS_GANGGUAN_PH_B,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_C AS ARUS_GANGGUAN_PH_C,
                dc_operasi_pmt_scada.ARUS_GANGGUAN_PH_N AS ARUS_GANGGUAN_PH_N,
                dc_operasi_pmt_scada.KET_ARUS_GANGGUAN AS KET_ARUS_GANGGUAN,
                dc_operasi_pmt_scada.JARAK_GANGGUAN,
                dc_speedjardist_jarakgangguan.NAMA_JARAK_GANGGUAN AS NAMA_JARAK_GANGGUAN,
                dc_speedjardist_cuaca.CUACA_NAME AS CUACA_NAME,
                dc_operasi_pmt_scada.CUACA AS CUACA,
                dc_operasi_pmt_scada.LOKASI_GANGGUAN AS LOKASI_GANGGUAN, 
                dc_operasi_pmt_scada.NO_POLE_TIANG AS NO_POLE_TIANG  
                '); 
                /* 
                */
            $reslt = $rekap_gangguan->where('OPERASI_PMT_ID',$id); 
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
            ->orderBy('ews_inspeksi_pd.id_inspeksi_pd','ASC')
            ->groupBy('ews_inspeksi_pd.id_inspeksi_pd')
            ->paginate(5);
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
            ->groupBy('ews_inspeksi_aset.id_inspeksi_aset')
            ->paginate(5);
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
