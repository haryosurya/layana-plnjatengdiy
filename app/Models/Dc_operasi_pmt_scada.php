<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * @property int $OPERASI_PMT_ID
 * @property string $TGL_OPERASI_PMT
 * @property string $TGL_NORMAL_PMT
 * @property integer $JENIS_OPERASI_PMT
 * @property int $APJ_ID
 * @property string $CAKUPAN_KERJA
 * @property string $DETAIL_LOKASI
 * @property string $ALASAN_OPERASI_PMT
 * @property int $ID_TIPE_GANGGUAN
 * @property int $ID_INDIKASI_GANGGUAN
 * @property float $BEBAN_SBLM_PMT_LEPAS
 * @property float $TEG_SBLM_PMT_LEPAS
 * @property float $BEBAN_SSDH_PMT_LEPAS
 * @property float $TEG_SSDH_PMT_LEPAS
 * @property float $ARUS_GANGGUAN_PH_A
 * @property float $ARUS_GANGGUAN_PH_B
 * @property float $ARUS_GANGGUAN_PH_C
 * @property float $ARUS_GANGGUAN_PH_N
 * @property string $KET_ARUS_GANGGUAN
 * @property int $ASAL_ID
 * @property int $CUACA
 * @property string $LOKASI_GANGGUAN
 * @property int $JARAK_GANGGUAN
 * @property string $NO_POLE_TIANG
 * @property int $UPJ_ID
 * @property DcSpeedjardistJarakgangguan $dcSpeedjardistJarakgangguan
 * @property DcUpj $dcUpj
 * @property DcApj $dcApj
 * @property DcIndikasiGangguan $dcIndikasiGangguan
 * @property DcTipeGangguan $dcTipeGangguan
 * @property DcSpeedjardistCuaca $dcSpeedjardistCuaca
 */
class Dc_operasi_pmt_scada extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'dc_operasi_pmt_scada';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'OPERASI_PMT_ID';

    /**
     * @var array
     */
    protected $fillable = ['TGL_OPERASI_PMT', 'TGL_NORMAL_PMT', 'JENIS_OPERASI_PMT', 'APJ_ID', 'CAKUPAN_KERJA', 'DETAIL_LOKASI', 'ALASAN_OPERASI_PMT', 'ID_TIPE_GANGGUAN', 'ID_INDIKASI_GANGGUAN', 'BEBAN_SBLM_PMT_LEPAS', 'TEG_SBLM_PMT_LEPAS', 'BEBAN_SSDH_PMT_LEPAS', 'TEG_SSDH_PMT_LEPAS', 'ARUS_GANGGUAN_PH_A', 'ARUS_GANGGUAN_PH_B', 'ARUS_GANGGUAN_PH_C', 'ARUS_GANGGUAN_PH_N', 'KET_ARUS_GANGGUAN', 'ASAL_ID', 'CUACA', 'LOKASI_GANGGUAN', 'JARAK_GANGGUAN', 'NO_POLE_TIANG', 'UPJ_ID'];
    protected $dates = ['TGL_OPERASI_PMT', 'TGL_NORMAL_PMT', ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcSpeedjardistJarakgangguan()
    {
        return $this->belongsTo(Dc_speedjardist_cuaca::class, 'JARAK_GANGGUAN', 'ID_JARAK_GANGGUAN');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcUpj()
    {
        return $this->belongsTo(Dc_apj::class, 'UPJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcApj()
    {
        return $this->belongsTo(Dc_apj::class, 'APJ_ID', 'APJ_ID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcIndikasiGangguan()
    {
        return $this->belongsTo(Dc_indikasi_gangguan::class, 'ID_INDIKASI_GANGGUAN', 'ID_INDIKASI_GANGGUAN');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcTipeGangguan()
    {
        return $this->belongsTo(Dc_tipe_gangguan::class, 'ID_TIPE_GANGGUAN', 'ID_TIPE_GANGGUAN');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dcSpeedjardistCuaca()
    {
        return $this->belongsTo(Dc_speedjardist_cuaca::class, 'CUACA', 'ID_CUACA');
    }
}
