<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\API\CreateDc_apjAPIRequest;
use App\Http\Requests\API\UpdateDc_apjAPIRequest;
use App\Models\Dc_apj;
use App\Repositories\Dc_apjRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Setting;
use Froiden\RestAPI\ApiResponse;
use Froiden\RestAPI\Exceptions\ApiException;
use Illuminate\Support\Facades\App;
use Response;

/**
 * Class Dc_apjController
 * @package App\Http\Controllers\API
 */

class Dc_apjAPIController extends Controller
{ 
     
    public function index(Request $request)
    { 
        if (auth('sanctum')->check()){ 
            $result = Dc_apj::orderBy('APJ_ID','ASC')
            ->leftJoin('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw('dc_apj.APJ_ID,dc_apj.APJ_NAMA,dc_apj.APJ_ALIAS,dc_apj.APJ_DCC,count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU
            ,dc_gardu_induk.GARDU_INDUK_ID' )  
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
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function dccSingleGardu($id){
        if (auth('sanctum')->check()){  
            $result = Dc_gardu_induk::where('dc_gardu_induk.APJ_ID',$id) 
            ->join('Dc_incoming_feeder','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
            ->leftJoin('dc_cubicle','dc_cubicle.INCOMING_ID','Dc_incoming_feeder.INCOMING_ID') 
            ->orderBy('dc_incoming_feeder.GARDU_INDUK_ID','DESC')
            ->selectRaw('dc_gardu_induk.GARDU_INDUK_NAMA, SUM(dc_cubicle.PD_CRITICAL) as TOTAL_GARDU')
            ->get(); 
              
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function dccSinglePMt($id, Request $request){
        if (auth('sanctum')->check()){  
            $result = Dc_cubicle::where('dc_cubicle.APJ_ID',$id)
            ->orderBy('dc_cubicle.OUTGOING_ID','ASC') 
            ->join('dc_apj','dc_apj.APJ_ID','dc_cubicle.APJ_ID') 
            ->join('dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
            ->leftJoin('dc_gardu_induk','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
            ->selectRaw(
                'dc_cubicle.OUTGOING_ID as ID,
                dc_apj.APJ_ID as APJ_ID,
                dc_apj.APJ_NAMA as APJ_NAMA,
                dc_gardu_induk.GARDU_INDUK_ID as GARDU_ID,
                dc_gardu_induk.GARDU_INDUK_NAMA,
                dc_cubicle.CUBICLE_NAME,
                dc_cubicle.PD_LEVEL, 
                ROUND((dc_cubicle.IA+dc_cubicle.IB+dc_cubicle.IC)/3,2) as TEMPERATURE,
                dc_cubicle.HUMIDITY,
                dc_cubicle.PD_CRITICAL'
                ) ;

            if($request->APJ_NAMA){
                $keyword = $request->get('APJ_NAMA');    
                $result = $result->where('dc_apj.APJ_NAMA', 'LIKE','%' .$keyword . '%') ;
            }
            if($request->APJ_ID){
                $keyword = $request->get('APJ_ID');    
                $result = $result->where('dc_apj.APJ_ID', $keyword ) ;
            }
            if($request->GARDU_INDUK_ID){
                $keyword = $request->get('GARDU_ID');    
                $result = $result->where('GARDU_ID', $keyword ) ;
            }
            if($request->GARDU_INDUK_NAMA){
                $keyword = $request->get('GARDU_INDUK_NAMA');    
                $result = $result->where('dc_gardu_induk.GARDU_INDUK_NAMA', $keyword ) ;
            }
            if($request->PD_CRITICAL){
                $keyword = $request->get('PD_CRITICAL');    
                $result = $result->where('dc_cubicle.PD_CRITICAL', $keyword ) ;
            }

            $result = $result->paginate(10); 
            return response()->json( [           
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
     
 
}
