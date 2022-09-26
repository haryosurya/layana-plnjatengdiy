<?php

namespace Database\Seeders;

use App\Models\EmployeeDetails;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->delete();
        DB::table('role_user')->delete();

        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');

        $allPermissions = Permission::all();

        $admin = new Role();
        $admin->name = 'admin';
        $admin->display_name = 'App Administrator'; // optional
        $admin->description = 'Admin is allowed to manage everything of the app.'; // optional
        $admin->save();

        $employee = new Role();
        $employee->name = 'employee';
        $employee->display_name = 'Employee'; // optional
        $employee->description = 'Employee can see tasks and projects assigned to him.'; // optional
        $employee->save(); 

        $admin->perms()->sync([]);
        $admin->attachPermissions($allPermissions);

        $employee->perms()->sync([]);
        $employee->attachPermissions($allPermissions);  

        DB::table('users')->truncate();
        DB::table('employee_details')->truncate(); 

        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE employee_details AUTO_INCREMENT = 1'); 

        // $count = env('SEED_RECORD_COUNT', 30);

        $faker = \Faker\Factory::create();

        $user = new User();
        $user->name = $faker->name;
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('123456');
        $user->save();

        $employee = new EmployeeDetails();
        $employee->user_id = $user->id;
        $employee->employee_id = 'emp-' . $user->id;
        $employee->address = $faker->address; 
        $employee->joining_date = now()->subMonths(9)->toDateTimeString();
        $employee->save(); 

        $adminRole = Role::where('name', 'admin')->first();
        $employeeRole = Role::where('name', 'employee')->first();
        $clientRole = Role::where('name', 'client')->first();

        $user->roles()->attach($adminRole->id); // id only
        $user->roles()->attach($employeeRole->id); // id only 

    }

    // public function getDepartment()
    // {
    //     return Team::inRandomOrder()
    //         ->get()->pluck('id')->toArray();
    // }

    // public function getDesignation()
    // {
    //     return \App\Models\Designation::inRandomOrder()
    //         ->get()->pluck('id')->toArray();
    // }

 
}
