@extends('layouts.app')

@push('datatable-styles')
    @include('sections.daterange_css')
@endpush

@push('styles')
    <style>
        .h-200 {
            height: 340px;
            overflow-y: auto;
        }

        .dashboard-settings {
            width: 600px;
        }

        @media (max-width: 768px) {
            .dashboard-settings {
                width: 300px;
            }
        }

    </style>
@endpush
 
@section('content')
 
    <!-- CONTENT WRAPPER START -->
    <div class="px-4 py-0 py-lg-5  border-top-0 admin-dashboard">
 
        @include($view)
    </div>
    <!-- CONTENT WRAPPER END -->
@endsection

@push('scripts')
<script src="{{ asset('vendor/jquery/daterangepicker.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        var format = '{{ $global->moment_format }}';
        var startDate = "{{ $startDate->format($global->date_format) }}";
        var endDate = "{{ $endDate->format($global->date_format) }}";
        var picker = $('#datatableRange2');
        var start = moment(startDate, format);
        var end = moment(endDate, format);

        function cb(start, end) {
            $('#datatableRange2').val(start.format('{{ $global->moment_date_format }}') +
                ' @lang("app.to") ' + end.format(
                    '{{ $global->moment_date_format }}'));
            $('#reset-filters').removeClass('d-none');
        }

        $('#datatableRange2').daterangepicker({
            locale: daterangeLocale,
            linkedCalendars: false,
            startDate: start,
            endDate: end,
            ranges: daterangeConfig,
            opens: 'left',
            parentEl: '.dashboard-header'
        }, cb);


        $('#datatableRange2').on('apply.daterangepicker', function(ev, picker) {
            showTable();
        });

    });
</script>


<script>
    $(".dashboard-header").on("click", ".ajax-tab", function(event) {
        event.preventDefault();

        $('.project-menu .p-sub-menu').removeClass('active');
        $(this).addClass('active');

        var dateRangePicker = $('#datatableRange2').data('daterangepicker');
        var startDate = $('#datatableRange').val();

        if (startDate == '') {
            startDate = null;
            endDate = null;
        } else {
            startDate = dateRangePicker.startDate.format('{{ $global->moment_date_format }}');
            endDate = dateRangePicker.endDate.format('{{ $global->moment_date_format }}');
        }

        const requestUrl = this.href;

        $.easyAjax({
            url: requestUrl,
            blockUI: true,
            container: ".admin-dashboard",
            historyPush: true,
            data: {
                startDate: startDate,
                endDate: endDate
            },
            blockUI: true,
            success: function(response) {
                if (response.status == "success") {
                    $('.admin-dashboard').html(response.html);
                    init('.admin-dashboard');
                }
            }
        });
    });

    $('.keep-open .dropdown-menu').on({
        "click": function(e) {
            e.stopPropagation();
        }
    });

    function showTable() {
        var dateRangePicker = $('#datatableRange2').data('daterangepicker');
        var startDate = $('#datatableRange').val();

        if (startDate == '') {
            startDate = null;
            endDate = null;
        } else {
            startDate = dateRangePicker.startDate.format('{{ $global->moment_date_format }}');
            endDate = dateRangePicker.endDate.format('{{ $global->moment_date_format }}');
        }

        const requestUrl = this.href;

        $.easyAjax({
            url: requestUrl,
            blockUI: true,
            container: ".admin-dashboard",
            data: {
                startDate: startDate,
                endDate: endDate
            },
            blockUI: true,
            success: function(response) {
                if (response.status == "success") {
                    $('.admin-dashboard').html(response.html);
                    init('.admin-dashboard');
                }
            }
        });
    }
</script>
@endpush
