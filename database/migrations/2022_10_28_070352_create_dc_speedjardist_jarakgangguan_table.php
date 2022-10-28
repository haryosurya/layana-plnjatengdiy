<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcSpeedjardistJarakgangguanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_speedjardist_jarakgangguan', function (Blueprint $table) {
            $table->integer('ID_JARAK_GANGGUAN', true);
            $table->string('NAMA_JARAK_GANGGUAN', 30)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_speedjardist_jarakgangguan');
    }
}
