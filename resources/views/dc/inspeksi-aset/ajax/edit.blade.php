 
<link rel="stylesheet" href="{{ asset('vendor/css/tagify.css') }}">
<style>
    .tagify_tags .height-35 {
        height: auto !important;
    }

</style>

<div class="row">
    <div class="col-sm-12">
        <x-form id="save-data-form" method="PUT">
            <div class="add-client bg-white rounded">
                 

                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.clean_cubicle')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.body_cubicle')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="body_cubicle_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="body_cubicle"
                                    fieldValue="Bersih" :checked="($aset->body_cubicle == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="body_cubicle_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldValue="Kotor"
                                    fieldName="body_cubicle"
                                    :checked="($aset->body_cubicle == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.lv')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="lv_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="lv"
                                    fieldValue="Bersih" :checked="($aset->lv == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="lv_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="lv"
                                    fieldValue="Kotor" 
                                    :checked="($aset->lv == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>  
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.cb')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="cb_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="cb"
                                    fieldValue="Bersih" 
                                    :checked="($aset->cb == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="cb_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="cb"
                                    fieldValue="Kotor"
                                    :checked="($aset->cb == 'Kotor') ? 'checked' : ''" >
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>  

                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.busbar')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="busbar_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="busbar"
                                    fieldValue="Bersih"
                                    :checked="($aset->busbar == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="busbar_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="busbar"
                                    fieldValue="Kotor" 
                                    :checked="($aset->busbar == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>   
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.power_cable')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="power_cable_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="power_cable"
                                    fieldValue="Bersih" 
                                    :checked="($aset->power_cable == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="power_cable_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="power_cable"
                                    fieldValue="Kotor"
                                    :checked="($aset->power_cable == 'Kotor') ? 'checked' : ''" >
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>   
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.pmt_cb')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="pmt_cb_bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="pmt_cb"
                                    fieldValue="Bersih" 
                                    :checked="($aset->pmt_cb == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="pmt_cb_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="pmt_cb"
                                    fieldValue="Kotor" 
                                    :checked="($aset->pmt_cb == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>   
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.ak20kv')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.announ')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="announ-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="announ"
                                    fieldValue="Baik" :checked="($aset->announ == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="announ-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="announ"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->announ == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.ind_lamp')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="ind_lamp-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="ind_lamp"
                                    fieldValue="Baik" :checked="($aset->ind_lamp == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ind_lamp-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ind_lamp"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->ind_lamp == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.ind_volt')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="ind_volt-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="ind_volt"
                                    fieldValue="Baik" :checked="($aset->ind_volt == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ind_volt-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ind_volt"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->ind_volt == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.ac220')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="ac220-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="ac220"
                                    fieldValue="Baik" :checked="($aset->ac220 == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ac220-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ac220"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->ac220 == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.dc110')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="dc110-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="dc110"
                                    fieldValue="Baik" :checked="($aset->dc110 == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="dc110-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="dc110"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->dc110 == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.kkubikel')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.desis')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="desis-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="desis"
                                    fieldValue="Ada" :checked="($aset->desis == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="desis-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="desis"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->desis == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.dengung')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="dengung-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="dengung"
                                    fieldValue="Ada" :checked="($aset->dengung == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="dengung-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="dengung"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->dengung == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.ngeter')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="ngeter-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="ngeter"
                                    fieldValue="Ada" :checked="($aset->ngeter == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ngeter-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="ngeter"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->ngeter == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.flash')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="flash-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="flash"
                                    fieldValue="Ada" :checked="($aset->flash == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="flash-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="flash"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->flash == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.sangit')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="sangit-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="sangit"
                                    fieldValue="Ada" :checked="($aset->sangit == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="sangit-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="sangit"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->sangit == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.amis')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="amis-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="amis"
                                    fieldValue="Ada" :checked="($aset->amis == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="amis-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="amis"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->amis == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.statkub')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.feeder')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="feeder-ada" :fieldLabel="__('app.operasi')" 
                                    fieldName="feeder"
                                    fieldValue="Operasi" :checked="($aset->feeder == 'Operasi') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="feeder-tada" :fieldLabel="__('app.cadangan')" 
                                    fieldName="feeder"
                                    fieldValue="Cadangan"
                                    :checked="($aset->feeder == 'Cadangan') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.kubikel')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="kubikel-ada" :fieldLabel="__('app.berbeban')" 
                                    fieldName="kubikel"
                                    fieldValue="Berbeban" :checked="($aset->kubikel == 'Berbeban') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="kubikel-tada" :fieldLabel="__('app.bertegangan')" 
                                    fieldName="kubikel"
                                    fieldValue="Bertegangan"
                                    :checked="($aset->kubikel == 'Bertegangan') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.pmt')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="pmt-ada" :fieldLabel="__('app.testpos')" 
                                    fieldName="pmt"
                                    fieldValue="Test Posisi" :checked="($aset->pmt == 'Test Posisi') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="pmt-tada" :fieldLabel="__('app.servpos')" 
                                    fieldName="pmt"
                                    fieldValue="Service Posisi"
                                    :checked="($aset->pmt == 'Service Posisi') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.grounding')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="grounding-on" :fieldLabel="__('app.on')" 
                                    fieldName="grounding"
                                    fieldValue="On" 
                                    :checked="($aset->grounding == 'On') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="grounding-off" :fieldLabel="__('app.off')" 
                                    fieldName="grounding"
                                    fieldValue="Off"
                                    :checked="($aset->grounding == 'Off') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.sangit2')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="sangit2-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="sangit2"
                                    fieldValue="On" 
                                    :checked="($aset->sangit2 == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="sangit2-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="sangit2"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->sangit2 == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.slr')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="slr-ada" :fieldLabel="__('app.local')" 
                                    fieldName="slr"
                                    fieldValue="Local" 
                                    :checked="($aset->slr == 'Local') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="slr-remote" :fieldLabel="__('app.remote')" 
                                    fieldName="slr"
                                    fieldValue="Remote"
                                    :checked="($aset->slr == 'Remote') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.sar')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="sar-on" :fieldLabel="__('app.on')" 
                                    fieldName="sar"
                                    fieldValue="On" 
                                    :checked="($aset->sar == 'On') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="sar-off" :fieldLabel="__('app.off')" 
                                    fieldName="sar"
                                    fieldValue="Off"
                                    :checked="($aset->sar == 'Off') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.perprop')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.body_alat')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="body_alat-bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="body_alat"
                                    fieldValue="Bersih" :checked="($aset->body_alat == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="body_alat-kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="body_alat"
                                    fieldValue="Kotor"
                                    :checked="($aset->body_alat == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.wiring')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="wiring-bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="wiring"
                                    fieldValue="Bersih" :checked="($aset->wiring == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="wiring-kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="wiring"
                                    fieldValue="Kotor"
                                    :checked="($aset->wiring == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.w_prot')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="w_prot-kencang" :fieldLabel="__('app.kencang')" 
                                    fieldName="w_prot"
                                    fieldValue="Kencang" :checked="($aset->w_prot == 'Kencang') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="w_prot-kendor" :fieldLabel="__('app.kendor')" 
                                    fieldName="w_prot"
                                    fieldValue="Kendor"
                                    :checked="($aset->w_prot == 'Kendor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.w_meter')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="w_meter-kencang" :fieldLabel="__('app.kencang')" 
                                    fieldName="w_meter"
                                    fieldValue="Kencang" :checked="($aset->w_meter == 'Kencang') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="w_meter-kendor" :fieldLabel="__('app.kendor')" 
                                    fieldName="w_meter"
                                    fieldValue="Kendor"
                                    :checked="($aset->w_meter == 'Kendor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.w_acc')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="w_acc-kencang" :fieldLabel="__('app.kencang')" 
                                    fieldName="w_acc"
                                    fieldValue="Kencang" :checked="($aset->w_acc == 'Kencang') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="w_acc-kendor" :fieldLabel="__('app.kendor')" 
                                    fieldName="w_acc"
                                    fieldValue="Kendor"
                                    :checked="($aset->w_acc == 'Kendor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.konAct')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.relay_ready')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="relay_ready-ready" :fieldLabel="__('app.ready')" 
                                    fieldName="relay_ready"
                                    fieldValue="Ready" :checked="($aset->relay_ready == 'Ready') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="relay_ready-alarm" :fieldLabel="__('app.alarm')" 
                                    fieldName="relay_ready"
                                    fieldValue="Alarm"
                                    :checked="($aset->relay_ready == 'Alarm') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6"> 
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.relay_display')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="relay_display-normal" :fieldLabel="__('app.normal')" 
                                    fieldName="relay_display"
                                    fieldValue="Normal" :checked="($aset->relay_display == 'Normal') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="relay_display-blank" :fieldLabel="__('app.blank')" 
                                fieldName="relay_display"
                                fieldValue="Blank"
                                    :checked="($aset->relay_display == 'Blank') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-12 col-md-12">
                        <div class="row ">
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                        <x-forms.label class="my-3" fieldId="hourly_rate"
                                            :fieldLabel="__('modules.inspeksi.relay_mr')"></x-forms.label>
                                        <x-forms.input-group>
                                            <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                            value="{{ $aset->relay_mr ?? '' }}" name="relay_mr"
                                            id="relay_mr"> 
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot>
                                        </x-forms.input-group>    
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                    <x-forms.label class="my-3" fieldId="relay_ms"
                                            :fieldLabel="__('modules.inspeksi.relay_ms')"></x-forms.label>
                                        <x-forms.input-group>
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot>  
                                        <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                        value="{{ $aset->relay_ms ?? '' }}" name="relay_ms"
                                        id="relay_ms">  
                                    </x-forms.input-group>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                    <x-forms.label class="my-3" fieldId="relay_mt"
                                            :fieldLabel="__('modules.inspeksi.relay_mt')"></x-forms.label>
                                        <x-forms.input-group>
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot> 
                                        <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                        value="{{ $aset->relay_mt ?? '' }}" name="relay_mt"
                                        id="relay_mt">  
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6"> 
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.pm_display')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="pm_display-normal" :fieldLabel="__('app.normal')" 
                                    fieldName="pm_display"
                                    fieldValue="Normal" :checked="($aset->pm_display == 'Normal') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="pm_display-blank" :fieldLabel="__('app.blank')" 
                                fieldName="pm_display"
                                fieldValue="Blank"
                                    :checked="($aset->pm_display == 'Blank') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-12 col-md-12">
                        <div class="row ">
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                        <x-forms.label class="my-3" fieldId="pm_mr"
                                            :fieldLabel="__('modules.inspeksi.pm_mr')"></x-forms.label>
                                        <x-forms.input-group>
                                            <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                            value="{{ $aset->pm_mr ?? '' }}" name="pm_mr"
                                            id="pm_mr"> 
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot>
                                        </x-forms.input-group>    
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                    <x-forms.label class="my-3" fieldId="pm_ms"
                                            :fieldLabel="__('modules.inspeksi.pm_ms')"></x-forms.label>
                                        <x-forms.input-group>
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot>  
                                        <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                        value="{{ $aset->pm_ms ?? '' }}" name="pm_ms"
                                        id="pm_ms">  
                                    </x-forms.input-group>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4"> 
                                <div class="form-group my-3">
                                    <x-forms.label class="my-3" fieldId="pm_mt"
                                            :fieldLabel="__('modules.inspeksi.pm_mt')"></x-forms.label>
                                        <x-forms.input-group>
                                            <x-slot name="append">
                                                <span
                                                    class="input-group-text f-14 bg-white-shade">A</span>
                                            </x-slot> 
                                        <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                        value="{{ $aset->pm_mt ?? '' }}" name="pm_mt"
                                        id="pm_mt">  
                                    </x-forms.input-group>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6"> 
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.kwh_meter')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="kwh_meter-normal" :fieldLabel="__('app.normal')" 
                                    fieldName="kwh_meter"
                                    fieldValue="Normal" :checked="($aset->kwh_meter == 'Normal') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="kwh_meter-blank" :fieldLabel="__('app.blank')" 
                                fieldName="kwh_meter"
                                fieldValue="Blank"
                                    :checked="($aset->kwh_meter == 'Blank') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.rtu')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.panel_rtu')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="panel_rtu-bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="panel_rtu"
                                    fieldValue="Bersih" :checked="($aset->panel_rtu == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="panel_rtu-kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="panel_rtu"
                                    fieldValue="Kotor"
                                    :checked="($aset->panel_rtu == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.door')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="door-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="door"
                                    fieldValue="Ada" :checked="($aset->door == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="door-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="door"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->door == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.fan')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="fan-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="fan"
                                    fieldValue="Ada" :checked="($aset->fan == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="fan-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="fan"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->fan == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.lampu_panel')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="lampu_panel-nyala" :fieldLabel="__('app.nyala')" 
                                    fieldName="lampu_panel"
                                    fieldValue="Nyala" :checked="($aset->lampu_panel == 'Nyala') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="lampu_panel-mati" :fieldLabel="__('app.mati')" 
                                    fieldName="lampu_panel"
                                    fieldValue="Mati"
                                    :checked="($aset->lampu_panel == 'Mati') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.grounding_rtu')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="grounding_rtu-ada" :fieldLabel="__('app.ada')" 
                                    fieldName="grounding_rtu"
                                    fieldValue="Ada" :checked="($aset->grounding_rtu == 'Ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="grounding_rtu-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="grounding_rtu"
                                    fieldValue="Tidak Ada"
                                    :checked="($aset->grounding_rtu == 'Tidak Ada') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>  
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.temp_panel')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="temp_panel-baik" :fieldLabel="__('app.baik')" 
                                    fieldName="temp_panel"
                                    fieldValue="Baik" :checked="($aset->temp_panel == 'Baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="temp_panel-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="temp_panel"
                                    fieldValue="Tidak Baik"
                                    :checked="($aset->temp_panel == 'Tidak Baik') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>  
                </div>
                <h4 class="mb-0 p-20 f-21 font-weight-normal text-capitalize border-bottom-grey">
                    @lang('modules.inspeksi.rtucon')</h4>
                <div class="row p-20"> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.kebersihan')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="kebersihan-bersih" :fieldLabel="__('app.bersih')" 
                                    fieldName="kebersihan"
                                    fieldValue="Bersih" :checked="($aset->panel_rtu == 'Bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="kebersihan-kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="kebersihan"
                                    fieldValue="Kotor"
                                    :checked="($aset->kebersihan == 'Kotor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.power_on')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="power_on-nyala" :fieldLabel="__('app.nyala')" 
                                    fieldName="power_on"
                                    fieldValue="Nyala" :checked="($aset->power_on == 'Nyala') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="power_on-mati" :fieldLabel="__('app.mati')" 
                                    fieldName="power_on"
                                    fieldValue="Mati"
                                    :checked="($aset->power_on == 'Mati') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.led_txrx')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="led_txrx-kbrg" :fieldLabel="__('app.kbrg')" 
                                    fieldName="led_txrx"
                                    fieldValue="Kedip Bergatian" :checked="($aset->led_txrx == 'Kedip Bergatian') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="led_txrx-mnyl" :fieldLabel="__('app.mnyl')" 
                                    fieldName="led_txrx"
                                    fieldValue="Mati / Nyala"
                                    :checked="($aset->led_txrx == 'Mati / Nyala') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.ethernet')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="ethernet-kencang" :fieldLabel="__('app.kencang')" 
                                    fieldName="ethernet"
                                    fieldValue="Kencang" :checked="($aset->ethernet == 'Kencang') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ethernet-kendor" :fieldLabel="__('app.kendor')" 
                                    fieldName="ethernet"
                                    fieldValue="Kendor"
                                    :checked="($aset->ethernet == 'Kendor') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group my-3"> 
                                <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.keterangan')"
                                :fieldValue="$aset->keterangan" fieldName="keterangan" fieldId="keterangan"
                                :fieldPlaceholder="__('modules.inspeksi.keterangan')">
                            </x-forms.textarea> 
                        </div>
                    </div>
                </div>
                <x-form-actions>
                    <x-forms.button-primary id="save-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('inspeksi-aset.index')" class="border-0">@lang('app.cancel')
                    </x-forms.button-cancel>
                </x-form-actions>
            </div>
        </x-form>

    </div>
</div>

<script src="{{ asset('vendor/jquery/tagify.min.js') }}"></script>
<script>
    $(document).ready(function() {
 

        // var input = document.querySelector('input[name=tags]'),
            // init Tagify script on the above inputs
            //  ;

        $('#save-form').click(function() {
            const url = "{{ route('inspeksi-aset.update', $aset->id_inspeksi_aset) }}";

            $.easyAjax({
                url: url,
                container: '#save-data-form',
                type: "POST",
                disableButton: true,
                blockUI: true,
                buttonSelector: "#save-form",
                file: true,
                data: $('#save-data-form').serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        window.location.href = response.redirectUrl;
                    }
                }
            });
        });
 
        init(RIGHT_MODAL);
    });

    function checkboxChange(parentClass, id) {
        var checkedData = '';
        $('.' + parentClass).find("input[type= 'checkbox']:checked").each(function() {
            checkedData = (checkedData !== '') ? checkedData + ', ' + $(this).val() : $(this).val();
        });
        $('#' + id).val(checkedData);
    }
    function isNumber(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
