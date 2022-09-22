<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcIndikasiGangguanTipeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_indikasi_gangguan_tipe', function (Blueprint $table) {
            $table->integer('ID_TIPE_INDIKASI_GGN', true);
            $table->string('NAMA_TIPE_INDIKASI_GGN', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_indikasi_gangguan_tipe');
    }
}
