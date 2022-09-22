<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisation_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_phone');
            $table->string('logo')->nullable();
            $table->string('login_background')->nullable();
            $table->text('address');
            $table->string('website')->nullable(); 
            $table->string('timezone')->default('Asia/Kolkata');
            $table->string('date_format', 20)->default('d-m-Y');
            $table->string('date_picker_format')->nullable();
            $table->string('moment_format')->nullable();
            $table->string('time_format', 20)->default('h:i a');
            $table->string('locale')->default('en');
            $table->decimal('latitude', 10, 8)->default(26.9124336);
            $table->decimal('longitude', 11, 8)->default(75.7872709);
            $table->enum('leaves_start_from', ['joining_date', 'year_start'])->default('joining_date');
            $table->enum('active_theme', ['default', 'custom'])->default('default');  
            $table->string('google_map_key')->nullable();
            $table->enum('task_self', ['yes', 'no'])->default('yes');
            $table->text('weather_key');
            $table->string('purchase_code', 100)->nullable();
            $table->timestamp('supported_until')->nullable();
            $table->enum('google_recaptcha_status', ['active', 'deactive'])->default('deactive');
            $table->enum('google_recaptcha_v2_status', ['active', 'deactive'])->default('deactive');
            $table->string('google_recaptcha_v2_site_key')->nullable();
            $table->string('google_recaptcha_v2_secret_key')->nullable();
            $table->enum('google_recaptcha_v3_status', ['active', 'deactive'])->default('deactive');
            $table->string('google_recaptcha_v3_site_key')->nullable();
            $table->string('google_recaptcha_v3_secret_key')->nullable();
            $table->boolean('app_debug')->default(false);
            $table->boolean('rounded_theme')->default(1);
            $table->boolean('hide_cron_message')->default(false);
            $table->boolean('system_update')->default(true);
            $table->string('logo_background_color')->default('#171e28');
            $table->integer('before_days')->default(0);
            $table->integer('after_days')->default(0);
            $table->boolean('show_review_modal')->default(true);
            $table->boolean('dashboard_clock')->default(true);
            $table->boolean('ticket_form_google_captcha')->default(false);
            $table->boolean('lead_form_google_captcha')->default(false);
            $table->integer('taskboard_length')->default(10);
            $table->timestamp('last_cron_run')->nullable();
            $table->string('favicon')->nullable();
            $table->enum('auth_theme', ['dark', 'light'])->default('light');
            $table->string('light_logo')->nullable();
            $table->enum('sidebar_logo_style', ['square', 'full'])->default('square');
            $table->enum('session_driver', ['file', 'database'])->default('file');
            $table->boolean('allow_client_signup')->default(0);
            $table->boolean('admin_client_signup_approval')->default(0);
            $table->text('allowed_file_types')->nullable();
            $table->enum('google_calendar_status', ['active', 'inactive'])->default('inactive');
            $table->text('google_client_id')->nullable();
            $table->text('google_client_secret')->nullable();
            $table->enum('google_calendar_verification_status', ['verified', 'non_verified'])->default('non_verified');
            $table->string('google_id')->nullable();
            $table->string('name')->nullable();
            $table->text('token')->nullable();
            $table->integer('allowed_file_size')->default(10); 
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
        Schema::dropIfExists('organisation_settings');
    }
}
