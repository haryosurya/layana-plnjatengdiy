<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dc_speedjardist_cuaca
 *
 * @property int $ID_CUACA
 * @property string $CUACA_NAME
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_speedjardist_cuaca newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_speedjardist_cuaca newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_speedjardist_cuaca query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_speedjardist_cuaca whereCUACANAME($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dc_speedjardist_cuaca whereIDCUACA($value)
 * @mixin \Eloquent
 */
class Dc_speedjardist_cuaca extends BaseModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_speedjardist_cuaca';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'ID_CUACA';

    /**
     * @var array
     */
    protected $fillable = ['CUACA_NAME'];
}
