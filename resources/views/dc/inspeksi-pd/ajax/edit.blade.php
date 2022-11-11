@php
$addDesignationPermission = user()->permission('add_designation');
$addDepartmentPermission = user()->permission('add_department');
@endphp

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
                 
                <div class="row p-20">
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.lpd')</label>
                            <div class="d-flex">
                                <x-forms.radio fieldId="level_pd-good" :fieldLabel="__('app.good')" 
                                    fieldName="level_pd"
                                    fieldValue="good" :checked="($pd->level_pd == 'good') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="level_pd-moderate" :fieldLabel="__('app.moderate')" 
                                    fieldName="level_pd"
                                    fieldValue="moderate"
                                    :checked="($pd->level_pd == 'moderate') ? 'checked' : ''">
                                </x-forms.radio>
                                <x-forms.radio fieldId="level_pd-bad" :fieldLabel="__('app.bad')" 
                                    fieldName="level_pd"
                                    fieldValue="bad"
                                    :checked="($pd->level_pd == 'bad') ? 'checked' : ''">
                                </x-forms.radio>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group my-3">
                            <x-forms.label class="my-3" fieldId="citicality"
                                :fieldLabel="__('modules.inspeksi.cpd')"></x-forms.label>
                            <x-forms.input-group>
                                <input onkeypress="return isNumber(event)" type="number" step=".01" min="0" class="form-control height-35 f-14"
                                value="{{ $pd->citicality ?? '' }}" name="citicality"
                                id="citicality"> 
                                <x-slot name="append">
                                    <span
                                        class="input-group-text f-14 bg-white-shade">A</span>
                                </x-slot>
                            </x-forms.input-group>    
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group my-3"> 
                                <x-forms.textarea class="mr-0 mr-lg-2 mr-md-2" :fieldLabel="__('app.keterangan')"
                                :fieldValue="$pd->keterangan" fieldName="keterangan" fieldId="keterangan"
                                :fieldPlaceholder="__('modules.inspeksi.keterangan')">
                            </x-forms.textarea> 
                        </div>
                    </div>
                </div>
  
                <x-form-actions>
                    <x-forms.button-primary id="save-form" class="mr-3" icon="check">@lang('app.save')
                    </x-forms.button-primary>
                    <x-forms.button-cancel :link="route('inspeksi-pd.index')" class="border-0">@lang('app.cancel')
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
            const url = "{{ route('inspeksi-pd.update', $pd->id_inspeksi_pd) }}";

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
