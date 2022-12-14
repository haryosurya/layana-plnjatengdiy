<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting as ModelsSetting; 
use Froiden\RestAPI\ApiController;
use Froiden\RestAPI\ApiResponse;
use Illuminate\Support\Facades\App;
use Modules\RestAPI\Entities\RestAPISetting;
use App\Traits\FileSystemSettingTrait;

class ApiBaseController extends Controller
{
    use FileSystemSettingTrait;
    // public function __construct()
    // {
    //     parent::__construct();

    //     $userLocale = 'en';
    //     if (!api_user()) {
    //         $setting = ModelsSetting::select('locale')->first();
    //         if ((!is_null($setting)) && (!is_null($setting->locale))) {
    //             $userLocale = $setting->locale;
    //         }
    //     } else {
    //         $userLocale = ((!is_null(api_user()->locale)) ? api_user()->locale : 'en');
    //     }
    //     App::setLocale($userLocale);
    //     $this->setFileSystemConfigs();
    //     // SET default guard to api
    //     // auth('api')->user will be accessed as auth()->user();
    //     config(['auth.defaults.guard' => 'api']);

    //     // Set JWT SECRET KEY HERE 
        
    //     config(['jwt.secret' => config('restapi.jwt_secret')]);
    //     config(['app.debug' => config('restapi.debug')]);
        
    // }
    protected $global;
    public $user;

    public function __construct()
    {
        $this->global = global_setting();
        $this->user = user();
    }
    
}
