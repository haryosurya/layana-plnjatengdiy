<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $MATERIAL_PANEL_ID
 * @property integer $GARDU_INDUK_ID
 * @property string $GEDUNG
 * @property integer $MATERIAL_ID
 * @property integer $QTY
 * @property string $MATERIAL_SN
 * @property string $MATERIAL_IP_ADDRESS
 * @property string $TANGGAL_PEMASANGAN
 * @property string $KETERANGAN
 * @property string $USER_UPDATE
 * @property string $LAST_UPDATE
 * @property integer $SSD_1
 * @property string $SSD_1_TIME
 * @property integer $SSD_2
 * @property string $SSD_2_TIME
 * @property integer $SSD_3
 * @property string $SSD_3_TIME
 * @property integer $SSD_4
 * @property string $SSD_4_TIME
 */
class sm_material_panel extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sm_material_panel';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'MATERIAL_PANEL_ID';

    /**
     * @var array
     */
    protected $fillable = ['GARDU_INDUK_ID', 'GEDUNG', 'MATERIAL_ID', 'QTY', 'MATERIAL_SN', 'MATERIAL_IP_ADDRESS', 'TANGGAL_PEMASANGAN', 'KETERANGAN', 'USER_UPDATE', 'LAST_UPDATE', 'SSD_1', 'SSD_1_TIME', 'SSD_2', 'SSD_2_TIME', 'SSD_3', 'SSD_3_TIME', 'SSD_4', 'SSD_4_TIME'];
}
