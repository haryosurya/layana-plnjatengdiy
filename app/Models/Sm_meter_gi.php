<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $OUTGOING_METER_ID
 * @property int $OUTGOING_ID
 * @property float $IA
 * @property string $IA_TIME
 * @property float $IB
 * @property string $IB_TIME
 * @property float $IC
 * @property string $IC_TIME
 * @property float $IN
 * @property string $IN_TIME
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
 */
class Sm_meter_gi extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'sm_meter_gi';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OUTGOING_METER_ID';

    /**
     * @var array
     */
    protected $fillable = ['OUTGOING_ID', 'IA', 'IA_TIME', 'IB', 'IB_TIME', 'IC', 'IC_TIME', 'IN', 'IN_TIME', 'VLL', 'VLL_TIME', 'KW', 'KW_TIME', 'PF', 'PF_TIME', 'IFA', 'IFA_TIME', 'IFB', 'IFB_TIME', 'IFC', 'IFC_TIME', 'IFN', 'IFN_TIME'];
}
