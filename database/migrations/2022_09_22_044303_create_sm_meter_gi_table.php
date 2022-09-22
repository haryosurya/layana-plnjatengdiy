<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmMeterGiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_meter_gi', function (Blueprint $table) {
            $table->integer('OUTGOING_METER_ID', true);
            $table->integer('OUTGOING_ID')->nullable();
            $table->decimal('IA')->nullable();
            $table->dateTime('IA_TIME')->nullable();
            $table->decimal('IB')->nullable();
            $table->dateTime('IB_TIME')->nullable();
            $table->decimal('IC')->nullable();
            $table->dateTime('IC_TIME')->nullable();
            $table->decimal('IN')->nullable();
            $table->dateTime('IN_TIME')->nullable();
            $table->decimal('VLL')->nullable();
            $table->dateTime('VLL_TIME')->nullable();
            $table->decimal('KW', 10)->nullable();
            $table->dateTime('KW_TIME')->nullable();
            $table->decimal('PF', 6)->nullable();
            $table->dateTime('PF_TIME')->nullable();
            $table->decimal('IFA')->nullable();
            $table->dateTime('IFA_TIME')->nullable();
            $table->decimal('IFB')->nullable();
            $table->dateTime('IFB_TIME')->nullable();
            $table->decimal('IFC')->nullable();
            $table->dateTime('IFC_TIME')->nullable();
            $table->decimal('IFN')->nullable();
            $table->dateTime('IFN_TIME')->nullable();

            $table->unique(['IA', 'IA_TIME'], 'uniq');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_meter_gi');
    }
}
