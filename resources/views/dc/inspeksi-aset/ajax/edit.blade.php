 
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
