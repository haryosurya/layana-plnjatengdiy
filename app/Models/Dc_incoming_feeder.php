<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $INCOMING_ID
 * @property int $GARDU_INDUK_ID
 * @property int $INCOMING_NAME
 * @property string $MERK_TRAFO
 * @property string $DAYA_REAKTIF_TRAFO
 * @property string $RASIO_TEGANGAN
 * @property string $NAMA_ALIAS_INCOMING
 * @property float $I_NOMINAL_HV
 * @property float $I_NOMINAL_LV
 * @property string $PABRIKAN_RELAY
 * @property string $METER
 * @property string $PABRIKAN_METER
 * @property boolean $PQM
 * @property string $PQM_SN
 * @property string $PQM_IP_ADDRESS
 * @property string $OCR_TD
 * @property string $OCR_TMS_TD
 * @property string $OCR_CURVA
 * @property string $OCR_INST
 * @property string $OCR_T_INST
 * @property string $GFR_TD
 * @property string $GFR_TMS_TD
 * @property string $GFR_CURVA
 * @property string $GFR_INST
 * @property string $GFR_T_INST
 * @property string $TGL_KESEPAKATAN
 * @property string $TAHUN_ENERGIZE
 * @property string $RELAY
 * @property float $BATAS_BAWAH_TEG
 * @property float $BATAS_ATAS_TEG
 * @property int $APJ_ID
 * @property float $TRAFO_KAPASITAS
 * @property float $ARUS_HS_3PH
 * @property float $ARUS_HS_150
 * @property integer $TEG_PRIMER
 * @property integer $TEG_SEKUNDER
 * @property float $TRAFO_IMPEDANSI
 * @property float $RL1_FF
 * @property float $XL1_FF
 * @property float $RL0_FN
 * @property float $XL0_FN
 * @property float $TRAFO_I_NOMINAL
 * @property float $IN
 * @property float $PRIMER
 * @property string $KETERANGAN
 * @property string $USER_UPDATE
 * @property string $LAST_UPDATE
 * @property float $IA
 * @property float $IB
 * @property float $IC
 * @property float $IG
 * @property float $KW
 * @property DcApj $dcApj
 * @property DcTrafo $dcTrafo
 * @property DcGarduInduk $dcGarduInduk
 * @property DcCubicle[] $dcCubicles
 */
class Dc_incoming_feeder extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_incoming_feeder';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'INCOMING_ID';

    /**
     * @var array
     */
    protected $fillable = ['GARDU_INDUK_ID', 'INCOMING_NAME', 'MERK_TRAFO', 'DAYA_REAKTIF_TRAFO', 'RASIO_TEGANGAN', 'NAMA_ALIAS_INCOMING', 'I_NOMINAL_HV', 'I_NOMINAL_LV', 'PABRIKAN_RELAY', 'METER', 'PABRIKAN_METER', 'PQM', 'PQM_SN', 'PQM_IP_ADDRESS', 'OCR_TD', 'OCR_TMS_TD', 'OCR_CURVA', 'OCR_INST', 'OCR_T_INST', 'GFR_TD', 'GFR_TMS_TD', 'GFR_CURVA', 'GFR_INST', 'GFR_T_INST', 'TGL_KESEPAKATAN', 'TAHUN_ENERGIZE', 'RELAY', 'BATAS_BAWAH_TEG', 'BATAS_ATAS_TEG', 'APJ_ID', 'TRAFO_KAPASITAS', 'ARUS_HS_3PH', 'ARUS_HS_150', 'TEG_PRIMER', 'TEG_SEKUNDER', 'TRAFO_IMPEDANSI', 'RL1_FF', 'XL1_FF', 'RL0_FN', 'XL0_FN', 'TRAFO_I_NOMINAL', 'IN', 'PRIMER', 'KETERANGAN', 'USER_UPDATE', 'LAST_UPDATE', 'IA', 'IB', 'IC', 'IG', 'KW'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcApj()
    {
        return $this->belongsTo( Dc_apj::class,  'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    // public function dcTrafo()
    // {
    //     return $this->belongsTo('App\Models\DcTrafo', 'INCOMING_NAME', 'TRAFO_ID');
    // }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcGarduInduk()
    {
        return $this->belongsTo( Dc_gardu_induk::class, 'GARDU_INDUK_ID', 'GARDU_INDUK_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcCubicles()
    {
        return $this->hasMany( Dc_cubicle::class, 'INCOMING_ID', 'INCOMING_ID');
    }
}
