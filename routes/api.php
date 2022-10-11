<?php

use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BebanRealtimeController;
use App\Http\Controllers\Api\DashController;
use App\Http\Controllers\Api\Dc_apjAPIController;
use App\Http\Controllers\Api\DcCubicleController;
use App\Http\Controllers\Api\DcGarduIndukController;
use App\Http\Controllers\Api\DcIncomingFeederController;
use App\Http\Controllers\Api\DcIndikasiGangguanController;
use App\Http\Controllers\Api\DcIndikasiGangguanTipeController; 
use App\Http\Controllers\Api\DcJenisKeadaanPmtController;
use App\Http\Controllers\Api\DcSpeedjardistCuacaController;
use App\Http\Controllers\Api\DcTipeGangguanController;
use App\Http\Controllers\Api\EwsHistoryMeterController;
use App\Http\Controllers\Api\EwsInspeksiAsetController;
use App\Http\Controllers\Api\EwsInspeksiPdController;
use App\Http\Controllers\Api\RekapGangguanPmtController;
use App\Http\Controllers\Api\SmMeterGiController;
use Froiden\RestAPI\Facades\ApiRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
// Route::get('apitest',[AppController::class, 'app','as' => 'app', ]);
Route::post('auth/login',[AuthController::class, 'login','as' => 'auth.login']);

Route::group(['middleware' => ['auth:sanctum']], function () {  
    /* AUTH */
        Route::post('auth/logout',[AuthController::class, 'logout','as' => 'auth.logout', ]);
        Route::post('auth/reset-password',[AuthController::class, 'resetPassword','as' => 'auth.resetPassword', ]);
        Route::post('auth/refresh',[AuthController::class, 'refresh','as' => 'auth.refresh', ]);
        Route::post('auth/forgot-password',[AuthController::class, 'forgotPassword','as' => 'auth.forgotPassword', ]); 
    /* END AUTH */
    /* DASHBOARD */
        Route::get('dash',[DashController::class, 'index','as' => 'dash']);
    /* DASHBOARD */


    /* DATA PENYULANG */ 
    /* DCC APJ */
    Route::get('dcApjs',[ Dc_apjAPIController::class,'index']);
    /* DCC APJ */
    Route::get('dccSinglePMt/{id}',[ Dc_apjAPIController::class,'dccSinglePMt']);
    Route::get('dcCubicle/{id}', [DcCubicleController::class,'single']);
    Route::get('dcCubicle', [DcCubicleController::class,'index']);
    /* DATA PENYULANG */
    
    /* BEBAN REALTIME */
    Route::get('bebanRealtime', [BebanRealtimeController::class,'index']);
    Route::get('bebanRealtime/{id}', [BebanRealtimeController::class,'show']);
    // Route::get('bebanRealtime/{id}', [DcCubicleController::class,'singleRealtime']);
    /* BEBAN REALTIME */
    
    /* REKAP GANGGUAN */
    Route::get('rekapGangguan', [RekapGangguanPmtController::class,'index']);
    Route::get('rekapGangguanPMTscada', [RekapGangguanPmtController::class,'rekapGangguanPMTscada']);
    Route::get('rekapGangguanPD', [RekapGangguanPmtController::class,'rekapGangguanPD']);
    Route::get('rekapInspeksiAset', [RekapGangguanPmtController::class,'rekapInspeksiAset']);
    // Route::get('rekapInspeksiAset', [EwsInspeksiAsetController::class,'list']);   
    // Route::get('CountingGangguan',[DashController::class, 'CountingGangguan','as' => 'CountingGangguan']); 
    /* REKAP GANGGUAN */
    
    Route::get('pmt', [DcCubicleController::class,'Pmt']); 
    /* profile */
    Route::get('profile',[ AuthController::class,'me']); 
    /* profile */
    








    Route::get('dccSingleGardu/{id}',[ Dc_apjAPIController::class,'dccSingleGardu']); 
    Route::get('dcGarduInduk', [DcGarduIndukController::class,'index']); /* gardu induk */
    Route::get('DcIncomingFeeder', [DcIncomingFeederController::class,'index']);
    Route::get('DcIndikasiGangguan', [DcIndikasiGangguanController::class,'index']);
    Route::get('DcIndikasiGangguanTipe', [DcIndikasiGangguanTipeController::class,'index']);
    Route::get('DcJenisKeadaanPmt', [DcJenisKeadaanPmtController::class,'index']);
    Route::get('DcSpeedjardist', [DcSpeedjardistCuacaController::class,'index']);
    Route::get('DcTipeGangguan', [DcTipeGangguanController::class,'index']);
    Route::get('SmMeterGi', [SmMeterGiController::class,'index']);
 
    Route::get('ListEwsHistoryMeter', [EwsHistoryMeterController::class,'ListEwsHistoryMeter']);
    Route::post('storeEwsHistoryMeter', [EwsHistoryMeterController::class,'storeEwsHistoryMeter']);
    Route::post('updateEwsHistoryMeter/{id}', [EwsHistoryMeterController::class,'updateEwsHistoryMeter']);
    Route::post('destroyEwsHistoryMeter/{id}', [EwsHistoryMeterController::class,'destroyEwsHistoryMeter']);
    
    Route::get('InspeksiPd', [EwsInspeksiPdController::class,'indexInspeksiPd']);
    Route::post('storeInspeksiPd/{id}', [EwsInspeksiPdController::class,'storeInspeksiPd']);
 
    Route::post('rekapInspeksiAset', [EwsInspeksiAsetController::class,'list']);
    Route::post('rekapInspeksiAset/{id}', [EwsInspeksiAsetController::class,'FormInput']);
 
}); 


