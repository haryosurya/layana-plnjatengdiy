<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use App\Models\Dc_operasi_pmt_scada;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{
    //
    public function index()
    {  
        if (auth('sanctum')->check()){  

            try{
                // Total MW didapat dari table dc_cubicle, dengan mengalikan colom VLL x Rata-rata(IA,IB,IC)
                $vll = Dc_cubicle::sum('VLL'); 
                $mw = Dc_cubicle::avg('IA','IB','IC');
                $total_records= Dc_cubicle::count(); 
                $pd_level_good = Dc_cubicle::where('PD_LEVEL','good')->count() / $total_records * 100;
                $pd_level_mod = Dc_cubicle::where('PD_LEVEL','moderate')->count()  / $total_records * 100 ;
                $pd_level_bad = Dc_cubicle::where('PD_LEVEL','bad')->count()  / $total_records * 100;
                // Menampilkan total outgoing, incoming, dan gardu induk.
                // Total Outgoing = count di table dc_cubicle.
                // Total Incoming = count di table dc_incoming_feeder.
                // Total Gardu Induk = count di table dc_gardu_induk.
                // Tampilannya menjadi “XX Outgoing٠XX Incoming٠XX Gardu Induk” 
                $totalOutgoing =  Dc_cubicle::count(); 
                $totalIncoming = Dc_incoming_feeder::count();
                $totalGardu = Dc_gardu_induk::count();
                // Diganti dengan jumlah penyulang yang posisinya close. Perhitungannya dari table dc_cubicle, colom SCB & SCB_INV. 
                // Yang di hitung adalah SCB = 1 SCB_INV = 0 dan SCB = 0 SCB_INV = 1.
                // Tampilannya menjadi “XXX Penyulang Operasi”
                $bebanRealtime = Dc_cubicle::
                        where(function($query){
                            return $query
                            ->where('SCB','=','1')
                            ->where('SCB_INV', '=', '0');
                        })
                       ->orWhere(function($query){
                            return $query
                            ->where('SCB','=','0')
                            ->where('SCB_INV', '=', '1');
                        })->count()
                    ; 
                $bebanRealtimeGardu = Dc_cubicle:: 
                where(function($query){
                    return $query
                    ->where('SCB','=','1')
                    ->where('SCB_INV', '=', '0');
                })
               ->orWhere(function($query){
                    return $query
                    ->where('SCB','=','0')
                    ->where('SCB_INV', '=', '1');
                })
                ->join('Dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
                ->leftJoin('dc_gardu_induk','Dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
                ->groupBy('Dc_incoming_feeder.GARDU_INDUK_ID')->count()
                ;
                // Mengambil data gangguan tiap bulan. Count dari table dc-operasi_pmt_scada dengan tanggal gangguan tiap bulan.
                // Tampilannya menjadi “XXX Gangguan pada bulan ini”
                $m = now()->month;
                $y = now()->year;
                $rekap_gangguan = Dc_operasi_pmt_scada::whereMonth('TGL_OPERASI_PMT','=', $m)->whereYear('TGL_OPERASI_PMT','=', $y)->count();

                $rekap_gangguan2 = Dc_operasi_pmt_scada::whereMonth('TGL_OPERASI_PMT','=', $m)->whereYear('TGL_OPERASI_PMT','=', $y)
                ->select('APJ_ID')
                ->groupBy('APJ_ID')
                // ->selectRaw('count() as total, APJ_ID')
                ->count();
                $result = array(
                    // 'vll'=>$vll,
                    // 'mw'=>$mw,
                    'total_mw'=>round($vll*$mw,0),
                    'pd_level'=> array(
                        'good'=>round($pd_level_good,2),
                        'moderate'=>round($pd_level_mod,2),
                        'bad'=>round($pd_level_bad,2)
                    ),
                    'data_penyulang' => array(
                        'total_outgoing'=>$totalOutgoing,
                        'total_incoming'=>$totalIncoming,
                        'total_gardu'=>$totalGardu, 
                    ),
                    'beban_realtime'=>
                    array(
                        'beban_realtime'=> $bebanRealtime,
                        'jml_gardu'=>$bebanRealtimeGardu
                    ),

                    'rekap_gangguan'=>array(
                       'rekap_gangguan' => $rekap_gangguan,
                       'up3_count' => $rekap_gangguan2 
                    )
                );
                return response()->json(array(    
                    'status'=>true,        
                    'data' => $result, 
                    'status_code' => 200
                ));
            }
            catch (\Throwable $th) {
                return response()->json([
                    'status' => false,
                    'message' => $th->getMessage()
                ], 500);
            } 
        }else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function CountingGangguan(){
        if (auth('sanctum')->check()){  

            try{
 
                $total_records_all = Dc_cubicle::count(); 
                $total_records_level = Dc_cubicle::
                where('PD_LEVEL','good') 
                ->orWhere('PD_LEVEL','moderate') 
                ->orWhere('PD_LEVEL','bad') 
                ->count(); 
                $pd_level_good = Dc_cubicle::where('PD_LEVEL','good')->count() / $total_records_level * 100;
                $pd_level_mod = Dc_cubicle::where('PD_LEVEL','moderate')->count()  / $total_records_level * 100 ;
                $pd_level_bad = Dc_cubicle::where('PD_LEVEL','bad')->count()  / $total_records_level * 100;
                   
                $result = array( 
                    'pd_level'=> array(
                        'good'=>round($pd_level_good,2),
                        'moderate'=>round($pd_level_mod,2),
                        'bad'=>round($pd_level_bad,2)
                    ),
                    'total_record_all' =>$total_records_all,
                    'total_record_level' =>$total_records_level,
                     
                );
                return response()->json(array(    
                    'status'=>true,        
                    'data' => $result, 
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
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
}
