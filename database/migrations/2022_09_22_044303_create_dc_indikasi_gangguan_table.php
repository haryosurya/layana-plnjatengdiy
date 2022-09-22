<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcIndikasiGangguanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_indikasi_gangguan', function (Blueprint $table) {
            $table->integer('ID_INDIKASI_GANGGUAN', true);
            $table->string('NAMA_INDIKASI_GANGGUAN', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_indikasi_gangguan');
    }
}
