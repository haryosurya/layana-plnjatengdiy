<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwsHistoryMeterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ews_history_meter', function (Blueprint $table) {
            $table->increments('history_ews_id');
            $table->integer('outgoing_id')->nullable()->comment('FK dari table dc_cubicle');
            $table->decimal('temp_A', 10)->nullable();
            $table->dateTime('temp_A_time')->nullable();
            $table->decimal('temp_B', 10)->nullable();
            $table->dateTime('temp_B_time')->nullable();
            $table->decimal('temp_C', 10)->nullable();
            $table->dateTime('temp_C_time')->nullable();
            $table->decimal('humid', 10)->nullable();
            $table->dateTime('humid_time')->nullable();
        });
        Schema::table('ews_history_meter', function(Blueprint $table)
        {
            $table->foreign('outgoing_id')->references('OUTGOING_ID')->on('dc_cubicle')->onUpdate('CASCADE')->onDelete('CASCADE'); 
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ews_history_meter');
    }
}
