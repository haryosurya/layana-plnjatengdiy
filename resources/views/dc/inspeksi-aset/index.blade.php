@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')


<x-filters.filter-box> 
    <!-- DATE START -->
    <div class="select-box d-flex pr-2 border-right-grey border-right-grey-sm-0">
        <p class="mb-0 pr-3 f-14 text-dark-grey d-flex align-items-center">@lang('app.date')</p>
        <div class="select-status d-flex">
            <input type="text" class="position-relative text-dark form-control border-0 p-2 text-left f-14 f-w-500"
                id="datatableRange" placeholder="@lang('placeholders.dateRange')">
        </div>
    </div>
    <!-- DATE END -->
    <!-- SEARCH BY TASK NAME -->
    <div class="task-search d-flex  py-1 px-lg-3 px-0 border-right-grey align-items-center">
        <form class="w-100 mr-1 mr-lg-0 mr-md-1 ml-md-1 ml-0 ml-lg-0">
            <div class="input-group bg-grey rounded">
                <div class="input-group-prepend">
                    <span class="input-group-text border-0 bg-additional-grey">
                        <i class="fa fa-search f-13 text-dark-grey"></i>
                    </span>
                </div>
                <input type="text" class="form-control f-14 p-1 border-additional-grey" id="search-text-field"
                    placeholder="@lang('app.startTyping')">
            </div>
        </form>
    </div>
    <!-- SEARCH BY TASK END -->

    <!-- RESET START -->
    <div class="select-box d-flex py-1 px-lg-2 px-md-2 px-0">
        <x-forms.button-secondary class="btn-xs d-none" id="reset-filters" icon="times-circle">
            @lang('app.clearFilters')
        </x-forms.button-secondary>
    </div>
    <!-- RESET END -->
    <!-- MORE FILTERS START -->
    <x-filters.more-filter-box> 
        <div class="more-filter-items">
            <label class="f-14 text-dark-grey mb-12 text-capitalize" for="apj">@lang('modules.dc.apj')</label>
            <div class="select-filter mb-4">
                <div class="select-others">
                    <select class="form-control select-picker" name="apj" id="apj" data-container="body">
                        <option value="all">@lang('app.all')</option>
                        @foreach ($dcc as $dcc)  
                                <option value="{{ $dcc->APJ_ID }}">{{ ucfirst($dcc->APJ_NAMA) }}</option> 
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="more-filter-items">
            <label class="f-14 text-dark-grey mb-12 text-capitalize" for="gi">@lang('modules.dc.gi')</label>
            <div class="select-filter mb-4">
                <div class="select-others">
                    <select class="form-control select-picker" name="gi" id="gi" data-container="body"> 
                        <option value="all">@lang('app.all')</option>
                        @foreach ($gi as $gi)  
                                <option value="{{ $gi->GARDU_INDUK_ID }}">{{ ucfirst($gi->GARDU_INDUK_NAMA) }}</option> 
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

    </x-filters.more-filter-box>
</x-filters.filter-box>
  
@endsection

@php
$addProductPermission = user()->permission('add_product');
$addOrderPermission = user()->permission('add_order');
@endphp

@section('content')
    <!-- CONTENT WRAPPER START -->
    <div class="content-wrapper">
        <!-- Add Task Export Buttons Start -->

        <div class="d-flex justify-content-between action-bar">
            <div id="table-actions" class="flex-grow-1 align-items-center">
                @if ($addProductPermission == 'all' || $addProductPermission == 'added')
                    <x-forms.link-primary :link="route('products.create')" class="mr-3 openRightModal float-left"
                        icon="plus">
                        @lang('app.add')
                        @lang('app.product')
                    </x-forms.link-primary>
                @endif
            </div>
  
        </div>

        <!-- Add Task Export Buttons End -->
        <!-- Task Box Start -->
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white table-responsive">

            {!! $dataTable->table(['class' => 'table table-hover toggle-circle default table-bordered border-0 w-100 footable-loaded footable']) !!}

        </div>
        <!-- Task Box End -->
    </div>
    <!-- CONTENT WRAPPER END -->

@endsection

@push('scripts')
    @include('sections.datatable_js') 
    <script> 
        var startDate = null;
        var endDate = null;
        var lastStartDate = null;
        var lastEndDate = null;

        @if(request('startDate') != '' && request('endDate') != '' )
            startDate = '{{ request("startDate") }}';
            endDate = '{{ request("endDate") }}';
        @endif

        @if(request('lastStartDate') !=='' && request('lastEndDate') !=='' )
            lastStartDate = '{{ request("lastStartDate") }}';
            lastEndDate = '{{ request("lastEndDate") }}';
        @endif
        $('#ewsinspeksiasetdatatable-table').on('preXhr.dt', function(e, settings, data) { 
            
            var searchText = $('#search-text-field').val(); 
            var dateRangePicker = $('#datatableRange').data('daterangepicker');
            var startDate = $('#datatableRange').val();
            var apj = $('#apj').val();
            var gi = $('#gi').val();

            if (startDate == '') {
                startDate = null;
                endDate = null;
            } else {
                startDate = dateRangePicker.startDate.format('{{ $global->moment_date_format }}');
                endDate = dateRangePicker.endDate.format('{{ $global->moment_date_format }}');
            }
            
            data['startDate'] = startDate;
            data['endDate'] = endDate; 
            data['apj'] = apj;
            data['gi'] = gi;
            data['searchText'] = searchText;

            if(gi == "all" || apj == "all"  || searchText == ""){
                data['startDate'] = startDate;
                data['endDate'] = endDate;
                data['lastStartDate'] = lastStartDate;
                data['lastEndDate'] = lastEndDate;
            }
        });
        const showTable = () => {
            window.LaravelDataTables["ewsinspeksiasetdatatable-table"].draw();
        }
        $(' #search-text-field').on('change keyup',
            function() {
                if  ($('#search-text-field').val() != "") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else {
                    $('#reset-filters').addClass('d-none');
                    showTable();
                }
            });

        $('#apj, #gi, #search-text-field').on('change keyup',
            function() {
                if ($('#apj').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable(); 
                } else if ($('#gi').val() != "all") {
                    $('#reset-filters').removeClass('d-none');
                    showTable(); 
                } else if ($('#search-text-field').val() != "") {
                    $('#reset-filters').removeClass('d-none');
                    showTable();
                } else {
                    $('#reset-filters').addClass('d-none');
                    showTable();
                }
            });
        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();  
            $('.select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');

            showTable();
        });
 

        $('body').on('click', '.delete-table-row', function() {
            var id = $(this).data('user-id');
            Swal.fire({
                title: "@lang('messages.sweetAlertTitle')",
                text: "@lang('messages.recoverRecord')",
                icon: 'warning',
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: "@lang('messages.confirmDelete')",
                cancelButtonText: "@lang('app.cancel')",
                customClass: {
                    confirmButton: 'btn btn-primary mr-3',
                    cancelButton: 'btn btn-secondary'
                },
                showClass: {
                    popup: 'swal2-noanimation',
                    backdrop: 'swal2-noanimation'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('inspeksi-aset.destroy', ':id') }}";
                    url = url.replace(':id', id);

                    var token = "{{ csrf_token() }}";

                    $.easyAjax({
                        type: 'POST',
                        url: url,
                        blockUI: true,
                        data: {
                            '_token': token,
                            '_method': 'DELETE'
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                showTable();
                            }
                        }
                    });
                }
            });
        });

    </script>
@endpush
