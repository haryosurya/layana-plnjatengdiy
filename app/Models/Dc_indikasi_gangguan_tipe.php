<?php

namespace App\Models;
 

/**
 * @property int $ID_TIPE_INDIKASI_GGN
 * @property string $NAMA_TIPE_INDIKASI_GGN
 */
class Dc_indikasi_gangguan_tipe extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_indikasi_gangguan_tipe';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_TIPE_INDIKASI_GGN';

    /**
     * @var array
     */
    protected $fillable = ['NAMA_TIPE_INDIKASI_GGN'];
}
