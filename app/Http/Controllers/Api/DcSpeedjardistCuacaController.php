<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_speedjardist_cuaca;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcSpeedjardistCuacaController extends Controller
{
    //
    public function index(Request $request)
    {
        // $get_data=isset($_POST['data']); 
        try{
            if ($request->get('CUACA_NAME'))
                {
                    $keyword = $request->get('CUACA_NAME ');    
                    $result = Dc_speedjardist_cuaca::where('CUACA_NAME ', 'LIKE', "%{$keyword}%" )->orderBy('ID_CUACA','DESC')->paginate(12);  
                } 
            else
                {
                    $result = Dc_speedjardist_cuaca::orderBy('ID_CUACA','DESC')->paginate(12);
                } 
            $total_records=Dc_speedjardist_cuaca::count(); 
            return ApiResponse::make(array(   
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
