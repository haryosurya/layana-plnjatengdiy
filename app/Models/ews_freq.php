<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $freq_id
 * @property int $outgoing_id
 * @property float $freq
 * @property string $freq_time
 */
class ews_freq extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ews_freq';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'freq_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['outgoing_id', 'freq', 'freq_time'];
}
