<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleSetting;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\PermissionType;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\UserPermission;
use DB;
use Illuminate\Database\Seeder;

class ModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::statement('SET FOREIGN_KEY_CHECKS=0'); 
        
        DB::table('permission_role')->truncate();
        DB::table('module_settings')->truncate();
        DB::table('modules')->truncate();
        DB::table('user_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('permission_types')->truncate();

        Module::insert([ 
            ['module_name' => 'settings', 'description' => 'User can manage settings'],
            ['module_name' => 'employees', 'description' => 'Manage Employee'], 
        ]);
        ModuleSetting::insert([
            ['module_name' => 'settings', 'status' => 'active', 'type' => 'admin'],
            ['module_name' => 'employees', 'status' => 'active', 'type' => 'admin'],  
            ['module_name' => 'employees', 'status' => 'active', 'type' => 'employee'], 
        ]);
        Permission::insert([
            ['name' => 'add_employees', 'display_name' => 'Add Employees', 'module_id' => 2, 'is_custom' => 0,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'view_employees', 'display_name' => 'View Employees', 'module_id' => 2, 'is_custom' => 0,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'edit_employees', 'display_name' => 'Edit Employees', 'module_id' => 2, 'is_custom' => 0,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'delete_employees', 'display_name' => 'Delete Employees', 'module_id' => 2, 'is_custom' => 0,'allowed_permissions' => '{"all":4, "none":5}'], 
            ['name' => 'manage_role_permission_setting', 'display_name' => 'Manage Role Permission Setting', 'module_id'  => 1, 'is_custom' => 1,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'manage_app_setting', 'display_name' => 'Manage App Settings', 'module_id' => 1, 'is_custom' => 1,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'manage_theme_setting', 'display_name' => 'Manage Theme Settings', 'module_id' => 1, 'is_custom' => 1,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'manage_storage_setting', 'display_name' => 'Manage Storage Settings', 'module_id' => 1, 'is_custom' => 1,'allowed_permissions' => '{"all":4, "none":5}'],
            ['name' => 'manage_module_setting', 'display_name' => 'Manage Module Setting', 'module_id'  => 1, 'is_custom' => 1,'allowed_permissions' => '{"all":4, "none":5}'], 

        ]);

        $types = ['added', 'owned', 'both', 'all', 'none'];

        foreach($types as $type) {
            PermissionType::create(['name' => $type]);
        }

        $adminRole = Role::where('name', 'admin')->first();

        if ($adminRole) {

            $adminCurrentPermission = PermissionRole::where('role_id', $adminRole->id)->get()->pluck('permission_id');
            $adminMissingPermissions = Permission::whereNotIn('id', $adminCurrentPermission)->get();
            $allTypePermisison = PermissionType::where('name', 'all')->first();
            $admins = RoleUser::where('role_id', '1')->get();
            $allPermissions = Permission::get();

            // Adding all permissions to admin role user
            foreach ($admins as $item) {

                foreach ($allPermissions as $allPermission) {
                    UserPermission::firstOrCreate(
                        [
                            'user_id' => $item->user_id,
                            'permission_id' => $allPermission->id,
                            'permission_type_id' => $allTypePermisison->id
                        ]
                    );
                }
            } 
            // Adding missing permissions to permission_role table 
            foreach ($adminMissingPermissions as $adminMissingPermission) {
                $newPermission = new PermissionRole();
                $newPermission->permission_id = $adminMissingPermission->id;
                $newPermission->role_id = $adminRole->id;
                $newPermission->permission_type_id = $allTypePermisison->id;
                $newPermission->save();
            }

        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1'); 

    }
}
