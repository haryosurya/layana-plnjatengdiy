<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('password'); 
            $table->string('image')->nullable();
            $table->string('mobile')->nullable();
            $table->enum('gender', ['male', 'female', 'others'])->nullable(); 
            $table->string('locale')->default('id');
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->enum('login', ['enable', 'disable'])->default('enable');
            $table->text('onesignal_player_id')->nullable();
            $table->boolean('email_notifications')->default(true); 
            $table->boolean('dark_theme')->default(0); 
            $table->enum('two_fa_verify_via', ['email', 'google_authenticator', 'both'])->nullable();
            $table->string('two_factor_code')->nullable()->comment('when authenticator is email');
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->boolean('admin_approval')->default(true);
            $table->boolean('permission_sync')->default(true);
            $table->rememberToken();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id')->index('role_user_role_id_foreign');

            $table->primary(['user_id', 'role_id']);
        });
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module_name');
            $table->string('description')->nullable();
            $table->timestamps();
        });
        Schema::create('module_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('module_name');
            $table->enum('status', ['active', 'deactive']);
            $table->enum('type', ['admin', 'employee', 'client'])->default('admin');
            $table->timestamps();
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->unsignedInteger('module_id')->index('permissions_module_id_foreign');
            $table->boolean('is_custom')->default(false);
            $table->text('allowed_permissions')->nullable();
            $table->timestamps();
        });
        Schema::table('permissions', function (Blueprint $table) {
            $table->foreign(['module_id'])->references(['id'])->on('modules')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
        Schema::create('user_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->index('user_permissions_user_id_foreign');
            $table->unsignedInteger('permission_id')->index('user_permissions_permission_id_foreign');
            $table->unsignedBigInteger('permission_type_id')->index('user_permissions_permission_type_id_foreign');
            $table->timestamps();
        });
        Schema::create('permission_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
        Schema::table('user_permissions', function (Blueprint $table) {
            $table->foreign(['permission_id'])->references(['id'])->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['permission_type_id'])->references(['id'])->on('permission_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->unsignedInteger('permission_id');
            $table->unsignedInteger('role_id')->index('permission_role_role_id_foreign');
            $table->unsignedBigInteger('permission_type_id')->default(5)->index('permission_role_permission_type_id_foreign');

            $table->primary(['permission_id', 'role_id']);
        });
        Schema::table('permission_role', function (Blueprint $table) {
            $table->foreign(['permission_id'])->references(['id'])->on('permissions')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['role_id'])->references(['id'])->on('roles')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['permission_type_id'])->references(['id'])->on('permission_types')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('users');
        Schema::dropIfExists('roles');
        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign('role_user_role_id_foreign');
            $table->dropForeign('role_user_user_id_foreign');
        });
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('modules'); 
        Schema::dropIfExists('module_settings');
        Schema::dropIfExists('permissions');
        Schema::table('user_permissions', function (Blueprint $table) {
            $table->dropForeign('user_permissions_permission_id_foreign');
            $table->dropForeign('user_permissions_user_id_foreign');
            $table->dropForeign('user_permissions_permission_type_id_foreign');
        });
        Schema::dropIfExists('user_permissions'); 
        Schema::dropIfExists('permission_types'); 
        Schema::table('permission_role', function (Blueprint $table) {
            $table->dropForeign('permission_role_permission_id_foreign');
            $table->dropForeign('permission_role_role_id_foreign');
            $table->dropForeign('permission_role_permission_type_id_foreign');
        });
        Schema::dropIfExists('permission_role');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
