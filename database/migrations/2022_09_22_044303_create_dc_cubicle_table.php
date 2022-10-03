<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcCubicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_cubicle', function (Blueprint $table) {
            $table->integer('OUTGOING_ID', true);
            $table->integer('APJ_ID')->nullable()->index('FK_APJ_ID_CUBICLE');
            $table->integer('SUPPLY_APJ')->nullable()->index('FK_SUPPLY_APJ_CUBICLE');
            $table->integer('INCOMING_ID')->default(0);
            $table->string('CUBICLE_NAME', 20)->default('');
            $table->integer('CUBICLE_TYPE')->default(6);
            $table->integer('OPERATION_TYPE')->default(1);
            $table->string('KETERANGAN', 100)->nullable();
            $table->string('RELAY', 20)->nullable();
            $table->string('MERK_RELAY', 5)->nullable();
            $table->string('NO_SERI_RELAY', 20)->nullable();
            $table->string('METER', 15)->nullable();
            $table->string('MERK_METER', 5)->nullable();
            $table->string('NO_SERI_METER', 20)->nullable();
            $table->string('MERK_IO', 5)->nullable();
            $table->string('NO_SERI_IO', 20)->nullable();
            $table->string('MERK_INTERFACE', 5)->nullable();
            $table->string('NO_SERI_INTERFACE', 20)->nullable();
            $table->string('MERK_PS', 5)->nullable();
            $table->string('SETTING_CT', 10)->nullable();
            $table->string('SETTING_PT', 10)->nullable();
            $table->string('MERK', 15)->nullable();
            $table->string('MERK_CUBICLE', 5)->nullable();
            $table->string('NO_SERI', 30)->nullable();
            $table->string('DIMENSI', 20)->nullable();
            $table->string('RNR', 5)->nullable();
            $table->string('TAHUN_OPERASI', 5)->nullable();
            $table->smallInteger('OCR_TD')->nullable();
            $table->string('OCR_TMS_TD', 10)->nullable();
            $table->string('OCR_CURVA', 10)->nullable();
            $table->string('OCR_INST', 10)->nullable();
            $table->string('OCR_T_INST', 10)->nullable();
            $table->smallInteger('GFR_TD')->nullable();
            $table->string('GFR_TMS_TD', 10)->nullable();
            $table->string('GFR_CURVA', 10)->nullable();
            $table->string('GFR_INST', 10)->nullable();
            $table->string('GFR_T_INST', 10)->nullable();
            $table->smallInteger('UPJ_ID')->nullable();
            $table->smallInteger('UPJ_ID2')->nullable();
            $table->smallInteger('OCR_HS1')->nullable();
            $table->string('OCR_T_HS1', 10)->nullable();
            $table->smallInteger('OCR_HS2')->nullable();
            $table->string('OCR_T_HS2', 10)->nullable();
            $table->smallInteger('GFR_HS1')->nullable();
            $table->string('GFR_T_HS1', 10)->nullable();
            $table->smallInteger('GFR_HS2')->nullable();
            $table->string('GFR_T_HS2', 10)->nullable();
            $table->string('USER_UPDATE', 50)->nullable();
            $table->dateTime('LAST_UPDATE')->nullable();
            $table->decimal('WARNING_LIMIT')->nullable();
            $table->decimal('IA')->nullable();
            $table->dateTime('IA_TIME')->nullable();
            $table->decimal('IB')->nullable();
            $table->dateTime('IB_TIME')->nullable();
            $table->decimal('IC')->nullable();
            $table->dateTime('IC_TIME')->nullable();
            $table->decimal('IN')->nullable();
            $table->dateTime('IN_TIME')->nullable();
            $table->decimal('IA2')->nullable();
            $table->dateTime('IA2_TIME')->nullable();
            $table->decimal('IB2')->nullable();
            $table->dateTime('IB2_TIME')->nullable();
            $table->decimal('IC2')->nullable();
            $table->dateTime('IC2_TIME')->nullable();
            $table->decimal('IN2')->nullable();
            $table->dateTime('IN2_TIME')->nullable();
            $table->decimal('VLL')->nullable();
            $table->dateTime('VLL_TIME')->nullable();
            $table->decimal('KW', 10)->nullable();
            $table->dateTime('KW_TIME')->nullable();
            $table->decimal('PF', 6)->nullable();
            $table->dateTime('PF_TIME')->nullable();
            $table->decimal('IFA')->nullable();
            $table->dateTime('IFA_TIME')->nullable();
            $table->decimal('IFB')->nullable();
            $table->dateTime('IFB_TIME')->nullable();
            $table->decimal('IFC')->nullable();
            $table->dateTime('IFC_TIME')->nullable();
            $table->decimal('IFN')->nullable();
            $table->dateTime('IFN_TIME')->nullable();
            $table->smallInteger('SCB')->nullable();
            $table->smallInteger('SCB_INV')->nullable();
            $table->dateTime('SCB_TIME')->nullable();
            $table->smallInteger('SLR')->nullable();
            $table->smallInteger('SLR_INV')->nullable();
            $table->dateTime('SLR_TIME')->nullable();
            $table->smallInteger('SRNR')->nullable();
            $table->smallInteger('SRNR_INV')->nullable();
            $table->dateTime('SRNR_TIME')->nullable();
            $table->smallInteger('SESW')->nullable();
            $table->smallInteger('SESW_INV')->nullable();
            $table->dateTime('SESW_TIME')->nullable();
            $table->smallInteger('SCBP')->nullable();
            $table->dateTime('SCBP_TIME')->nullable();
            $table->smallInteger('SCBP_INV')->nullable();
            $table->decimal('TEMP_A')->nullable();
            $table->dateTime('TEMP_A_TIME')->nullable();
            $table->decimal('TEMP_B')->nullable();
            $table->dateTime('TEMP_B_TIME')->nullable();
            $table->decimal('TEMP_C')->nullable();
            $table->dateTime('TEMP_C_TIME')->nullable();
            $table->decimal('HUMIDITY')->nullable();
            $table->dateTime('HUMIDITY_TIME')->nullable();
            $table->decimal('LIMIT_UPPER_TEMP')->nullable();
            $table->decimal('LIMIT_UPPER_HUMIDITY')->nullable();
            $table->decimal('PD_CRITICAL')->nullable();
            $table->string('PD_LEVEL', 10)->nullable();
            $table->dateTime('PD_TIME')->nullable();

            $table->unique(['INCOMING_ID', 'CUBICLE_NAME'], 'IDX_CUB_INC_UNIQUE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_cubicle');
    }
}
