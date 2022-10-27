 
<!-- ROW START -->
<div class="row py-0 py-md-0 py-lg-3">
    <div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4">
 

        {{-- <x-filters.filter-box> 
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
        </x-filters.filter-box> --}}

        <!-- Task Box Start -->
        <div class="d-flex flex-column w-tables rounded mt-3 bg-white">

            {!! $dataTable->table(['class' => 'table table-hover border-0 w-100']) !!}

        </div>
        <!-- Task Box End -->
    </div>
</div> 
@include('sections.datatable_js')

<script>
    $('#ewsinspeksipddatatable-table').on('preXhr.dt', function(e, settings, data) {
 
        var status = $('#status').val();
        var searchText = $('#search-text-field').val();
        var outgoing = "{{$cubicle->OUTGOING_ID}}";
 
        data['  '] = outgoing;
        data['status'] = status;
        data['searchText'] = searchText;
    });
    const showTable = () => {
        window.LaravelDataTables["ewsinspeksipddatatable-table"].draw();
    } 

  
  
</script>
