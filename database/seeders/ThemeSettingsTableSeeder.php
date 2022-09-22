<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\ThemeSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemeSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('theme_settings')->delete();

        $theme = new ThemeSetting();
        $theme->panel = 'admin';
        $theme->header_color = '#1d82f5';
        $theme->sidebar_color = '#171F29';
        $theme->sidebar_text_color = '#99A5B5';
        $theme->link_color = '#F7FAFF';
        $theme->save();
 
        // employee panel
        $theme = new ThemeSetting();
        $theme->panel = 'employee';
        $theme->header_color = '#1d82f5';
        $theme->sidebar_color = '#171F29';
        $theme->sidebar_text_color = '#99A5B5';
        $theme->link_color = '#F7FAFF';
        $theme->save();
 
        Setting::whereNotNull('id')->update(
            ['logo_background_color' => '#ffffff']
        );
    }
}
