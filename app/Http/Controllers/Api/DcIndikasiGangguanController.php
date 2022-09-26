<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_indikasi_gangguan;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcIndikasiGangguanController extends Controller
{
    //
    public function index(Request $request)
    {
        // $get_data=isset($_POST['data']); 
        try{ 
            if ($request->get('NAMA_INDIKASI_GANGGUAN'))
            {
                $keyword = $request->get('NAMA_INDIKASI_GANGGUAN');    
                $result = Dc_indikasi_gangguan::where('NAMA_INDIKASI_GANGGUAN', 'LIKE', "%{$keyword}%" )->orderBy('ID_INDIKASI_GANGGUAN','DESC')->paginate(12);  
            }
             
            else
            {
                $result = Dc_indikasi_gangguan::orderBy('ID_INDIKASI_GANGGUAN','DESC')->paginate(12);
            } 
            $total_records=Dc_indikasi_gangguan::count(); 
            return ApiResponse::make(array(
                'status' => true,            
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
