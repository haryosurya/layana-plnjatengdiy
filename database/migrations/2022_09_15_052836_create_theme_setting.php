<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemeSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('panel');
            $table->string('header_color');
            $table->string('sidebar_color');
            $table->string('sidebar_text_color');
            $table->string('link_color')->default('#ffffff');
            $table->longText('user_css')->nullable();
            $table->enum('sidebar_theme', ['dark', 'light'])->default('dark');
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
        Schema::dropIfExists('theme_settings');
    }
}
