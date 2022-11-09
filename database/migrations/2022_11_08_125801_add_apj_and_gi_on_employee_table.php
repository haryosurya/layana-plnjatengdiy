<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApjAndGiOnEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('employee_details', function (Blueprint $table) {
            
            $table->integer('apj_id')->nullable()->after('employee_id')->index('employee_details_apj_id_foreign');
            $table->integer('gi_id')->nullable()->after('employee_id')->index('employee_details_gi_id_foreign');  

            $table->foreign(['apj_id'])->references(['APJ_ID'])->on('dc_apj')->onUpdate('CASCADE')->onDelete('CASCADE'); 
            $table->foreign(['gi_id'])->references(['GARDU_INDUK_ID'])->on('dc_gardu_induk')->onUpdate('CASCADE')->onDelete('CASCADE'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
