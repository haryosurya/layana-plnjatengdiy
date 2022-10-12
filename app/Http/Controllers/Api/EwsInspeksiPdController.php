<?php

namespace App\Http\Controllers\Api;

use App\Helper\Files;
use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_inspeksi_pd;
use App\Models\ews_inspeksi_pd;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class EwsInspeksiPdController extends Controller
{
    //
    public function indexInspeksiPd(Request $request)
    {
        //
        try{ 
            $result = ews_inspeksi_pd::orderBy('id_inspeksi_pd','DESC');
            if ($request->get('id_outgoing'))
            {
                $keyword = $request->get('id_outgoing');    
                $result = $result->where('id_outgoing', 'LIKE', "%{$keyword}%" );  
            }  
            return response()->json(array(   
                'status'=>true,         
                'data' => $result->paginate(12), 
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

    public function storeInspeksiPd(Request $request ,$id)
    {
        //
        try{

            $setting = global_setting();
            $validator = Validator::make($request->all(), [
                'tgl_inspeksi' => 'required|date_format:"' . $setting->date_format . '"', 
                'foto_pelaksanaan' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
                'foto_pengukuran' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            ]); 
            if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 500); 
            } 
            $foto_pelaksanaan = $request->file('foto_pelaksanaan'); 
            $storeuploadfoto_pelaksanaan = Files::uploadLocalOrS3(request()->foto_pelaksanaan, 'pd');
    
            $foto_pelaksanaanResponse = array(
                "image_name" => basename($storeuploadfoto_pelaksanaan),
                "image_url" => asset('user-uploads/pd/'. basename($storeuploadfoto_pelaksanaan)),
                "mime" => $foto_pelaksanaan->getClientMimeType()
            );
    
            $foto_pengukuran = $request->file('foto_pengukuran'); 
            $storeuploadfoto_pengukuran = Files::uploadLocalOrS3(request()->foto_pengukuran, 'pd'); 
            $foto_pengukuranResponse = array(
                "image_name" => basename($storeuploadfoto_pengukuran),
                "image_url" => asset('user-uploads/pd/'. basename($storeuploadfoto_pengukuran)),
                "mime" => $foto_pengukuran->getClientMimeType()
            );
    
            $cubicle = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
            $inspectAsset = new ews_inspeksi_pd();
            $inspectAsset->id_outgoing = $cubicle['OUTGOING_ID'] ;
            $inspectAsset->id_user = Auth::user()->id;
            $inspectAsset->id_gardu_induk = $cubicle->dcIncomingFeeder->GARDU_INDUK_ID;
            $inspectAsset->tgl_entry = Carbon::createFromFormat($this->global->date_format , $request->tgl_entry)->format('Y-m-d H:i:s'); 
            $inspectAsset->tgl_inspeksi = Carbon::createFromFormat($this->global->date_format , $request->tgl_inspeksi)->format('Y-m-d H:i:s'); 
            $inspectAsset->citicality = $request->citicality;
            $inspectAsset->level_pd = $request->level_pd;
            $inspectAsset->keterangan = $request->keterangan;
            $inspectAsset->id_update = $request->id_update;
            $inspectAsset->last_update = Carbon::createFromFormat($this->global->date_format ,$request->last_update)->format('Y-m-d H:i:s');
            /* image */
            $inspectAsset->foto_pelaksanaan = json_encode($foto_pelaksanaanResponse);
            $inspectAsset->foto_pengukuran = json_encode($foto_pengukuranResponse);
    
    
            $inspectAsset->save();
     
            return response()->json(array(   
                'status'=>true,         
                'data' => $inspectAsset, 
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
