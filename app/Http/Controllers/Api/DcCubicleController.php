<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcCubicleController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->get('CUBICLE_NAME')) 
        {
            $keyword = $request->get('CUBICLE_NAME');    
            $result = Dc_cubicle::where('CUBICLE_NAME', $keyword )->orderBy('OUTGOING_ID','DESC')->paginate(12);  
        }
        else
        {
            $result = Dc_cubicle::orderBy('OUTGOING_ID','DESC')->paginate(12);
        } 
        $total_records=Dc_cubicle::count(); 
        return ApiResponse::make(array(            
            'data' => $result,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }
}
