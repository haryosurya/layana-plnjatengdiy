<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_jenis_keadaan_pmt;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class DcJenisKeadaanPmtController extends Controller
{ 
    public function index(Request $request)
    {
        // $get_data=isset($_POST['data']);
        try{
            if ($request->get('JENIS_KEADAAN_PMT'))
                {
                    $keyword = $request->get('JENIS_KEADAAN_PMT ');    
                    $result = Dc_jenis_keadaan_pmt::where('JENIS_KEADAAN_PMT ', 'LIKE', "%{$keyword}%" )->orderBy('JENIS_KEADAAN_PMT_ID','DESC')->paginate(12);  
                } 
            else
                {
                    $result = Dc_jenis_keadaan_pmt::orderBy('JENIS_KEADAAN_PMT_ID','DESC')->paginate(12);
                } 
            $total_records=Dc_jenis_keadaan_pmt::count(); 
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
