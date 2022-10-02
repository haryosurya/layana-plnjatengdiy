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
        Schema::create('dc_inspeksi_asset', function (Blueprint $table) {
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
            $table->enum('body_cubicle',['bersih','kotor'])->default('bersih');
            $table->enum('lv_compartment',['bersih','kotor'])->default('bersih');
            $table->enum('cb_compartment',['bersih','kotor'])->default('bersih');
            $table->enum('busbar_compartment',['bersih','kotor'])->default('bersih');
            $table->enum('kabel_power_compartment',['bersih','kotor'])->default('bersih');
            $table->enum('pmt_cb20kv',['bersih','kotor'])->default('bersih');
            // ==ASSESORIES KUBIKEL==
            // annoinciater (1,0)
            // lampu_indikasi (1,0)
            // indikasi_tegangan_cvd (1,0)
            // supply_ac-220_v (1,0)
            // supply_dc_110_v (1,0)
            $table->enum('annoinciater',['baik','tidak baik'])->default('baik');
            $table->enum('lampu_indikasi',['baik','tidak baik'])->default('baik');
            $table->enum('indikasi_tegangan_cvd',['baik','tidak baik'])->default('baik');
            $table->enum('supply_ac220v',['baik','tidak baik'])->default('baik');
            $table->enum('supply_dc110v',['baik','tidak baik'])->default('baik');
            // ==TANDA KELAINAN KUBIKEL 20KV==
            // suara_desis (1,0)
            // suara_dengung (1,0)
            // suara_ngeter (1,0)
            // flash_over (1,0)
            // bau_sangit (1,0)
            // bau_amis (1,0)
            $table->enum('suara_desis',['ada','tidak ada'])->default('ada');
            $table->enum('suara_dengung',['ada','tidak ada'])->default('ada');
            $table->enum('suara_ngeter',['ada','tidak ada'])->default('ada');
            $table->enum('flash_over',['ada','tidak ada'])->default('ada');
            $table->enum('bau_sangit',['ada','tidak ada'])->default('ada');
            $table->enum('bau_amis',['ada','tidak ada'])->default('ada');
            // ==STATUS KUBIKEL 20KV==
            // feeder_st_cb20kv (1,0)
            // kubikel_st_cb20kv (1,0)
            // pmt_st_cb20kv (1,0)
            // grounding_st_cb20kv (1,0)
            // bau_sangit_st_cb20kv (1,0)
            // switch_local_remote_st_cb20kv (1,0)
            // switch_auto_reclose_st_cb20kv (1,0)
            $table->enum('feeder_st_cb20kv',['operasi','cadangan'])->default('operasi');
            $table->enum('kubikel_st_cb20kv',['berbeban','bertegangan'])->default('berbeban');
            $table->enum('pmt_st_cb20kv',['test posisi','service posisi'])->default('test posisi');
            $table->enum('grounding_st_cb20kv',['on','off'])->default('on');
            $table->enum('bau_sangit_st_cb20kv',['ada','tidak ada'])->default('ada');
            $table->enum('switch_local_remote_st_cb20kv',['local','remote'])->default('remote');
            $table->enum('switch_auto_reclose_st_cb20kv',['on','off'])->default('on');
            // ==PERTAHANAN PROTEKSI dan Metering==
            // body_peralatan (1,0)
            // kabel_wiring (1,0)
            // kondisi_wiring_proteksi (1,0)
            // kondisi_wiring_metering (1,0)
            // kondisi_wiring_aksesories (1,0)
            $table->enum('body_peralatan',['bersih','kotor'])->default('bersih');
            $table->enum('kabel_wiring',['bersih','kotor'])->default('bersih');
            $table->enum('kondisi_wiring_proteksi',['kencang','kendor'])->default('kencang');
            $table->enum('kondisi_wiring_metering',['kencang','kendor'])->default('kencang');
            $table->enum('kondisi_wiring_aksesories',['kencang','kendor'])->default('kencang');
            
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
            $table->enum('lampu_indikasi_rele_ready',['ready','alarm'])->default('ready');
            $table->enum('display_rele_proteksi',['normal','blank'])->default('normal');
            $table->string('display_rele_proteksi_phasa_s');
            $table->string('display_rele_proteksi_phasa_r');
            $table->string('display_rele_proteksi_phasa_t');
            $table->enum('penunjukan_power_meter',['normal','blank'])->default('normal');
            $table->string('penunjukan_power_meter_phasa_s');
            $table->string('penunjukan_power_meter_phasa_r');
            $table->string('penunjukan_power_meter_phasa_t');
            $table->enum('kwh_meter_kubel',['normal','blank'])->default('normal');
            // ===============INSPEKSI PERALARAN SCADA============
            // ==PANEL RTU==
            // kebersihan_panel_rtu (1,0)
            // door_close (1,0)
            // exhaust_fan (1,0)
            // lampu_panel (1,0)
            // grounding (1,0)
            // display_temperature_panel (1,0)
            $table->enum('kebersihan_panel_rtu',['bersih','kotor'])->default('bersih');
            $table->enum('door_close',['ada','tidak ada'])->default('ada');
            $table->enum('exhaust_fan',['ada','tidak ada'])->default('ada');
            $table->enum('lampu_panel',['nyala','mati'])->default('nyala');
            $table->enum('grounding',['ada','tidak ada'])->default('ada');
            $table->enum('display_temperature_panel',['baik','tidak baik'])->default('baik');
            // == RTU / CONCENTRATOR == 
            // kebersihan_peralatan (1,0)
            // indikasi_power_on (1,0)
            // indeksi_led_tx_tx (1,0)
            // kondisi_kabel_ethernet (1,0)
            // foto_pelakasanaan (string) (upload)
            // foto_cek_output_level_pd (string)(upload)
            $table->enum('kebersihan_peralatan',['bersih','kotor'])->default('bersih');
            $table->enum('indikasi_power_on',['nyala','mati'])->default('nyala');
            $table->enum('indeksi_led_tx_rx',['kedip bergantian','mati/nyala'])->default('kedip bergantian');
            $table->enum('kondisi_kabel_ethernet',['kencang','kendor'])->default('kencang');
            $table->string('foto_pelaksanaan')->nullable();
            $table->string('foto_asset')->nullable();



            $table->timestamps();
        });
        Schema::table('dc_inspeksi_asset', function(Blueprint $table)
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
        Schema::dropIfExists('dc_inspeksi_asset');
    }
}
