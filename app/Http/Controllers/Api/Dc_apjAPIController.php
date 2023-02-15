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
use DB;
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
            ->selectRaw('
            dc_apj.APJ_ID,
            dc_apj.APJ_NAMA,
            dc_apj.APJ_ALIAS,
            dc_apj.APJ_DCC,
            count(dc_apj.APJ_NAMA) as APJ,
            count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU '
             )  
             ->where('dc_apj.APJ_ID','!=','12')
             ->where('dc_apj.APJ_ID','!=','13')
             ->groupBy('dc_apj.APJ_DCC');
             
             if(auth()->user()->user_other_role != 'admin' || auth()->user()->employeeDetail->apj_id != '12' || auth()->user()->employeeDetail->apj_id != '13'){ 
                $result =  $result->where( 'dc_apj.APJ_ID',auth()->user()->employeeDetail->apj_id);
             }

            if ($request->get('APJ_DCC'))
            {
                $keyword = $request->get('APJ_DCC');    
                $result = $result->where('APJ_DCC', 'LIKE', "%{$keyword}%" ) ;
            } 
            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID','LIKE', "%{$keyword}%") ;
            } 

            $result = $result->paginate(12); 
            return response()->json( [           
                'cred' => auth()->user()->user_other_role,
                'user' => auth()->user()->employeeDetail->apj_id,
                'status' => true,
                'data' => $result, 
                'status_code' => 200
            ]);
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    public function upjList(Request $request){
        if (auth('sanctum')->check()){  
            $result = Dc_apj::orderBy('APJ_ID','ASC')
            ->leftJoin('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw('
            dc_apj.APJ_ID,
            dc_apj.APJ_NAMA,
            dc_apj.APJ_ALIAS,
            dc_apj.APJ_DCC,
            count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU '
            )   
            ->where('dc_apj.APJ_ID','!=','12')
            ->where('dc_apj.APJ_ID','!=','13')
            ->groupBy('dc_apj.APJ_ID');
            
            // if(auth()->user()->user_other_role != 'admin'){ 
                // $result =  $result->where( 'dc_apj.APJ_ID',auth()->user()->employeeDetail->apj_id);
            // } 
            $keyword = $request->get('APJ_DCC');    
            $result = $result->where('APJ_DCC', 'LIKE', "%{$keyword}%" ) ; 


            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID','LIKE', "%{$keyword}%") ;
            } 

            if(auth()->user()->user_other_role == 'employee'){
                if(auth()->user()->employeeDetail->apj_id == '12' || auth()->user()->employeeDetail->apj_id == '13' ){ 
                    $result = $result->paginate(10);  
                    return response()->json( [           
                        'status' => true,
                        'data' => $result, 
                        'status_code' => 200
                    ]);
                }else{
                    $result =  $result->where( 'dc_apj.APJ_ID',auth()->user()->employeeDetail->apj_id);
                    $result = $result->paginate(10);  
                    return response()->json( [           
                        'status' => true,
                        'data' => $result, 
                        'status_code' => 200
                    ]);
                }
            }
            // elseif(auth()->user()->user_other_role == 'admin'){
            // } 
            else{
                $result = $result->paginate(10);  
                return response()->json( [           
                    'status' => true,
                    'data' => $result, 
                    'status_code' => 200
                ]); 
            }

            
        } 
        else{ 
            return response()->json(['status'=>false,'Unauthenticated.',200]);
        }
    }
    
    public function upjList2(Request $request){
        if (auth('sanctum')->check()){  
            $result = Dc_apj::orderBy('APJ_ID','ASC')
            ->leftJoin('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->selectRaw('
            dc_apj.APJ_ID,
            dc_apj.APJ_NAMA,
            dc_apj.APJ_ALIAS,
            dc_apj.APJ_DCC,
            count(dc_gardu_induk.GARDU_INDUK_NAMA) as TOTAL_GARDU '
            )   
            ->where('dc_apj.APJ_ID','!=','12')
            ->where('dc_apj.APJ_ID','!=','13')
            ->groupBy('dc_apj.APJ_ID');
            
            // if(auth()->user()->user_other_role != 'admin'){ 
                // $result =  $result->where( 'dc_apj.APJ_ID',auth()->user()->employeeDetail->apj_id);
            // } 
            $keyword = $request->get('APJ_DCC');    
            $result = $result->where('APJ_DCC', 'LIKE', "%{$keyword}%" ) ; 


            if ($request->get('GARDU_INDUK_ID'))
            {
                $keyword = $request->get('GARDU_INDUK_ID');    
                $result = $result->where('GARDU_INDUK_ID','LIKE', "%{$keyword}%") ;
            } 

            if(auth()->user()->user_other_role == 'employee'){
                if(auth()->user()->employeeDetail->apj_id == '12' || auth()->user()->employeeDetail->apj_id == '13' ){ 
                    $result = $result->get();  
                    return response()->json( [           
                        'status' => true,
                        'data' => $result, 
                        'status_code' => 200
                    ]);
                }else{
                    $result =  $result->where( 'dc_apj.APJ_ID',auth()->user()->employeeDetail->apj_id);
                    $result = $result->get();  
                    return response()->json( [           
                        'status' => true,
                        'data' => $result, 
                        'status_code' => 200
                    ]);
                }
            }
            // elseif(auth()->user()->user_other_role == 'admin'){
            // } 
            else{
                $result = $result->get();  
                return response()->json( [           
                    'status' => true,
                    'data' => $result, 
                    'status_code' => 200
                ]); 
            }

            
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
     
 
}
