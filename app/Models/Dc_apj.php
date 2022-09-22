<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
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
