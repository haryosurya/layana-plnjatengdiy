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
        try{
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
            return response()->json(array(    
                'status'=>true,        
                'data' => $result,
                'total_records' => $total_records,
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
