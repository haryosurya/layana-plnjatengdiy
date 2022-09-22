<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
            $table->unsignedInteger('added_by')->nullable()->index('designations_added_by_foreign');
            $table->unsignedInteger('last_updated_by')->nullable()->index('designations_last_updated_by_foreign');
        });
        Schema::table('designations', function (Blueprint $table) {
            $table->foreign(['added_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['last_updated_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->string('team_name');
            $table->timestamps();
            $table->unsignedInteger('added_by')->nullable()->index('teams_added_by_foreign');
            $table->unsignedInteger('last_updated_by')->nullable()->index('teams_last_updated_by_foreign');
        });
        
        Schema::table('teams', function (Blueprint $table) {
            $table->foreign(['added_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['last_updated_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
        Schema::create('employee_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('employee_details_user_id_foreign');
            $table->string('employee_id')->nullable()->unique();
            $table->text('address')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();  
            $table->unsignedInteger('department_id')->nullable()->index('employee_details_department_id_foreign');
            $table->unsignedBigInteger('designation_id')->nullable()->index('employee_details_designation_id_foreign');
            $table->unsignedInteger('added_by')->nullable()->index('employee_details_added_by_foreign');
            $table->unsignedInteger('last_updated_by')->nullable()->index('employee_details_last_updated_by_foreign'); 
            $table->timestamp('joining_date')->useCurrent();
            $table->date('last_date')->nullable();
            $table->timestamps();
        });
        
        Schema::table('employee_details', function (Blueprint $table) {
            $table->foreign(['last_updated_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['added_by'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreign(['designation_id'])->references(['id'])->on('designations')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['user_id'])->references(['id'])->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign(['department_id'])->references(['id'])->on('teams')->onUpdate('CASCADE')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Schema::dropIfExists('designations');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('employee_details');
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
