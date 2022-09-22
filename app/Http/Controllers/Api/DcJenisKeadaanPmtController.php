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
        return ApiResponse::make(array(            
            'data' => $result,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }
}
