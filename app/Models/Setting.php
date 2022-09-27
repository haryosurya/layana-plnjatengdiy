<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends BaseModel
{
    protected $table = 'organisation_settings';

    protected $appends = [
        'logo_url',
        'login_background_url',
        'show_public_message',
        'moment_date_format',
        'favicon_url'
    ];

    const DATE_FORMATS = [
        'd-m-Y' => 'DD-MM-YYYY',
        'm-d-Y' => 'MM-DD-YYYY',
        'Y-m-d' => 'YYYY-MM-DD',
        'd.m.Y' => 'DD.MM.YYYY',
        'm.d.Y' => 'MM.DD.YYYY',
        'Y.m.d' => 'YYYY.MM.DD',
        'd/m/Y' => 'DD/MM/YYYY',
        'm/d/Y' => 'MM/DD/YYYY',
        'Y/m/d' => 'YYYY/MM/DD',
        'd/M/Y' => 'DD/MMM/YYYY',
        'd.M.Y' => 'DD.MMM.YYYY',
        'd-M-Y' => 'DD-MMM-YYYY',
        'd M Y' => 'DD MMM YYYY',
        'd F, Y' => 'DD MMMM, YYYY',
        'D/M/Y' => 'ddd/MMM/YYYY',
        'D.M.Y' => 'ddd.MMM.YYYY',
        'D-M-Y' => 'ddd-MMM-YYYY',
        'D M Y' => 'ddd MMM YYYY',
        'd D M Y' => 'DD ddd MMM YYYY',
        'D d M Y' => 'ddd DD MMM YYYY',
        'dS M Y' => 'Do MMM YYYY',
    ]; 

    public function getLogoUrlAttribute()
    {
        if (user()) {
            if (user()->dark_theme) {
                return $this->defaultLogo();
            }
        }

        if (global_setting()->auth_theme == 'dark') {
            return $this->defaultLogo();

        }

        if (is_null($this->light_logo)) {
            return asset('img/default-logo.png');
        }

        return asset_url('app-logo/' . $this->light_logo);

    }

    public function defaultLogo()
    {
        if (is_null($this->logo)) {
            return asset('img/default-logo.png');
        }

        return asset_url('app-logo/' . $this->logo);
    }

    public function getLightLogoUrlAttribute()
    {
        if (is_null($this->light_logo)) {
            return asset('img/default-logo.png');
        }

        return asset_url('app-logo/' . $this->light_logo);
    }

    public function getDarkLogoUrlAttribute()
    {

        if (is_null($this->logo)) {
            return asset('img/default-logo.png');
        }

        return asset_url('app-logo/' . $this->logo);
    }

    public function getLoginBackgroundUrlAttribute()
    {

        if (is_null($this->login_background) || $this->login_background == 'login-background.jpg') {
            return null;
        }

        return asset_url('login-background/' . $this->login_background);
    }

    public function getShowPublicMessageAttribute()
    {
        if (strpos(request()->url(), request()->getHost() . '/public') !== false) {
            return true;
        }

        return false;
    }

    public function getMomentDateFormatAttribute()
    {
        return self::DATE_FORMATS[$this->date_format];
    }

    public static function organisationSetting()
    {
        return global_setting();
    }

    public function getFaviconUrlAttribute()
    {
        if (is_null($this->favicon)) {
            return asset('img/default-logo.png');
        }

        return asset_url('favicon/' . $this->favicon);
    }
}
