<?php

namespace App\Models;
 

/**
 * App\Models\Dc_indikasi_gangguan_tipe
 *
 * @property int $ID_TIPE_INDIKASI_GGN
 * @property string $NAMA_TIPE_INDIKASI_GGN
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan_tipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan_tipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan_tipe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan_tipe whereIDTIPEINDIKASIGGN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan_tipe whereNAMATIPEINDIKASIGGN($value)
 * @mixin \Eloquent
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
