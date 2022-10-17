<style>
    .card-img {
        width: 120px;
        height: 120px;
    }

    .card-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

</style>
 

<div class="d-lg-flex">

    <div class="project-left w-100 py-0 py-lg-5 py-md-0">
        <!-- ROW START -->
        <div class="row">
            <!--   CARDS START -->
            <div class="col-lg-6 col-md-6 mb-4 mb-xl-0 mb-lg-4 mb-md-0">   
                <x-cards.data :title="__('modules.dc.rekap-gangguan')" class=" mt-4">
                    <x-cards.data-row :label="__('modules.dc.rekap-gangguan')"
                        :value="(!is_null($rekapGangguan->id) && !is_null($rekapGangguan->id)) ? ucwords($rekapGangguan->id) : '--'" />
 
                    <x-cards.data-row :label="__('modules.dc.apj')" :value="$rekapGangguan->APJ_ID" />

                    <x-cards.data-row :label="__('modules.dc.dcc')"
                        :value="(!is_null($rekapGangguan->dcApj->APJ_DCC) && !is_null($rekapGangguan->dcApj->APJ_DCC)) ? ucwords($rekapGangguan->dcApj->APJ_DCC) : '--'" />

                    <x-cards.data-row :label="__('modules.dc.apj-nama')"
                        :value="(isset($rekapGangguan->dcApj->APJ_NAMA) && !is_null($rekapGangguan->dcApj->APJ_NAMA) && !is_null($rekapGangguan->dcApj->APJ_NAMA)) ? ucwords($rekapGangguan->dcApj->APJ_NAMA) : '--'" />
                    
                    <x-cards.data-row :label="__('modules.dc.cakupan-kerja')"
                        :value="(isset($rekapGangguan->CAKUPAN_KERJA) && !is_null($rekapGangguan->CAKUPAN_KERJA) && !is_null($rekapGangguan->CAKUPAN_KERJA)) ? ucwords($rekapGangguan->CAKUPAN_KERJA) : '--'" />
                    
                        <x-cards.data-row :label="__('modules.dc.tgl-operasi')"
                        :value="(!is_null($rekapGangguan->TGL_OPERASI_PMT) && !is_null($rekapGangguan->TGL_OPERASI_PMT)) ? $rekapGangguan->TGL_OPERASI_PMT->format($global->date_format) : '--'" />
 
                    <x-cards.data-row :label="__('modules.dc.tgl-normal')"
                        :value="(!is_null($rekapGangguan->TGL_NORMAL_PMT) && !is_null($rekapGangguan->TGL_NORMAL_PMT)) ? $rekapGangguan->TGL_NORMAL_PMT->format($global->date_format) : '--'" />

                    <x-cards.data-row :label="__('modules.dc.jenis-operasi')"
                        :value="$rekapGangguan->JENIS_OPERASI_PMT ?? '--'" />
                        {{--  
                        'DETAIL_LOKASI',
                        'ALASAN_OPERASI_PMT',
                        'dc_tipe_gangguan.NAMA_TIPE_GANGGUAN as TIPE_GANGGUAN',
                        'dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN as INDIKASI_GANGGUAN',
                        'BEBAN_SBLM_PMT_LEPAS',
                        'TEG_SBLM_PMT_LEPAS',
                        'BEBAN_SSDH_PMT_LEPAS',
                        'TEG_SSDH_PMT_LEPAS',
                        'ARUS_GANGGUAN_PH_A',
                        'ARUS_GANGGUAN_PH_B',
                        'ARUS_GANGGUAN_PH_C',
                        'ARUS_GANGGUAN_PH_N',
                        'KET_ARUS_GANGGUAN',
                        'ASAL_ID',
                        'dc_speedjardist_cuaca.CUACA_NAME as CUACA_NAME',
                        'LOKASI_GANGGUAN',
                        'JARAK_GANGGUAN',
                        'NO_POLE_TIANG',
                        'UPJ_ID' 	 --}} 
 
                </x-cards.data> 
            </div>
            <div class="col-lg-6 col-md-6 mb-4 mb-xl-0 mb-lg-4 mb-md-0">   
                <x-cards.data :title="__('modules.dc.rekap-gangguan')" class=" mt-4">
                    <x-cards.data-row :label="__('modules.dc.rekap-gangguan')"
                        :value="(!is_null($rekapGangguan->id) && !is_null($rekapGangguan->id)) ? ucwords($rekapGangguan->id) : '--'" />
 
                    <x-cards.data-row :label="__('modules.dc.')" :value="$rekapGangguan->APJ_ID" />

                    <x-cards.data-row :label="__('modules.dc.')"
                        :value="(!is_null($rekapGangguan->APJ_DCC) && !is_null($rekapGangguan->APJ_DCC)) ? ucwords($rekapGangguan->APJ_DCC) : '--'" />

                    <x-cards.data-row :label="__('modules.dc.')"
                        :value="(isset($rekapGangguan->APJ_NAMA) && !is_null($rekapGangguan->APJ_NAMA) && !is_null($rekapGangguan->APJ_NAMA)) ? ucwords($rekapGangguan->APJ_NAMA) : '--'" />
                    
                    <x-cards.data-row :label="__('modules.dc.')"
                        :value="(isset($rekapGangguan->CAKUPAN_KERJA) && !is_null($rekapGangguan->CAKUPAN_KERJA) && !is_null($rekapGangguan->CAKUPAN_KERJA)) ? ucwords($rekapGangguan->CAKUPAN_KERJA) : '--'" />
 
                        {{--  
                        'DETAIL_LOKASI',
                        'ALASAN_OPERASI_PMT',
                        'dc_tipe_gangguan.NAMA_TIPE_GANGGUAN as TIPE_GANGGUAN',
                        'dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN as INDIKASI_GANGGUAN',
                        'BEBAN_SBLM_PMT_LEPAS',
                        'TEG_SBLM_PMT_LEPAS',
                        'BEBAN_SSDH_PMT_LEPAS',
                        'TEG_SSDH_PMT_LEPAS',
                        'ARUS_GANGGUAN_PH_A',
                        'ARUS_GANGGUAN_PH_B',
                        'ARUS_GANGGUAN_PH_C',
                        'ARUS_GANGGUAN_PH_N',
                        'KET_ARUS_GANGGUAN',
                        'ASAL_ID',
                        'dc_speedjardist_cuaca.CUACA_NAME as CUACA_NAME',
                        'LOKASI_GANGGUAN',
                        'JARAK_GANGGUAN',
                        'NO_POLE_TIANG',
                        'UPJ_ID' 	 --}} 

                    <x-cards.data-row :label="__('modules.dc.tgl-operasi')"
                        :value="(!is_null($rekapGangguan->TGL_OPERASI_PMT) && !is_null($rekapGangguan->TGL_OPERASI_PMT)) ? $rekapGangguan->TGL_OPERASI_PMT->format($global->date_format) : '--'" />
 
                    <x-cards.data-row :label="__('modules.dc.tgl-normal')"
                        :value="(!is_null($rekapGangguan->TGL_NORMAL_PMT) && !is_null($rekapGangguan->TGL_NORMAL_PMT)) ? $rekapGangguan->TGL_NORMAL_PMT->format($global->date_format) : '--'" />

                    <x-cards.data-row :label="__('modules.dc.jenis-operasi')"
                        :value="$rekapGangguan->JENIS_OPERASI_PMT ?? '--'" />


                </x-cards.data> 
            </div>
            <!--   CARDS END -->  
        </div>
        <!-- ROW END -->
    </div>
 
</div>
