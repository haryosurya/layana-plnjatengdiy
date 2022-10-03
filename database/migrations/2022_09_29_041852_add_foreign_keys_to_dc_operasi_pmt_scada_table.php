<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDcOperasiPmtScadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0'); 

        Schema::table('dc_operasi_pmt_scada', function (Blueprint $table) {
            $table->foreign(['JARAK_GANGGUAN'], 'FK_JARAK_GGN_OPS_PMT_SCADA')->references(['ID_JARAK_GANGGUAN'])->on('dc_speedjardist_jarakgangguan');
            $table->foreign(['UPJ_ID'], 'FK_UPJ_ID_OPS_PMT_SCADA')->references(['UPJ_ID'])->on('dc_upj');
            $table->foreign(['APJ_ID'], 'FK_APJ_ID_OPS_PMT_SCADA')->references(['APJ_ID'])->on('dc_apj');
            $table->foreign(['ID_INDIKASI_GANGGUAN'], 'FK_INDIKASI_GGN_OPS_PMT_SCADA')->references(['ID_INDIKASI_GANGGUAN'])->on('dc_indikasi_gangguan');
            $table->foreign(['ID_TIPE_GANGGUAN'], 'FK_TIPE_INDIKASI_OPS_PMT_SCADA')->references(['ID_TIPE_GANGGUAN'])->on('dc_tipe_gangguan');
            $table->foreign(['CUACA'], 'FK_CUACA_OPS_PMT_SCADA')->references(['ID_CUACA'])->on('dc_speedjardist_cuaca');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1'); 

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_operasi_pmt_scada', function (Blueprint $table) {
            $table->dropForeign('FK_JARAK_GGN_OPS_PMT_SCADA');
            $table->dropForeign('FK_UPJ_ID_OPS_PMT_SCADA');
            $table->dropForeign('FK_APJ_ID_OPS_PMT_SCADA');
            $table->dropForeign('FK_INDIKASI_GGN_OPS_PMT_SCADA');
            $table->dropForeign('FK_TIPE_INDIKASI_OPS_PMT_SCADA');
            $table->dropForeign('FK_CUACA_OPS_PMT_SCADA');
        });
    }
}
