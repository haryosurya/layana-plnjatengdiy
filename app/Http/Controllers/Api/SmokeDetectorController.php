<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_apj;
use App\Models\Dc_gardu_induk;
use App\Models\sm_material_panel;
use Illuminate\Http\Request;

class SmokeDetectorController extends Controller
{
    //
    public function list_dcc(Request $request){
        try{
            $result = Dc_apj::orderBy('APJ_ID','ASC')
            ->leftJoin('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw('dc_apj.APJ_ID,dc_apj.APJ_NAMA,dc_apj.APJ_ALIAS,dc_apj.APJ_DCC,count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU
            ,dc_gardu_induk.GARDU_INDUK_ID')  
            ->groupBy('dc_apj.APJ_ID');

            if ($request->get('APJ_DCC'))
            {
                $keyword = $request->get('APJ_DCC');    
                $result = $result->where('APJ_DCC', $keyword ) ;
            } 
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID', $keyword ) ;
            } 

            $result = $result->paginate(12); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list_smoke(Request $request, $id){
        try{
            $result = sm_material_panel::orderBy('MATERIAL_PANEL_ID','DESC')
            ->join('dc_gardu_induk','sm_material_panel.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw( 
                'sm_material_panel.MATERIAL_PANEL_ID,
                sm_material_panel.KETERANGAN as KETERANGAN,
                sm_material_panel.TANGGAL_PEMASANGAN as TANGGAL_PEMASANGAN,
                sm_material_panel.LAST_UPDATE as LAST_UPDATE,
                dc_apj.APJ_ID,
                dc_apj.APJ_NAMA,  
                dc_apj.APJ_DCC as APJ_DCC,  
                dc_gardu_induk.GARDU_INDUK_NAMA, 
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_INDUK_ID'
            )   
            ;
            $result = $result->where('KETERANGAN', '!=', "" ) ;

            if ($request->get('KETERANGAN'))
            {
                $keyword = $request->get('KETERANGAN');    
                $result = $result->orWhere('KETERANGAN', $keyword ) ;
            }  
            if ($request->get('TANGGAL_PEMASANGAN'))
            {
                $keyword = $request->get('TANGGAL_PEMASANGAN');    
                $result = $result->where('TANGGAL_PEMASANGAN', $keyword ) ;
            } 
            if ($request->get('LAST_UPDATE'))
            {
                $keyword = $request->get('LAST_UPDATE');    
                $result = $result->where('LAST_UPDATE', $keyword ) ;
            } 
            if ($request->get('APJ_DCC'))
            {
                $keyword = $request->get('APJ_DCC');    
                $result = $result->where('APJ_DCC', $keyword ) ;
            } 
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID', $keyword ) ;
            } 

            $result = $result->paginate(12); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
    public function detail_smoke($id){
        try{
            $result = sm_material_panel::where('MATERIAL_PANEL_ID',$id)
            ->join('dc_gardu_induk','sm_material_panel.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            // ->selectRaw( 
            //     'dc_apj.APJ_ID,
            //     dc_apj.APJ_NAMA,  
            //     dc_apj.APJ_DCC,  
            //     dc_gardu_induk.GARDU_INDUK_NAMA,  
            //     dc_gardu_induk.GARDU_INDUK_ID'
            // ) 
            // ->select('sm_material_panel.*')  
            ; 
            $result = $result->get(); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        }
        catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
