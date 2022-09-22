<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_INDIKASI_GANGGUAN
 * @property string $NAMA_INDIKASI_GANGGUAN
 */
class Dc_indikasi_gangguan extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_indikasi_gangguan';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_INDIKASI_GANGGUAN';

    /**
     * @var array
     */
    protected $fillable = ['NAMA_INDIKASI_GANGGUAN'];
}
