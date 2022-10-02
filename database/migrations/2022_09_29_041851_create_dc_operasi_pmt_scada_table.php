<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcOperasiPmtScadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_operasi_pmt_scada', function (Blueprint $table) {
            $table->integer('OPERASI_PMT_ID', true);
            $table->timestamp('TGL_OPERASI_PMT')->nullable();
            $table->timestamp('TGL_NORMAL_PMT')->nullable();
            $table->smallInteger('JENIS_OPERASI_PMT')->nullable();
            $table->integer('APJ_ID')->nullable()->index('FK_APJ_ID_OPS_PMT_SCADA');
            $table->string('CAKUPAN_KERJA', 20)->nullable();
            $table->string('DETAIL_LOKASI', 10)->nullable();
            $table->string('ALASAN_OPERASI_PMT', 100)->nullable();
            $table->integer('ID_TIPE_GANGGUAN')->nullable()->index('FK_TIPE_INDIKASI_OPS_PMT_SCADA');
            $table->integer('ID_INDIKASI_GANGGUAN')->nullable()->index('FK_INDIKASI_GGN_OPS_PMT_SCADA');
            $table->float('BEBAN_SBLM_PMT_LEPAS', 5, 0)->nullable();
            $table->float('TEG_SBLM_PMT_LEPAS', 6, 1)->nullable();
            $table->float('BEBAN_SSDH_PMT_LEPAS', 5, 0)->nullable();
            $table->float('TEG_SSDH_PMT_LEPAS', 6, 1)->nullable();
            $table->float('ARUS_GANGGUAN_PH_A', 5, 0)->nullable();
            $table->float('ARUS_GANGGUAN_PH_B', 5, 0)->nullable();
            $table->float('ARUS_GANGGUAN_PH_C', 5, 0)->nullable();
            $table->float('ARUS_GANGGUAN_PH_N', 5, 0)->nullable();
            $table->string('KET_ARUS_GANGGUAN', 500)->nullable();
            $table->integer('ASAL_ID')->nullable();
            $table->integer('CUACA')->nullable()->index('FK_CUACA_OPS_PMT_SCADA');
            $table->string('LOKASI_GANGGUAN', 100)->nullable();
            $table->integer('JARAK_GANGGUAN')->nullable()->index('FK_JARAK_GGN_OPS_PMT_SCADA');
            $table->string('NO_POLE_TIANG', 50)->nullable();
            $table->integer('UPJ_ID')->nullable()->index('FK_UPJ_ID_OPS_PMT_SCADA');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_operasi_pmt_scada');
    }
}
