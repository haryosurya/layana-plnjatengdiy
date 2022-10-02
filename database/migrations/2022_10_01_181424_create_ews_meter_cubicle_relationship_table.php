<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwsMeterCubicleRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('ews_history_meter', function (Blueprint $table) { 
        // $table->foreign('OUTGOING_ID')->references('OUTGOING_ID')->on('dc_cubicle')->onUpdate('CASCADE')->onDelete('CASCADE'); 
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    { 
    }
}
