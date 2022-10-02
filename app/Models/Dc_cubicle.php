<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_cubicle
 *
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
 * @property DcApj $dcApj
 * @property DcApj $dcApj
 * @property DcIncomingFeeder $dcIncomingFeeder
 * @property-read \App\Models\Dc_apj|null $ApjId
 * @property-read \App\Models\Dc_apj|null $SupplyApj
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereAPJID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereCUBICLENAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereCUBICLETYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereDIMENSI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRCURVA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRHS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRHS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRINST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRTD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRTHS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRTHS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRTINST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereGFRTMSTD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIA2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIA2TIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIATIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIB2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIB2TIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIBTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIC2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIC2TIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereICTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFATIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFBTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFCTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIFNTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIN2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereIN2TIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereINCOMINGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereINTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereKETERANGAN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereKW($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereKWTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereLASTUPDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERK($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKCUBICLE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKINTERFACE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKIO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKMETER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKPS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMERKRELAY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereMETER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereNOSERI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereNOSERIINTERFACE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereNOSERIIO($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereNOSERIMETER($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereNOSERIRELAY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRCURVA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRHS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRHS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRINST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRTD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRTHS1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRTHS2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRTINST($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOCRTMSTD($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOPERATIONTYPE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereOUTGOINGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle wherePF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle wherePFTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereRELAY($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereRNR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCBINV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCBP($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCBPINV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCBPTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSCBTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSESW($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSESWINV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSESWTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSETTINGCT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSETTINGPT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSLR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSLRINV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSLRTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSRNR($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSRNRINV($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSRNRTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereSUPPLYAPJ($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereTAHUNOPERASI($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereUPJID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereUPJID2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereUSERUPDATE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereVLL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereVLLTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_cubicle whereWARNINGLIMIT($value)
 * @mixin \Eloquent
 */
class Dc_cubicle extends BaseModel
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
    protected $fillable = ['APJ_ID', 'SUPPLY_APJ', 'INCOMING_ID', 'CUBICLE_NAME', 'CUBICLE_TYPE', 'OPERATION_TYPE', 'KETERANGAN', 'RELAY', 'MERK_RELAY', 'NO_SERI_RELAY', 'METER', 'MERK_METER', 'NO_SERI_METER', 'MERK_IO', 'NO_SERI_IO', 'MERK_INTERFACE', 'NO_SERI_INTERFACE', 'MERK_PS', 'SETTING_CT', 'SETTING_PT', 'MERK', 'MERK_CUBICLE', 'NO_SERI', 'DIMENSI', 'RNR', 'TAHUN_OPERASI', 'OCR_TD', 'OCR_TMS_TD', 'OCR_CURVA', 'OCR_INST', 'OCR_T_INST', 'GFR_TD', 'GFR_TMS_TD', 'GFR_CURVA', 'GFR_INST', 'GFR_T_INST', 'UPJ_ID', 'UPJ_ID2', 'OCR_HS1', 'OCR_T_HS1', 'OCR_HS2', 'OCR_T_HS2', 'GFR_HS1', 'GFR_T_HS1', 'GFR_HS2', 'GFR_T_HS2', 'USER_UPDATE', 'LAST_UPDATE', 'WARNING_LIMIT', 'IA', 'IA_TIME', 'IB', 'IB_TIME', 'IC', 'IC_TIME', 'IN', 'IN_TIME', 'IA2', 'IA2_TIME', 'IB2', 'IB2_TIME', 'IC2', 'IC2_TIME', 'IN2', 'IN2_TIME', 'VLL', 'VLL_TIME', 'KW', 'KW_TIME', 'PF', 'PF_TIME', 'IFA', 'IFA_TIME', 'IFB', 'IFB_TIME', 'IFC', 'IFC_TIME', 'IFN', 'IFN_TIME', 'SCB', 'SCB_INV', 'SCB_TIME', 'SLR', 'SLR_INV', 'SLR_TIME', 'SRNR', 'SRNR_INV', 'SRNR_TIME', 'SESW', 'SESW_INV', 'SESW_TIME', 'SCBP', 'SCBP_TIME', 'SCBP_INV'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ApjId()
    {
        return $this->belongsTo( Dc_apj::class ,'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SupplyApj()
    {
        return $this->belongsTo( Dc_apj::class, 'SUPPLY_APJ', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcIncomingFeeder()
    {
        return $this->belongsTo(Dc_incoming_feeder::class , 'INCOMING_ID', 'INCOMING_ID');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcInspeksiPenyulangs()
    {
        return $this->hasMany('App\DcInspeksiPenyulang', 'OUTGOING_ID', 'OUTGOING_ID');
    }
}
