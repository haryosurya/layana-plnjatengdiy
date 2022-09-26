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
            if ($request->get('APJ_NAMA'))
            {
                $keyword = $request->get('APJ_NAMA');    
                $result = Dc_apj::where('APJ_NAMA', $keyword )->orderBy('APJ_ID','DESC')->paginate(12);  
            }
            else
            {
                $result = Dc_apj::orderBy('APJ_ID','DESC')->paginate(12);
            } 
            $total_records=Dc_apj::count(); 
            return response()->json( [           
                'status' => true,
                'data' => $result,
                'total_records' => $total_records,
                'status_code' => 200
            ]);
        } 
        else{ 
            return ApiResponse::make(['status'=>false,'Unauthenticated.',200]);
        }
    }
     
 
}
