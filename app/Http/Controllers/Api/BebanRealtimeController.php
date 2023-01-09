<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_incoming_feeder;
use App\Models\Sm_meter_gi;
use Carbon\Carbon;
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
 
    public function show($id, Request $request)
    { 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first();  
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->first();
            // $historylastdate = Sm_meter_gi 
            // ::orderBy('OUTGOING_METER_ID','DESC') 
            // ->max('IA_TIME') ;
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id) 
            // ->orderBy('IA_TIME','DESC')
            // ORDER BY HOUR(date_time), MINUTE(date_time), date_time
            ->orderBy(DB::raw('HOUR(IA_TIME)'))
            ->limit('24') 
            ->select('IA','IB','IC','IN','IA_TIME')  
            ;
            if ($request->get('date'))
            {
                $keyword = $request->get('date');  
                $date =   date('Y-m-d', strtotime( $keyword ));
                $history_pmt = $history_pmt
                ->whereDate('IA_TIME',$date )
                ->get()
                ;
            }
            else
            {
                $date=date('Y-m-d', strtotime( Carbon::now()->format('Y-m-d') ));
                $history_pmt = $history_pmt 
                ->whereDate('IA_TIME', $date) 
                ->get()
                ;
            } 
            $dd = Sm_meter_gi::get()->groupBy(function($date) {
                        return Carbon::parse($date->IA_TIME)->format('h');
            });


            $pmt_paginate = Sm_meter_gi::where('OUTGOING_ID',$id) 
            ->orderBy('IA_TIME','DESC')
            ->take('100') 
            ->select('IA','IB','IC','IN','IA_TIME')  
            ;
            if ($request->get('date'))
            {
                $keyword = $request->get('date');    
                $pmt_paginate = $pmt_paginate
                ->whereDate('IA_TIME', date('Y-m-d', strtotime( $keyword ))) 
                ;
            }
            else
            {
                $pmt_paginate = $pmt_paginate
                -> latest('IA_TIME') 
                ;
            } 

            return response()->json(array(    
                'status'=>true,   
                'data' => array(
                    'name' => $result['CUBICLE_NAME'],       
                    'gardu_induk' => $gi->dcGarduInduk['GARDU_INDUK_NAMA'],
                    'vll' => $result['VLL'],
                    'daya_tersalur' => $result['KW'],
                    'power_factor' => $result['PF'],
     
                    'incoming_name' => $gi['INCOMING_NAME'],
                    'combine_gardu_dan_incoming' =>'GI '. $gi->dcGarduInduk['GARDU_INDUK_NAMA'].' Incoming '.$gi['INCOMING_NAME'],
                     
                    'PMT' => $dd,
                    'PMT_COUNT' => $history_pmt->count(),
                    'PMT_PAGINATE' => $pmt_paginate->paginate(10),
                    // 'PMT_LAST_DATE' => $historylastdate,
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
