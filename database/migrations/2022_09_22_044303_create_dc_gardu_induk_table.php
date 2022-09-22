<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcGarduIndukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_gardu_induk', function (Blueprint $table) {
            $table->integer('GARDU_INDUK_ID', true);
            $table->integer('APJ_ID')->nullable()->index('FK_APJ_ID_GARDU_INDUK');
            $table->string('GARDU_INDUK_NAMA', 25)->nullable();
            $table->string('GARDU_INDUK_KODE', 3)->nullable();
            $table->integer('GARDU_INDUK_RTU_ID')->nullable();
            $table->string('GARDU_INDUK_ALIAS', 25)->nullable();
            $table->string('GARDU_INDUK_ALIAS_ROPO', 25)->nullable();
            $table->string('GARDU_INDUK_ALAMAT', 500)->nullable();
            $table->smallInteger('UPT_ID')->nullable();
            $table->string('NAMA_ALIAS_GARDU_INDUK', 20)->nullable();
            $table->smallInteger('PEMELIHARAAN_GI')->nullable();
            $table->smallInteger('BATAS_TEGANGAN_BAWAH')->nullable();
            $table->smallInteger('BATAS_TEGANGAN_ATAS')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_gardu_induk');
    }
}
