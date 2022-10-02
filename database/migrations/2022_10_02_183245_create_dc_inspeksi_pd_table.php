<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcInspeksiPdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_inspeksi_pd', function (Blueprint $table) {
            $table->id();
            $table->integer('OUTGOING_ID');  
            $table->date('tgl_inspeksi'); 
            $table->string('critical_pd');
            $table->string('ket_pelaksanaan'); 
            $table->enum('level_partial',['good','moderate','bad'])->default('moderate'); 
            $table->string('foto_pelaksanaan')->nullable();
            $table->string('foto_output_level')->nullable();
            $table->timestamps();
        });
        Schema::table('dc_inspeksi_pd', function(Blueprint $table)
        {
            $table->foreign('OUTGOING_ID')->references('OUTGOING_ID')->on('dc_cubicle')->onUpdate('CASCADE')->onDelete('CASCADE'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_inspeksi_pd');
    }
}
