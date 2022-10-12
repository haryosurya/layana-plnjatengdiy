<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sm_meter_gi
 *
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
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIATIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIBTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereICTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFATIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFB($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFBTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFCTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIFNTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereIN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereINTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereKW($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereKWTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereOUTGOINGID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereOUTGOINGMETERID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi wherePF($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi wherePFTIME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereVLL($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sm_meter_gi whereVLLTIME($value)
 * @mixin \Eloquent
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

    public function OUTGOING_ID()
    {
        return $this->belongsTo(Dc_cubicle::class, 'OUTGOING_ID', 'OUTGOING_ID');
    }
}
