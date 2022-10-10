<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwsInspeksiPdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ews_inspeksi_pd', function (Blueprint $table) {
            $table->increments('id_inspeksi_pd',true);
            $table->integer('id_outgoing')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_gardu_induk')->nullable();
            $table->date('tgl_entry')->nullable();
            $table->date('tgl_inspeksi')->nullable();
            $table->integer('citicality')->nullable();
            $table->string('level_pd', 20)->nullable();
            $table->text('foto_pelaksanaan')->nullable();
            $table->text('foto_pengukuran')->nullable();
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
        Schema::dropIfExists('ews_inspeksi_pd');
    }
}
