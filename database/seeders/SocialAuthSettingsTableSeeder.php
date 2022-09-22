<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialAuthSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('social_auth_settings')->delete();
        
        DB::table('social_auth_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'facebook_client_id' => NULL,
                'facebook_secret_id' => NULL,
                'facebook_status' => 'disable',
                'google_client_id' => NULL,
                'google_secret_id' => NULL,
                'google_status' => 'disable',
                'twitter_client_id' => NULL,
                'twitter_secret_id' => NULL,
                'twitter_status' => 'disable',
                'linkedin_client_id' => NULL,
                'linkedin_secret_id' => NULL,
                'linkedin_status' => 'disable',
                'created_at' => '2022-08-17 16:33:29',
                'updated_at' => '2022-08-17 16:33:29',
            ),
        ));
    }
}
