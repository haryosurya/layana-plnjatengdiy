<?php

use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Dc_apjAPIController;
use App\Http\Controllers\Api\DcCubicleController;
use App\Http\Controllers\Api\DcGarduIndukController;
use App\Http\Controllers\Api\DcIncomingFeederController;
use App\Http\Controllers\Api\DcIndikasiGangguanController;
use App\Http\Controllers\Api\DcIndikasiGangguanTipeController;
use App\Http\Controllers\Api\DcJenisKeadaanPmtController;
use App\Http\Controllers\Api\DcSpeedjardistCuacaController;
use App\Http\Controllers\Api\DcTipeGangguanController;
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
 
Route::get('apitest',[AppController::class, 'app','as' => 'app', ]);
Route::post('auth/login',[AuthController::class, 'login','as' => 'auth.login']);
Route::group(['middleware' => ['auth:sanctum']], function () { 
// Route::group(['middleware' => ['api']], function () { 
    Route::get('test',[AppController::class, 'app','as' => 'app', ]);
    Route::post('auth/logout',[AuthController::class, 'logout','as' => 'auth.logout', ]);
    Route::post('auth/reset-password',[AuthController::class, 'resetPassword','as' => 'auth.resetPassword', ]);
    Route::post('auth/refresh',[AuthController::class, 'refresh','as' => 'auth.refresh', ]);
    Route::post('auth/forgot-password',[AuthController::class, 'forgotPassword','as' => 'auth.forgotPassword', ]); 
    Route::get('profile',[ AuthController::class,'me']);
    Route::get('dcApjs',[ Dc_apjAPIController::class,'index']);
    Route::get('dcCubicle', [DcCubicleController::class,'index']);
    Route::get('dcGarduInduk', [DcGarduIndukController::class,'index']);
    Route::get('DcIncomingFeeder', [DcIncomingFeederController::class,'index']);
    Route::get('DcIndikasiGangguan', [DcIndikasiGangguanController::class,'index']);
    Route::get('DcIndikasiGangguanTipe', [DcIndikasiGangguanTipeController::class,'index']);
    Route::get('DcJenisKeadaanPmt', [DcJenisKeadaanPmtController::class,'index']);
    Route::get('DcSpeedjardist', [DcSpeedjardistCuacaController::class,'index']);
    Route::get('DcTipeGangguan', [DcTipeGangguanController::class,'index']);
    Route::get('SmMeterGi', [SmMeterGiController::class,'index']);
}); 


