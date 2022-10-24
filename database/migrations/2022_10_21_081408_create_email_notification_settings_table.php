<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_notification_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('setting_name');
            $table->enum('send_email', ['yes', 'no'])->default('no'); 
            $table->enum('send_push', ['yes', 'no'])->default('no');
            $table->timestamps();
            $table->string('slug')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_notification_settings');
    }
}
