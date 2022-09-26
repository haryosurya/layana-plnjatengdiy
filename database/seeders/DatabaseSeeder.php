<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(GlobalSettingSeeder::class);
        $this->call(FileStorageSettingsTableSeeder::class);
        $this->call(LanguageSettingsSeeder::class);
        $this->call(SocialAuthSettingsTableSeeder::class);
        $this->call(ThemeSettingsTableSeeder::class);
        $this->call(ModuleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        
    }
}
