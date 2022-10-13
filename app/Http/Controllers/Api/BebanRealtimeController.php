<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_incoming_feeder;
use App\Models\Sm_meter_gi;
use DB;
use Illuminate\Http\Request;

class BebanRealtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try{
            $result = Dc_incoming_feeder::
            join('dc_gardu_induk','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')
            // ->select([
            //         'dc_incoming_feeder.INCOMING_ID AS ID',
            //         'dc_incoming_feeder.INCOMING_NAME', 
            //         'dc_incoming_feeder.NAMA_ALIAS_INCOMING', 
            //         'dc_gardu_induk.GARDU_INDUK_NAMA',
            //         'dc_gardu_induk.GARDU_INDUK_KODE',
            //         'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK',
            //     ])
            ->with(['dcCubicles' => function($q) {
                $q->select('OUTGOING_ID', 'INCOMING_ID');
            }])  
            ->groupBy('dc_incoming_feeder.INCOMING_ID')
            ->orderBy('dc_incoming_feeder.INCOMING_ID', 'ASC')   
            ;
            if ($request->get('gardu_induk')) 
            {
                $keyword = $request->get('gardu_induk');    
                $result =$result->where('dc_gardu_induk.GARDU_INDUK_ID','=', $keyword ) ;  
            } 
            $result = $result ->paginate(10);
            // $result = $result ->paginate(10);
             
            return response()->json(array(    
                'status'=>true,        
                'data' =>  $result, 
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
 
    public function show($id)
    { 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first();  
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->first(); 
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)
            ->orderBy('OUTGOING_ID','DESC')
            ->select('IA','IB','IC','IN')
            ->limit('10')->get();
            return response()->json(array(    
                'status'=>true,   
                'data' => array(
                    'name' => $result['CUBICLE_NAME'],       
                    'gardu_induk' => $gi->dcGarduInduk['GARDU_INDUK_NAMA'],
                    'daya_tersalur' => $result['KW'],
                    'power_factor' => $result['PF'],
     
                    'incoming_name' => $gi['INCOMING_NAME'],
                    'combine_gardu_dan_incoming' =>'GI '. $gi->dcGarduInduk['GARDU_INDUK_NAMA'].' Incoming '.$gi['INCOMING_NAME'],
                     
                    'PMT' => $history_pmt,
                ),
                // 'data' => $result, 
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
