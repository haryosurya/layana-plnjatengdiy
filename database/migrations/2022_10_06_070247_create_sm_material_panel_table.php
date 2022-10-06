<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmMaterialPanelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sm_material_panel', function (Blueprint $table) {
            $table->integer('MATERIAL_PANEL_ID', true);
            $table->smallInteger('GARDU_INDUK_ID')->nullable();
            $table->string('GEDUNG', 3)->nullable();
            $table->smallInteger('MATERIAL_ID')->nullable();
            $table->smallInteger('QTY')->nullable();
            $table->string('MATERIAL_SN', 50)->nullable();
            $table->string('MATERIAL_IP_ADDRESS', 20)->nullable();
            $table->date('TANGGAL_PEMASANGAN')->nullable();
            $table->text('KETERANGAN')->nullable();
            $table->string('USER_UPDATE', 50)->nullable();
            $table->dateTime('LAST_UPDATE')->nullable();
            $table->smallInteger('SSD_1')->nullable()->comment('Status Smoke Detector 1');
            $table->dateTime('SSD_1_TIME')->nullable()->comment('Update Status Smoke Detector 1');
            $table->smallInteger('SSD_2')->nullable()->comment('Status Smoke Detector 2');
            $table->dateTime('SSD_2_TIME')->nullable()->comment('Update Status Smoke Detector 2');
            $table->smallInteger('SSD_3')->nullable()->comment('Status Smoke Detector 3');
            $table->dateTime('SSD_3_TIME')->nullable()->comment('Update Status Smoke Detector 3');
            $table->smallInteger('SSD_4')->nullable()->comment('Status Smoke Detector 4');
            $table->dateTime('SSD_4_TIME')->nullable()->comment('Update Status Smoke Detector 4');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sm_material_panel');
    }
}
