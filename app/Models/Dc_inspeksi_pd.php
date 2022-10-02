<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dc_inspeksi_pd extends Model
{
    protected $table = 'dc_inspeksi_pd';
    public function OUTGOING_ID()
    {
        return $this->belongsTo(Dc_cubicle::class, 'OUTGOING_ID', 'OUTGOING_ID');
    }
}
