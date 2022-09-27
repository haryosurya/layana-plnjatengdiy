<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcInspeksiPenyulangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dc_inspeksi_penyulang', function (Blueprint $table) {
            $table->id();
            // penyulang =>OUTGOING_ID =>relation ON DC_CUBICLE
            // tanggal_inspeksi
            // ==inspeksi kubikel==
            // body_kubikel (1,0)
            // LV_compartment (1,0)
            // CB_compartment (1,0)
            // Busbar_compartment (1,0)
            // Kabel_power_compartment (1,0)
            // PMT_cb20kv (1,0) 
            $table->integer('OUTGOING_ID'); 
            $table->date('tgl_inspeksi');
            $table->enum('body_cubicle',[1,0])->default('1');
            $table->enum('lv_compartment',[1,0])->default('1');
            $table->enum('cb_compartment',[1,0])->default('1');
            $table->enum('busbar_compartment',[1,0])->default('1');
            $table->enum('kabel_power_compartment',[1,0])->default('1');
            $table->enum('pmt_cb20kv',[1,0])->default('1');
            // ==ASSESORIES KUBIKEL==
            // annoinciater (1,0)
            // lampu_indikasi (1,0)
            // indikasi_tegangan_cvd (1,0)
            // supply_ac-220_v (1,0)
            // supply_dc_110_v (1,0)
            $table->enum('annoinciater',[1,0])->default('1');
            $table->enum('lampu_indikasi',[1,0])->default('1');
            $table->enum('indikasi_tegangan_cvd',[1,0])->default('1');
            $table->enum('supply_ac220v',[1,0])->default('1');
            $table->enum('supply_dc110v',[1,0])->default('1');
            // ==TANDA KELAINAN KUBIKEL 20KV==
            // suara_desis (1,0)
            // suara_dengung (1,0)
            // suara_ngeter (1,0)
            // flash_over (1,0)
            // bau_sangit (1,0)
            // bau_amis (1,0)
            $table->enum('suara_desis',[1,0])->default('0');
            $table->enum('suara_dengung',[1,0])->default('0');
            $table->enum('suara_ngeter',[1,0])->default('0');
            $table->enum('flash_over',[1,0])->default('0');
            $table->enum('bau_sangit',[1,0])->default('0');
            $table->enum('bau_amis',[1,0])->default('0');
            // ==STATUS KUBIKEL 20KV==
            // feeder_st_cb20kv (1,0)
            // kubikel_st_cb20kv (1,0)
            // pmt_st_cb20kv (1,0)
            // grounding_st_cb20kv (1,0)
            // bau_sangit_st_cb20kv (1,0)
            // switch_local_remote_st_cb20kv (1,0)
            // switch_auto_reclose_st_cb20kv (1,0)
            $table->enum('feeder_st_cb20kv',[1,0])->default('1');
            $table->enum('kubikel_st_cb20kv',[1,0])->default('1');
            $table->enum('pmt_st_cb20kv',[1,0])->default('1');
            $table->enum('grounding_st_cb20kv',[1,0])->default('1');
            $table->enum('bau_sangit_st_cb20kv',[1,0])->default('1');
            $table->enum('switch_local_remote_st_cb20kv',[1,0])->default('1');
            $table->enum('switch_auto_reclose_st_cb20kv',[1,0])->default('1');
            // ==PERTAHANAN PROTEKSI dan Metering==
            // body_peralatan (1,0)
            // kabel_wiring (1,0)
            // kondisi_wiring_proteksi (1,0)
            // kondisi_wiring_metering (1,0)
            // kondisi_wiring_aksesories (1,0)
            $table->enum('body_peralatan',[1,0])->default('1');
            $table->enum('kabel_wiring',[1,0])->default('1');
            $table->enum('kondisi_wiring_proteksi',[1,0])->default('1');
            $table->enum('kondisi_wiring_metering',[1,0])->default('1');
            $table->enum('kondisi_wiring_aksesories',[1,0])->default('1');
            
            // ==KONDISI AKTUAL PROTEKSI dan METERING==
            // lampu_indikasi_rele_ready (1,0)
            // display_rele_proteksi (1,0)
            // display_rele_proteksi_phasa_s (integer)
            // display_rele_proteksi_phasa_r (integer)
            // display_rele_proteksi_phasa_t (integer)
            // penunjukan_power_meter (1,0)
            // penunjukan_power_meter_phasa_s (integer)
            // penunjukan_power_meter_phasa_r (integer)
            // penunjukan_power_meter_phasa_t (integer)
            // kwh_meter_kubel (1,0)
            $table->enum('lampu_indikasi_rele_ready',[1,0])->default('1');
            $table->enum('display_rele_proteksi',[1,0])->default('1');
            $table->string('display_rele_proteksi_phasa_s');
            $table->string('display_rele_proteksi_phasa_r');
            $table->string('display_rele_proteksi_phasa_t');
            $table->enum('penunjukan_power_meter',[1,0])->default('1');
            $table->string('penunjukan_power_meter_phasa_s');
            $table->string('penunjukan_power_meter_phasa_r');
            $table->string('penunjukan_power_meter_phasa_t');
            $table->enum('kwh_meter_kubel',[1,0])->default('1');
            // ===============INSPEKSI PERALARAN SCADA============
            // ==PANEL RTU==
            // kebersihan_panel_rtu (1,0)
            // door_close (1,0)
            // exhaust_fan (1,0)
            // lampu_panel (1,0)
            // grounding (1,0)
            // display_temperature_panel (1,0)
            $table->enum('kebersihan_panel_rtu',[1,0])->default('1');
            $table->enum('door_close',[1,0])->default('1');
            $table->enum('exhaust_fan',[1,0])->default('1');
            $table->enum('lampu_panel',[1,0])->default('1');
            $table->enum('grounding',[1,0])->default('1');
            $table->enum('display_temperature_panel',[1,0])->default('1');
            // == RTU / CONCENTRATOR == 
            // kebersihan_peralatan (1,0)
            // indikasi_power_on (1,0)
            // indeksi_led_tx_tx (1,0)
            // kondisi_kabel_ethernet (1,0)
            // foto_pelakasanaan (string) (upload)
            // foto_cek_output_level_pd (string)(upload)
            $table->enum('kebersihan_peralatan',[1,0])->default('1');
            $table->enum('indikasi_power_on',[1,0])->default('1');
            $table->enum('indeksi_led_tx_tx',[1,0])->default('1');
            $table->enum('kondisi_kabel_ethernet',[1,0])->default('1');
            $table->string('foto_pelakasanaan')->nullable();
            $table->string('foto_cek_output_level_pd')->nullable();



            $table->timestamps();
        });
        Schema::table('dc_inspeksi_penyulang', function(Blueprint $table)
        {
            $table->foreign('OUTGOING_ID')->references('OUTGOING_ID')->on('dc_cubicle')->onUpdate('CASCADE')->onDelete('CASCADE'); 
             
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dc_inspeksi_penyulang');
    }
}
