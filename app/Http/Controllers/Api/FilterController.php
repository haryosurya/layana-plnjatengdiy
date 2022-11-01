<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use App\Models\Dc_indikasi_gangguan;
use App\Models\Dc_indikasi_gangguan_tipe;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    //
    public function DataPenyulangFilter(Request $request){

        try{
            $dcc =  Dc_apj::get();
            $gi =  Dc_gardu_induk::get();
            $trafo =  Dc_incoming_feeder::get();
            $cubicle =  Dc_cubicle::get();

            return response()->json(array(    
                'status'=>true,        
                'data' => ['dcc'=>$dcc,'gi'=>$gi,'trafo'=>$trafo,'cubicle'=>$cubicle],  
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
    public function RekapGangguanFilter(Request $request){
        try{
            // $dcc =  Dc_apj::get();
            $gi =  Dc_gardu_induk::get();
            // $trafo =  Dc_incoming_feeder::get();
            // $cubicle =  Dc_cubicle::get();
            $jenisGangguantipe = Dc_indikasi_gangguan_tipe::get();
            $jenisGangguan = Dc_indikasi_gangguan::get();
            // $
            return response()->json(array(    
                'status'=>true,        
                'data' => ['gi'=>$gi,'jenis_gangguan_tipe'=>$jenisGangguantipe,'jenis_gangguan'=>$jenisGangguan],  
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
