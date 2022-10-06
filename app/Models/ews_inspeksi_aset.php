<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_inspeksi_aset
 * @property int $id_outgoing
 * @property int $id_user
 * @property int $id_gardu_induk
 * @property string $tgl_entry
 * @property string $tgl_inspeksi
 * @property string $body_cubicle
 * @property string $lv
 * @property string $cb
 * @property string $busbar
 * @property string $power_cable
 * @property string $pmt_cb
 * @property string $announ
 * @property string $ind_lamp
 * @property string $ind_volt
 * @property string $ac220
 * @property string $dc110
 * @property string $desis
 * @property string $dengung
 * @property string $ngeter
 * @property string $flash
 * @property string $sangit
 * @property string $amis
 * @property string $feeder
 * @property string $kubikel
 * @property string $pmt
 * @property string $grounding
 * @property string $sangit2
 * @property string $slr
 * @property string $sar
 * @property string $body_alat
 * @property string $wiring
 * @property string $w_prot
 * @property string $w_meter
 * @property string $w_acc
 * @property string $relay_ready
 * @property string $relay_display
 * @property float $relay_mr
 * @property float $relay_ms
 * @property float $relay_mt
 * @property string $pm_display
 * @property float $pm_mr
 * @property float $pm_ms
 * @property float $pm_mt
 * @property string $kwh_meter
 * @property string $panel_rtu
 * @property string $door
 * @property string $fan
 * @property string $lampu_panel
 * @property string $grounding_rtu
 * @property string $temp_panel
 * @property string $kebersihan
 * @property string $power_on
 * @property string $led_txrx
 * @property string $ethernet
 * @property string $keterangan
 * @property int $id_update
 * @property string $last_update
 */
class ews_inspeksi_aset extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ews_inspeksi_aset';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_inspeksi_aset';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_outgoing', 'id_user', 'id_gardu_induk', 'tgl_entry', 'tgl_inspeksi', 'body_cubicle', 'lv', 'cb', 'busbar', 'power_cable', 'pmt_cb', 'announ', 'ind_lamp', 'ind_volt', 'ac220', 'dc110', 'desis', 'dengung', 'ngeter', 'flash', 'sangit', 'amis', 'feeder', 'kubikel', 'pmt', 'grounding', 'sangit2', 'slr', 'sar', 'body_alat', 'wiring', 'w_prot', 'w_meter', 'w_acc', 'relay_ready', 'relay_display', 'relay_mr', 'relay_ms', 'relay_mt', 'pm_display', 'pm_mr', 'pm_ms', 'pm_mt', 'kwh_meter', 'panel_rtu', 'door', 'fan', 'lampu_panel', 'grounding_rtu', 'temp_panel', 'kebersihan', 'power_on', 'led_txrx', 'ethernet', 'keterangan', 'id_update', 'last_update'];
}
