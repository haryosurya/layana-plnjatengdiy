<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_apj
 *
 * @property int $APJ_ID
 * @property string $APJ_NAMA
 * @property string $APJ_ALIAS
 * @property string $APJ_DCC
 * @property string $APJ_ALAMAT
 * @property int $APJ_KODE
 * @property string $TELEGRAM_ID
 * @property DcCubicle[] $dcCubicles
 * @property DcCubicle[] $dcCubicles
 * @property DcGarduInduk[] $dcGarduInduks
 * @property DcIncomingFeeder[] $dcIncomingFeeders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dc_cubicle[] $ApjId
 * @property-read int|null $apj_id_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Dc_cubicle[] $SupplyApj
 * @property-read int|null $supply_apj_count
 * @property-read int|null $dc_gardu_induks_count
 * @property-read int|null $dc_incoming_feeders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJALAMAT($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJALIAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJDCC($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJID($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJKODE($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereAPJNAMA($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_apj whereTELEGRAMID($value)
 * @mixin \Eloquent
 */
class Dc_apj extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_apj';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'APJ_ID';

    /**
     * @var array
     */
    protected $fillable = ['APJ_NAMA', 'APJ_ALIAS', 'APJ_DCC', 'APJ_ALAMAT', 'APJ_KODE', 'TELEGRAM_ID'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function SupplyApj()
    {
        return $this->hasMany(Dc_cubicle::class, 'SUPPLY_APJ', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ApjId()
    {
        return $this->hasMany(Dc_cubicle::class,  'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcGarduInduks()
    {
        return $this->hasMany(Dc_gardu_induk::class, 'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dcIncomingFeeders()
    {
        return $this->hasMany(Dc_incoming_feeder::class,'APJ_ID', 'APJ_ID');
    }
}
