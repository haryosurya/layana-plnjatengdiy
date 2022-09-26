<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('menu_name', 100);
            $table->string('translate_name')->nullable();
            $table->string('route', 100)->nullable();
            $table->string('module')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('setting_menu')->nullable();
            $table->timestamps();
        });
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('main_menu')->nullable();
            $table->longText('default_main_menu')->nullable();
            $table->longText('setting_menu')->nullable();
            $table->longText('default_setting_menu')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
