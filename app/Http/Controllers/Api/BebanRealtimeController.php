<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dc_cubicle;
use App\Models\Dc_incoming_feeder;
use App\Models\Sm_meter_gi;
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
            $result = Dc_cubicle::
            join('Dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
            ->leftJoin('dc_gardu_induk','Dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->select('dc_cubicle.OUTGOING_ID','dc_cubicle.CUBICLE_NAME','dc_cubicle.PD_LEVEL','dc_cubicle.PD_CRITICAL','dc_incoming_feeder.INCOMING_ID','dc_gardu_induk.GARDU_INDUK_NAMA','dc_gardu_induk.GARDU_INDUK_KODE','dc_gardu_induk.GARDU_INDUK_ID') 
            ->where(function($query){
                return $query
                ->where('SCB','=','1')
                ->where('SCB_INV', '=', '0');
            })
           ->orWhere(function($query){
                return $query
                ->where('SCB','=','0')
                ->where('SCB_INV', '=', '1');
            });
            if ($request->get('gardu_induk')) 
            {
                $keyword = $request->get('gardu_induk');    
                $result =$result->where('dc_gardu_induk.GARDU_INDUK_ID','=', $keyword ) ;  
            } 
            $result = $result ->paginate(12);

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        try{
            $result = Dc_cubicle::where('OUTGOING_ID',$id)->first(); 
         
            if ($result['SCB'] == 0 && $result['SCB_INV'] == 0) 
            {
                $condition = 'open';
            }
            elseif ($result['SCB'] == 1 && $result['SCB_INV'] == 0) 
            {
                $condition = 'close';
            }
            elseif ($result['SCB'] == 0 && $result['SCB_INV'] == 1) 
            {
                $condition = 'close';
            }
            else{
                $condition = 'open';
            } 
            if ($result['SLR'] == 0 && $result['SLR_INV'] == 0) 
            {
                $lr = 'LOKAL';
            }
            elseif ($result['SLR'] == 1 && $result['SLR_INV'] == 0) 
            {
                $lr = 'REMOTE';
            }
            elseif ($result['SLR'] == 0 && $result['SLR_INV'] == 1) 
            {
                $lr = 'REMOTE';
            }
            else{
                $lr = 'LOKAL';
            }
            $gi = Dc_incoming_feeder::where('INCOMING_ID',$result['INCOMING_ID'])->first(); 
            $history_pmt = Sm_meter_gi::where('OUTGOING_ID',$id)->orderBy('OUTGOING_METER_ID','DESC')->limit('1')->get();
            return response()->json(array(    
                'status'=>true,  
                'topstatus' => $result['PD_LEVEL'],
                'condition' => $condition,      
                'lr' => $lr,
                'total_beban' => array(
                    'phasa_r' => '',
                    'phasa_s' => '',
                    'phasa_t' => '',
                    'tegangan' => ''
                ),
                'gi' => $gi->dcGarduInduk['GARDU_INDUK_NAMA'],
                'incoming_name' => $gi['INCOMING_NAME'],
                'combine_gardu_dan_incoming' =>'GI '. $gi->dcGarduInduk['GARDU_INDUK_NAMA'].' Incoming '.$gi['INCOMING_NAME'],
                'temperatur_a' =>$gi['TEMP_A'],
                'temperatur_b' =>$gi['TEMP_B'],
                'temperatur_c' =>$gi['TEMP_C'], 
                'history_pmt' => $history_pmt,
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
