<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDcCubicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_cubicle', function (Blueprint $table) {
            $table->foreign(['APJ_ID'], 'FK_APJ_ID_CUBICLE')->references(['APJ_ID'])->on('dc_apj');
            $table->foreign(['SUPPLY_APJ'], 'FK_SUPPLY_APJ_CUBICLE')->references(['APJ_ID'])->on('dc_apj');
            $table->foreign(['INCOMING_ID'], 'FK_INCOMING_ID_CUBICLE')->references(['INCOMING_ID'])->on('dc_incoming_feeder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_cubicle', function (Blueprint $table) {
            $table->dropForeign('FK_APJ_ID_CUBICLE');
            $table->dropForeign('FK_SUPPLY_APJ_CUBICLE');
            $table->dropForeign('FK_INCOMING_ID_CUBICLE');
        });
    }
}
