<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $OUTGOING_ID
 * @property int $APJ_ID
 * @property int $SUPPLY_APJ
 * @property int $INCOMING_ID
 * @property string $CUBICLE_NAME
 * @property int $CUBICLE_TYPE
 * @property int $OPERATION_TYPE
 * @property string $KETERANGAN
 * @property string $RELAY
 * @property string $MERK_RELAY
 * @property string $NO_SERI_RELAY
 * @property string $METER
 * @property string $MERK_METER
 * @property string $NO_SERI_METER
 * @property string $MERK_IO
 * @property string $NO_SERI_IO
 * @property string $MERK_INTERFACE
 * @property string $NO_SERI_INTERFACE
 * @property string $MERK_PS
 * @property string $SETTING_CT
 * @property string $SETTING_PT
 * @property string $MERK
 * @property string $MERK_CUBICLE
 * @property string $NO_SERI
 * @property string $DIMENSI
 * @property string $RNR
 * @property string $TAHUN_OPERASI
 * @property integer $OCR_TD
 * @property string $OCR_TMS_TD
 * @property string $OCR_CURVA
 * @property string $OCR_INST
 * @property string $OCR_T_INST
 * @property integer $GFR_TD
 * @property string $GFR_TMS_TD
 * @property string $GFR_CURVA
 * @property string $GFR_INST
 * @property string $GFR_T_INST
 * @property integer $UPJ_ID
 * @property integer $UPJ_ID2
 * @property integer $OCR_HS1
 * @property string $OCR_T_HS1
 * @property integer $OCR_HS2
 * @property string $OCR_T_HS2
 * @property integer $GFR_HS1
 * @property string $GFR_T_HS1
 * @property integer $GFR_HS2
 * @property string $GFR_T_HS2
 * @property string $USER_UPDATE
 * @property string $LAST_UPDATE
 * @property float $WARNING_LIMIT
 * @property float $IA
 * @property string $IA_TIME
 * @property float $IB
 * @property string $IB_TIME
 * @property float $IC
 * @property string $IC_TIME
 * @property float $IN
 * @property string $IN_TIME
 * @property float $IA2
 * @property string $IA2_TIME
 * @property float $IB2
 * @property string $IB2_TIME
 * @property float $IC2
 * @property string $IC2_TIME
 * @property float $IN2
 * @property string $IN2_TIME
 * @property float $VLL
 * @property string $VLL_TIME
 * @property float $KW
 * @property string $KW_TIME
 * @property float $PF
 * @property string $PF_TIME
 * @property float $IFA
 * @property string $IFA_TIME
 * @property float $IFB
 * @property string $IFB_TIME
 * @property float $IFC
 * @property string $IFC_TIME
 * @property float $IFN
 * @property string $IFN_TIME
 * @property integer $SCB
 * @property integer $SCB_INV
 * @property string $SCB_TIME
 * @property integer $SLR
 * @property integer $SLR_INV
 * @property string $SLR_TIME
 * @property integer $SRNR
 * @property integer $SRNR_INV
 * @property string $SRNR_TIME
 * @property integer $SESW
 * @property integer $SESW_INV
 * @property string $SESW_TIME
 * @property integer $SCBP
 * @property string $SCBP_TIME
 * @property integer $SCBP_INV
 * @property float $TEMP_A
 * @property string $TEMP_A_TIME
 * @property float $TEMP_B
 * @property string $TEMP_B_TIME
 * @property float $TEMP_C
 * @property string $TEMP_C_TIME
 * @property float $HUMIDITY
 * @property string $HUMIDITY_TIME
 * @property float $LIMIT_UPPER_TEMP
 * @property float $LIMIT_UPPER_HUMIDITY
 * @property float $PD_CRITICAL
 * @property string $PD_LEVEL
 * @property string $PD_TIME
 * @property DcApj $dcApj
 * @property DcApj $dcApj
 * @property DcIncomingFeeder $dcIncomingFeeder
 * @property DcInspeksiPenyulang[] $dcInspeksiPenyulangs
 */
class Dc_cubicle extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_cubicle';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OUTGOING_ID';

    /**
     * @var array
     */
    protected $fillable = ['APJ_ID', 'SUPPLY_APJ', 'INCOMING_ID', 'CUBICLE_NAME', 'CUBICLE_TYPE', 'OPERATION_TYPE', 'KETERANGAN', 'RELAY', 'MERK_RELAY', 'NO_SERI_RELAY', 'METER', 'MERK_METER', 'NO_SERI_METER', 'MERK_IO', 'NO_SERI_IO', 'MERK_INTERFACE', 'NO_SERI_INTERFACE', 'MERK_PS', 'SETTING_CT', 'SETTING_PT', 'MERK', 'MERK_CUBICLE', 'NO_SERI', 'DIMENSI', 'RNR', 'TAHUN_OPERASI', 'OCR_TD', 'OCR_TMS_TD', 'OCR_CURVA', 'OCR_INST', 'OCR_T_INST', 'GFR_TD', 'GFR_TMS_TD', 'GFR_CURVA', 'GFR_INST', 'GFR_T_INST', 'UPJ_ID', 'UPJ_ID2', 'OCR_HS1', 'OCR_T_HS1', 'OCR_HS2', 'OCR_T_HS2', 'GFR_HS1', 'GFR_T_HS1', 'GFR_HS2', 'GFR_T_HS2', 'USER_UPDATE', 'LAST_UPDATE', 'WARNING_LIMIT', 'IA', 'IA_TIME', 'IB', 'IB_TIME', 'IC', 'IC_TIME', 'IN', 'IN_TIME', 'IA2', 'IA2_TIME', 'IB2', 'IB2_TIME', 'IC2', 'IC2_TIME', 'IN2', 'IN2_TIME', 'VLL', 'VLL_TIME', 'KW', 'KW_TIME', 'PF', 'PF_TIME', 'IFA', 'IFA_TIME', 'IFB', 'IFB_TIME', 'IFC', 'IFC_TIME', 'IFN', 'IFN_TIME', 'SCB', 'SCB_INV', 'SCB_TIME', 'SLR', 'SLR_INV', 'SLR_TIME', 'SRNR', 'SRNR_INV', 'SRNR_TIME', 'SESW', 'SESW_INV', 'SESW_TIME', 'SCBP', 'SCBP_TIME', 'SCBP_INV', 'TEMP_A', 'TEMP_A_TIME', 'TEMP_B', 'TEMP_B_TIME', 'TEMP_C', 'TEMP_C_TIME', 'HUMIDITY', 'HUMIDITY_TIME', 'LIMIT_UPPER_TEMP', 'LIMIT_UPPER_HUMIDITY', 'PD_CRITICAL', 'PD_LEVEL', 'PD_TIME'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcApj()
    {
        return $this->belongsTo('App\DcApj', 'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcApjs()
    {
        return $this->belongsTo('App\DcApj', 'SUPPLY_APJ', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcIncomingFeeder()
    {
        return $this->belongsTo('App\DcIncomingFeeder', 'INCOMING_ID', 'INCOMING_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcInspeksiPenyulangs()
    {
        return $this->hasMany('App\DcInspeksiPenyulang', 'OUTGOING_ID', 'OUTGOING_ID');
    }
}
