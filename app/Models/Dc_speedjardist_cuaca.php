<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $ID_CUACA
 * @property string $CUACA_NAME
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
