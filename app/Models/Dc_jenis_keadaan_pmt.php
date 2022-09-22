<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $JENIS_KEADAAN_PMT_ID
 * @property string $JENIS_KEADAAN_PMT
 */
class Dc_jenis_keadaan_pmt extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_jenis_keadaan_pmt';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'JENIS_KEADAAN_PMT_ID';

    /**
     * @var array
     */
    protected $fillable = ['JENIS_KEADAAN_PMT'];
}
