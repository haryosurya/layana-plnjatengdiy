<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwsFreqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ews_freq', function (Blueprint $table) {
            $table->increments('freq_id')->primary();
            $table->integer('outgoing_id')->nullable();
            $table->decimal('freq', 10)->nullable();
            $table->dateTime('freq_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ews_freq');
    }
}
