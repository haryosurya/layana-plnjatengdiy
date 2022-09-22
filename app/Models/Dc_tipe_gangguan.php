<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_TIPE_GANGGUAN
 * @property string $NAMA_TIPE_GANGGUAN
 * @property string $KODE_GANGGUAN
 * @property int $INDUK_KODE
 * @property DcTipeGangguanKodeInduk $dcTipeGangguanKodeInduk
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
