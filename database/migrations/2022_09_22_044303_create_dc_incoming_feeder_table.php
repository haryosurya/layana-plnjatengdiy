<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcIncomingFeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_incoming_feeder', function (Blueprint $table) {
            $table->integer('INCOMING_ID', true);
            $table->integer('GARDU_INDUK_ID')->nullable()->index('FK_GI_ID_INCOMING_FEE');
            $table->integer('INCOMING_NAME')->nullable()->index('FK_TRF_INC_FDR');
            $table->string('MERK_TRAFO', 25)->nullable();
            $table->string('DAYA_REAKTIF_TRAFO', 8)->nullable();
            $table->string('RASIO_TEGANGAN', 10)->nullable();
            $table->string('NAMA_ALIAS_INCOMING', 30)->nullable();
            $table->float('I_NOMINAL_HV', 10, 0)->nullable();
            $table->float('I_NOMINAL_LV', 10, 0)->nullable();
            $table->string('PABRIKAN_RELAY', 15)->nullable();
            $table->string('METER', 15)->nullable();
            $table->string('PABRIKAN_METER', 15)->nullable();
            $table->boolean('PQM')->nullable();
            $table->string('PQM_SN', 50)->nullable();
            $table->string('PQM_IP_ADDRESS', 20)->nullable();
            $table->string('OCR_TD', 10)->nullable();
            $table->string('OCR_TMS_TD', 10)->nullable();
            $table->string('OCR_CURVA', 10)->nullable();
            $table->string('OCR_INST', 10)->nullable();
            $table->string('OCR_T_INST', 10)->nullable();
            $table->string('GFR_TD', 10)->nullable();
            $table->string('GFR_TMS_TD', 10)->nullable();
            $table->string('GFR_CURVA', 10)->nullable();
            $table->string('GFR_INST', 10)->nullable();
            $table->string('GFR_T_INST', 10)->nullable();
            $table->date('TGL_KESEPAKATAN')->nullable();
            $table->string('TAHUN_ENERGIZE', 5)->nullable();
            $table->string('RELAY', 15)->nullable();
            $table->float('BATAS_BAWAH_TEG', 10)->nullable();
            $table->float('BATAS_ATAS_TEG', 10)->nullable();
            $table->integer('APJ_ID')->nullable()->index('FK_APJ_ID_INC_FDR');
            $table->decimal('TRAFO_KAPASITAS', 4, 1)->nullable();
            $table->decimal('ARUS_HS_3PH', 10, 6)->nullable();
            $table->decimal('ARUS_HS_150', 10, 6)->nullable();
            $table->smallInteger('TEG_PRIMER')->nullable();
            $table->smallInteger('TEG_SEKUNDER')->nullable();
            $table->decimal('TRAFO_IMPEDANSI', 4)->nullable();
            $table->decimal('RL1_FF', 6, 4)->nullable();
            $table->decimal('XL1_FF', 6, 4)->nullable();
            $table->decimal('RL0_FN', 6, 4)->nullable();
            $table->decimal('XL0_FN', 6, 4)->nullable();
            $table->decimal('TRAFO_I_NOMINAL', 10, 4)->nullable();
            $table->decimal('IN', 4, 0)->nullable();
            $table->decimal('PRIMER', 6, 0)->nullable();
            $table->text('KETERANGAN')->nullable();
            $table->string('USER_UPDATE', 50)->nullable();
            $table->dateTime('LAST_UPDATE')->nullable();
            $table->decimal('IA')->nullable();
            $table->decimal('IB')->nullable();
            $table->decimal('IC')->nullable();
            $table->decimal('IG')->nullable();
            $table->decimal('KW')->nullable();
        });
        Schema::table('dc_incoming_feeder', function (Blueprint $table) {
            $table->foreign(['APJ_ID'], 'FK_APJ_ID_INC_FDR')->references(['APJ_ID'])->on('dc_apj');
            // $table->foreign(['INCOMING_NAME'], 'FK_TRF_INC_FDR')->references(['TRAFO_ID'])->on('dc_trafo');
            $table->foreign(['GARDU_INDUK_ID'], 'FK_GI_ID_INCOMING_FEE')->references(['GARDU_INDUK_ID'])->on('dc_gardu_induk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_incoming_feeder');
    }
}
