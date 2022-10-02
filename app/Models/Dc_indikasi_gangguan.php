<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_indikasi_gangguan
 *
 * @property int $ID_INDIKASI_GANGGUAN
 * @property string $NAMA_INDIKASI_GANGGUAN
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan whereIDINDIKASIGANGGUAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_indikasi_gangguan whereNAMAINDIKASIGANGGUAN($value)
 * @mixin \Eloquent
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
