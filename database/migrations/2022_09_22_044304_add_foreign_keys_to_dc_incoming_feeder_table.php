<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDcIncomingFeederTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dc_incoming_feeder', function (Blueprint $table) {
            $table->foreign(['APJ_ID'], 'FK_APJ_ID_INC_FDR')->references(['APJ_ID'])->on('dc_apj');
            // $table->foreign(['INCOMING_NAME'], 'FK_TRF_INC_FDR')->references(['TRAFO_ID'])->on('dc_trafo');
            $table->foreign(['GARDU_INDUK_ID'], 'FK_GI_ID_INCOMING_FEE')->references(['GARDU_INDUK_ID'])->on('dc_gardu_induk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dc_incoming_feeder', function (Blueprint $table) {
            $table->dropForeign('FK_APJ_ID_INC_FDR');
            $table->dropForeign('FK_TRF_INC_FDR');
            $table->dropForeign('FK_GI_ID_INCOMING_FEE');
        });
    }
}
