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
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.lpd')</label>
                            <div class="d-flex">
                                @php
                                    if ($pd->level_pd  == 'good' && $pd->level_pd  != '') 
                                    {
                                        $pds = '  <i class="fa fa-circle mr-1 text-light-green f-10"></i> <span class="badge badge-success">' . __('app.good')  .'</span>';
                                    }
                                    elseif ($pd->level_pd  == 'moderate' && $pd->level_pd  != '') 
                                    {
                                        $pds =  '<i class="fa fa-circle mr-1 text-yellow f-10"></i> <span class="badge badge-warning">' . __('app.moderate')  .'</span>'; 
                                    }
                                    elseif ($pd->level_pd  == 'bad' && $pd->level_pd  != '') 
                                    {
                                        $pds =  ' <i class="fa fa-circle mr-1 text-red f-10"></i> <span class="badge badge-danger">' . __('app.bad')  .'</span>';
                                    }
                                    else{
                                        $pds =  '';
                                    }  
                                    echo $pds ;
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3">
                            <label class="f-14 text-dark-grey mb-12 w-100"
                                for="usr">@lang('modules.inspeksi.cpd')</label> 
                                <span>
                                    {{ $pd->citicality ?? '' }}
                                </span> 
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group my-3"> 
                            <label class="f-14 text-dark-grey mb-12 w-100"
                            for="usr">@lang('modules.inspeksi.keterangan')</label>
                            <span>
                                {{$pd->keterangan}}
                            </span> 
                        </div>
                    </div> 
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group my-3"> 
                            <label class="f-14 text-dark-grey mb-12 w-100"
                            for="usr">@lang('modules.inspeksi.foto_p')</label> 
                            <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                    @php
                                        $file = json_decode($pd->foto_pelaksanaan); 
                                    @endphp  
                                    <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                        <a href="javascript:;" class="img-lightbox" data-image-url="{{ $file->image_url }}">
                                            <img src="{{ $file->image_url }}" width="200" height="200" class="img-thumbnail">
                                        </a> 
                                    </p>
                            </div> 
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group my-3"> 
                            <label class="f-14 text-dark-grey mb-12 w-100"
                            for="usr">@lang('modules.inspeksi.foto_p')</label> 
                            <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                                @php
                                    $filep = json_decode($pd->foto_pengukuran); 
                                @endphp  
                                <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                                
                                    <a href="javascript:;" class="img-lightbox" data-image-url="{{ $filep->image_url }}">
                                        <img src="{{ $filep->image_url }}" width="200" height="200" class="img-thumbnail">
                                    </a>
                                </p>
                            </div> 
                        </div>
                    </div>
                </div>  
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
