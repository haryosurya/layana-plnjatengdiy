<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDcTipeGangguanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_tipe_gangguan', function (Blueprint $table) {
            $table->foreign(['INDUK_KODE'], 'FK_INDUK_KODE_TIPE_GGN')->references(['ID_INDUK_KODE_GGN'])->on('dc_tipe_gangguan_kode_induk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_tipe_gangguan', function (Blueprint $table) {
            $table->dropForeign('FK_INDUK_KODE_TIPE_GGN');
        });
    }
}
