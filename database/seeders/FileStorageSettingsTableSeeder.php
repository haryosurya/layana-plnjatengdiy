<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileStorageSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_storage_settings')->delete();
        
        DB::table('file_storage_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'filesystem' => 'local',
                'auth_keys' => NULL,
                'status' => 'enabled',
                'created_at' => '2022-08-17 16:33:09',
                'updated_at' => '2022-08-17 16:33:09',
            ),
        ));
    }
}
