<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Http\Request;

class AppController extends ApiBaseController
{
    //    
    public function app()
    {
        $setting = Setting::first();

        return ApiResponse::make('Application data fetched successfully', $setting->toArray());
    } 
} 
