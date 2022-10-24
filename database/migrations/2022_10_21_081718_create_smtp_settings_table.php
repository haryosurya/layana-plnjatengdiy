<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmtpSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mail_driver')->default('smtp');
            $table->string('mail_host')->default('smtp.gmail.com');
            $table->string('mail_port')->default('587');
            $table->string('mail_username')->default('youremail@gmail.com');
            $table->string('mail_password')->default('your password');
            $table->string('mail_from_name')->default('your name');
            $table->string('mail_from_email')->default('from@email.com');
            $table->enum('mail_encryption', ['tls', 'ssl'])->nullable()->default('tls');
            $table->timestamps();
            $table->boolean('verified')->default(false);
            $table->enum('mail_connection', ['sync', 'database'])->default('sync');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smtp_settings');
    }
}
