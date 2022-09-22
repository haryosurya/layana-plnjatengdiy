<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcApjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_apj', function (Blueprint $table) {
            $table->integer('APJ_ID', true);
            $table->string('APJ_NAMA', 25)->nullable();
            $table->string('APJ_ALIAS', 15)->nullable();
            $table->string('APJ_DCC', 5)->nullable();
            $table->string('APJ_ALAMAT', 50)->nullable();
            $table->integer('APJ_KODE')->nullable();
            $table->string('TELEGRAM_ID', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_apj');
    }
}
