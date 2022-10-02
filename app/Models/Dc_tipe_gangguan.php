<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_tipe_gangguan
 *
 * @property int $ID_TIPE_GANGGUAN
 * @property string $NAMA_TIPE_GANGGUAN
 * @property string $KODE_GANGGUAN
 * @property int $INDUK_KODE
 * @property DcTipeGangguanKodeInduk $dcTipeGangguanKodeInduk
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan whereIDTIPEGANGGUAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan whereINDUKKODE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan whereKODEGANGGUAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_tipe_gangguan whereNAMATIPEGANGGUAN($value)
 * @mixin \Eloquent
 */
class Dc_tipe_gangguan extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_tipe_gangguan';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_TIPE_GANGGUAN';

    /**
     * @var array
     */
    protected $fillable = ['NAMA_TIPE_GANGGUAN', 'KODE_GANGGUAN', 'INDUK_KODE'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcTipeGangguanKodeInduk()
    {
        return $this->belongsTo(Dc_tipe_gangguan::class, 'INDUK_KODE', 'ID_INDUK_KODE_GGN');
    }
}
