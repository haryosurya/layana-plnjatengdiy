<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $GEDUNG_ID
 * @property integer $GARDU_INDUK_ID
 * @property string $GEDUNG_NOMOR
 * @property integer $SSD_1
 * @property string $SSD_1_TIME
 * @property integer $SSD_2
 * @property string $SSD_2_TIME
 * @property integer $SSD_3
 * @property string $SSD_3_TIME
 * @property integer $SSD_4
 * @property string $SSD_4_TIME
 */
class ews_ssd_gedung extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ews_ssd_gedung';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'GEDUNG_ID';
    public $timestamps = false;
    protected $casts = [ 
        'SSD_1_TIME' => 'datetime:Y-m-d H:i:s',
        'SSD_2_TIME' => 'datetime:Y-m-d H:i:s',
        'SSD_3_TIME' => 'datetime:Y-m-d H:i:s',
        'SSD_4_TIME' => 'datetime:Y-m-d H:i:s',
        
        // more ...
    ];
    /**
     * @var array
     */
    protected $fillable = ['GARDU_INDUK_ID', 'GEDUNG_NOMOR', 'SSD_1', 'SSD_1_TIME', 'SSD_2', 'SSD_2_TIME', 'SSD_3', 'SSD_3_TIME', 'SSD_4', 'SSD_4_TIME'];
}
