@extends('layouts.app')

@push('datatable-styles')
    @include('sections.datatable_css')
@endpush

@section('filter-section')

    <x-filters.filter-box>
 
 

        <!-- SEARCH BY TASK START -->
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
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white">

            {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}

        </div>
        <!-- Task Box End -->
    </div>
    <!-- CONTENT WRAPPER END -->

@endsection

@push('scripts')
    @include('sections.datatable_js')

    <script> 

        $('#category_id').change(function(e) {
            // get projects of selected users
            var opts = '';

            var subCategory = subCategories.filter(function(item) {
                return item.category_id == e.target.value
            });

            subCategory.forEach(project => {
                opts += `<option value='${project.id}'>${project.category_name}</option>`
            })

            $('#sub_category').html('<option value="all">@lang("app.all")</option>' + opts)
            $("#sub_category").selectpicker("refresh");
        });

        $('#incomingfeederdatatable-table').on('preXhr.dt', function(e, settings, data) {
            var categoryID = $('#category_id').val();
            var subCategoryID = $('#sub_category').val();
            var searchText = $('#search-text-field').val();

            // data['category_id'] = categoryID;
            // data['sub_category_id'] = subCategoryID;
            data['searchText'] = searchText;
        });
        const showTable = () => {
            window.LaravelDataTables["incomingfeederdatatable-table"].draw();
        }
 

        $('#reset-filters').click(function() {
            $('#filter-form')[0].reset();

            $('#category_id').val('all');
            $('.select-picker').val('all');

            $('#sub_category').html('<option value="all">@lang("app.all")</option>');

            $('.select-picker').selectpicker("refresh");
            $('#reset-filters').addClass('d-none');

            showTable();
        });
 

    </script>
@endpush
