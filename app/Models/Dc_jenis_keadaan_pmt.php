<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_jenis_keadaan_pmt
 *
 * @property int $JENIS_KEADAAN_PMT_ID
 * @property string $JENIS_KEADAAN_PMT
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_jenis_keadaan_pmt newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_jenis_keadaan_pmt newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_jenis_keadaan_pmt query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_jenis_keadaan_pmt whereJENISKEADAANPMT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_jenis_keadaan_pmt whereJENISKEADAANPMTID($value)
 * @mixin \Eloquent
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
