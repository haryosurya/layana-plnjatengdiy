<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        DB::table('language_settings')->delete();
        $languages = [
            ['language_code' => 'id', 'language_name' => 'Indonesia', 'status' => 'enabled'], 
            ['language_code' => 'en', 'language_name' => 'English', 'status' => 'enabled'], 
        ];

        DB::table('language_settings')->insert($languages);
    }
}
