<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcTipeGangguanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_tipe_gangguan', function (Blueprint $table) {
            $table->integer('ID_TIPE_GANGGUAN', true);
            $table->string('NAMA_TIPE_GANGGUAN', 100)->nullable();
            $table->string('KODE_GANGGUAN', 5)->nullable();
            $table->integer('INDUK_KODE')->nullable()->index('FK_INDUK_KODE_TIPE_GGN');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_tipe_gangguan');
    }
}
