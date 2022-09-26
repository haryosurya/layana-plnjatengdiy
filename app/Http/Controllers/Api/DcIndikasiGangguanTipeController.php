<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_indikasi_gangguan_tipe; 
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcIndikasiGangguanTipeController extends Controller
{
    //
    public function index(Request $request)
    {
        // $get_data=isset($_POST['data']); 
        try{ 
            if ($request->get('NAMA_TIPE_INDIKASI_GGN'))
            {
                $keyword = $request->get('NAMA_TIPE_INDIKASI_GGN');    
                $result = Dc_indikasi_gangguan_tipe::where('NAMA_TIPE_INDIKASI_GGN', 'LIKE', "%{$keyword}%" )->orderBy('ID_TIPE_INDIKASI_GGN','DESC')->paginate(12);  
            }
             
            else
            {
                $result = Dc_indikasi_gangguan_tipe::orderBy('ID_TIPE_INDIKASI_GGN','DESC')->paginate(12);
            } 
            $total_records=Dc_indikasi_gangguan_tipe::count(); 
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
