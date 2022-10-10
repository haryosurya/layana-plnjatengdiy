<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $history_ews_id
 * @property int $outgoing_id
 * @property float $temp_A
 * @property string $temp_A_time
 * @property float $temp_B
 * @property string $temp_B_time
 * @property float $temp_C
 * @property string $temp_C_time
 * @property float $humid
 * @property string $humid_time
 */
class Ews_history_meter extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ews_history_meter';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'history_ews_id';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    // public $incrementing = false;
public $timestamps = false;
    /**
     * @var array
     */
    protected $fillable = ['outgoing_id', 'temp_A', 'temp_A_time', 'temp_B', 'temp_B_time', 'temp_C', 'temp_C_time', 'humid', 'humid_time'];
}
