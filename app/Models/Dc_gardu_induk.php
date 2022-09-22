<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $GARDU_INDUK_ID
 * @property int $APJ_ID
 * @property string $GARDU_INDUK_NAMA
 * @property string $GARDU_INDUK_KODE
 * @property int $GARDU_INDUK_RTU_ID
 * @property string $GARDU_INDUK_ALIAS
 * @property string $GARDU_INDUK_ALIAS_ROPO
 * @property string $GARDU_INDUK_ALAMAT
 * @property integer $UPT_ID
 * @property string $NAMA_ALIAS_GARDU_INDUK
 * @property integer $PEMELIHARAAN_GI
 * @property integer $BATAS_TEGANGAN_BAWAH
 * @property integer $BATAS_TEGANGAN_ATAS
 * @property DcApj $dcApj
 * @property DcIncomingFeeder[] $dcIncomingFeeders
 */
class Dc_gardu_induk extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_gardu_induk';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'GARDU_INDUK_ID';

    /**
     * @var array
     */
    protected $fillable = ['APJ_ID', 'GARDU_INDUK_NAMA', 'GARDU_INDUK_KODE', 'GARDU_INDUK_RTU_ID', 'GARDU_INDUK_ALIAS', 'GARDU_INDUK_ALIAS_ROPO', 'GARDU_INDUK_ALAMAT', 'UPT_ID', 'NAMA_ALIAS_GARDU_INDUK', 'PEMELIHARAAN_GI', 'BATAS_TEGANGAN_BAWAH', 'BATAS_TEGANGAN_ATAS'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcApj()
    {
        return $this->belongsTo( Dc_apj::class,  'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcIncomingFeeders()
    {
        return $this->hasMany(Dc_incoming_feeder::class ,'GARDU_INDUK_ID', 'GARDU_INDUK_ID');
    }
}
