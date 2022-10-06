<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwsInspeksiAsetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ews_inspeksi_aset', function (Blueprint $table) {
            $table->integer('id_inspeksi_aset')->primary();
            $table->integer('id_outgoing')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_gardu_induk')->nullable();
            $table->string('tgl_entry', 20)->nullable();
            $table->string('tgl_inspeksi', 20)->nullable();
            $table->string('body_cubicle', 20)->nullable();
            $table->string('lv', 20)->nullable();
            $table->string('cb', 20)->nullable();
            $table->string('busbar', 20)->nullable();
            $table->string('power_cable', 20)->nullable();
            $table->string('pmt_cb', 20)->nullable();
            $table->string('announ', 20)->nullable();
            $table->string('ind_lamp', 20)->nullable();
            $table->string('ind_volt', 20)->nullable();
            $table->string('ac220', 20)->nullable();
            $table->string('dc110', 20)->nullable();
            $table->string('desis', 20)->nullable();
            $table->string('dengung', 20)->nullable();
            $table->string('ngeter', 20)->nullable();
            $table->string('flash', 20)->nullable();
            $table->string('sangit', 20)->nullable();
            $table->string('amis', 20)->nullable();
            $table->string('feeder', 20)->nullable();
            $table->string('kubikel', 20)->nullable();
            $table->string('pmt', 20)->nullable();
            $table->string('grounding', 20)->nullable();
            $table->string('sangit2', 20)->nullable();
            $table->string('slr', 20)->nullable();
            $table->string('sar', 20)->nullable();
            $table->string('body_alat', 20)->nullable();
            $table->string('wiring', 20)->nullable();
            $table->string('w_prot', 20)->nullable();
            $table->string('w_meter', 20)->nullable();
            $table->string('w_acc', 20)->nullable();
            $table->string('relay_ready', 20)->nullable();
            $table->string('relay_display', 20)->nullable();
            $table->float('relay_mr', 10)->nullable();
            $table->float('relay_ms', 10)->nullable();
            $table->float('relay_mt', 10)->nullable();
            $table->string('pm_display', 20)->nullable();
            $table->float('pm_mr', 10)->nullable();
            $table->float('pm_ms', 10)->nullable();
            $table->float('pm_mt', 10)->nullable();
            $table->string('kwh_meter', 20)->nullable();
            $table->string('panel_rtu', 20)->nullable();
            $table->string('door', 20)->nullable();
            $table->string('fan', 20)->nullable();
            $table->string('lampu_panel', 20)->nullable();
            $table->string('grounding_rtu', 20)->nullable();
            $table->string('temp_panel', 20)->nullable();
            $table->string('kebersihan', 20)->nullable();
            $table->string('power_on', 20)->nullable();
            $table->string('led_txrx', 20)->nullable();
            $table->string('ethernet', 20)->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('id_update')->nullable();
            $table->dateTime('last_update')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ews_inspeksi_aset');
    }
}
