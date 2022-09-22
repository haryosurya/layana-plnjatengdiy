<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcJenisKeadaanPmtTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_jenis_keadaan_pmt', function (Blueprint $table) {
            $table->integer('JENIS_KEADAAN_PMT_ID', true);
            $table->string('JENIS_KEADAAN_PMT', 25)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_jenis_keadaan_pmt');
    }
}
