<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_tipe_gangguan;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcTipeGangguanController extends Controller
{
    //
    public function index(Request $request)
    {
        // $get_data=isset($_POST['data']); 
        try{
            if ($request->get('NAMA_TIPE_GANGGUAN'))
                {
                    $keyword = $request->get('NAMA_TIPE_GANGGUAN ');    
                    $result = Dc_tipe_gangguan::where('NAMA_TIPE_GANGGUAN ', 'LIKE', "%{$keyword}%" )->orderBy('ID_TIPE_GANGGUAN','DESC')->paginate(12);  
                } 
            else
                {
                    $result = Dc_tipe_gangguan::orderBy('ID_TIPE_GANGGUAN','DESC')->paginate(12);
                } 
            $total_records=Dc_tipe_gangguan::count(); 
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
