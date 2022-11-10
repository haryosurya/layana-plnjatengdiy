 
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
                                    fieldValue="bersih" :checked="($aset->body_cubicle == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="body_cubicle_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldValue="kotor"
                                    fieldName="body_cubicle"
                                    :checked="($aset->body_cubicle == 'kotor') ? 'checked' : ''">
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
                                    fieldValue="bersih" :checked="($aset->lv == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="lv_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="lv"
                                    fieldValue="kotor" 
                                    :checked="($aset->lv == 'kotor') ? 'checked' : ''">
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
                                    fieldValue="bersih" 
                                    :checked="($aset->cb == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="cb_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="cb"
                                    fieldValue="kotor"
                                    :checked="($aset->cb == 'kotor') ? 'checked' : ''" >
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
                                    fieldValue="bersih"
                                    :checked="($aset->busbar == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="busbar_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="busbar"
                                    fieldValue="kotor" 
                                    :checked="($aset->busbar == 'kotor') ? 'checked' : ''">
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
                                    fieldValue="bersih" 
                                    :checked="($aset->power_cable == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="power_cable_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="power_cable"
                                    fieldValue="kotor"
                                    :checked="($aset->power_cable == 'kotor') ? 'checked' : ''" >
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
                                    fieldValue="bersih" 
                                    :checked="($aset->pmt_cb == 'bersih') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="pmt_cb_kotor" :fieldLabel="__('app.kotor')" 
                                    fieldName="pmt_cb"
                                    fieldValue="kotor" 
                                    :checked="($aset->pmt_cb == 'kotor') ? 'checked' : ''">
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
                                    fieldValue="baik" :checked="($aset->announ == 'baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="announ-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="announ"
                                    fieldValue="tidak baik"
                                    :checked="($aset->announ == 'tidak baik') ? 'checked' : ''">
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
                                    fieldValue="baik" :checked="($aset->ind_lamp == 'baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ind_lamp-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ind_lamp"
                                    fieldValue="tidak baik"
                                    :checked="($aset->ind_lamp == 'tidak baik') ? 'checked' : ''">
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
                                    fieldValue="baik" :checked="($aset->ind_volt == 'baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ind_volt-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ind_volt"
                                    fieldValue="tidak baik"
                                    :checked="($aset->ind_volt == 'tidak baik') ? 'checked' : ''">
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
                                    fieldValue="baik" :checked="($aset->ac220 == 'baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ac220-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="ac220"
                                    fieldValue="tidak baik"
                                    :checked="($aset->ac220 == 'tidak baik') ? 'checked' : ''">
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
                                    fieldValue="baik" :checked="($aset->dc110 == 'baik') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="dc110-tbaik" :fieldLabel="__('app.tbaik')" 
                                    fieldName="dc110"
                                    fieldValue="tidak baik"
                                    :checked="($aset->dc110 == 'tidak baik') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->desis == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="desis-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="desis"
                                    fieldValue="tidak ada"
                                    :checked="($aset->desis == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->dengung == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="dengung-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="dengung"
                                    fieldValue="tidak ada"
                                    :checked="($aset->dengung == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->ngeter == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="ngeter-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="ngeter"
                                    fieldValue="tidak ada"
                                    :checked="($aset->ngeter == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->flash == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="flash-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="flash"
                                    fieldValue="tidak ada"
                                    :checked="($aset->flash == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->sangit == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="sangit-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="sangit"
                                    fieldValue="tidak ada"
                                    :checked="($aset->sangit == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="ada" :checked="($aset->amis == 'ada') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="amis-tada" :fieldLabel="__('app.tada')" 
                                    fieldName="amis"
                                    fieldValue="tidak ada"
                                    :checked="($aset->amis == 'tidak ada') ? 'checked' : ''">
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
                                    fieldValue="operasi" :checked="($aset->feeder == 'operasi') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="feeder-tada" :fieldLabel="__('app.cadangan')" 
                                    fieldName="feeder"
                                    fieldValue="cadangan"
                                    :checked="($aset->feeder == 'cadangan') ? 'checked' : ''">
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
                                    fieldValue="berbeban" :checked="($aset->kubikel == 'berbeban') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="kubikel-tada" :fieldLabel="__('app.bertegangan')" 
                                    fieldName="kubikel"
                                    fieldValue="bertegangan"
                                    :checked="($aset->kubikel == 'bertegangan') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.pmt')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="pmt-ada" :fieldLabel="__('app.berbeban')" 
                                    fieldName="pmt"
                                    fieldValue="test posisi" :checked="($aset->pmt == 'test posisi') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="pmt-tada" :fieldLabel="__('app.bertegangan')" 
                                    fieldName="pmt"
                                    fieldValue="service posisi"
                                    :checked="($aset->pmt == 'service posisi') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
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
 
</script>
