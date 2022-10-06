<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id_inspeksi_pd
 * @property int $id_outgoing
 * @property int $id_user
 * @property int $id_gardu_induk
 * @property string $tgl_entry
 * @property string $tgl_inspeksi
 * @property int $citicality
 * @property string $level_pd
 * @property string $foto_pelaksanaan
 * @property string $foto_pengukuran
 * @property string $keterangan
 * @property int $id_update
 * @property string $last_update
 */
class ews_inspeksi_pd extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'ews_inspeksi_pd';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'id_inspeksi_pd';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['id_outgoing', 'id_user', 'id_gardu_induk', 'tgl_entry', 'tgl_inspeksi', 'citicality', 'level_pd', 'foto_pelaksanaan', 'foto_pengukuran', 'keterangan', 'id_update', 'last_update'];
}
