<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDcGarduIndukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_gardu_induk', function (Blueprint $table) {
            $table->foreign(['APJ_ID'], 'FK_APJ_ID_GARDU_INDUK')->references(['APJ_ID'])->on('dc_apj');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_gardu_induk', function (Blueprint $table) {
            $table->dropForeign('FK_APJ_ID_GARDU_INDUK');
        });
    }
}
