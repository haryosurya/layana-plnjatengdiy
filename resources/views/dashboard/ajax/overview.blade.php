<script src="{{ asset('vendor/jquery/frappe-charts.min.iife.js') }}"></script>

<div class="row"> 
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalEmployees')" :value="$counts->totalEmployees"
                    icon="user" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <a href="{{ route('employees.index') }}">
                <x-cards.widget :title="__('modules.dashboard.LoggedIn')" :value="$counts->totalEmployees"
                    icon="user" />
            </a>
        </div>   
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalGardu')" :value="$totalGardu"
                    icon="layer-group" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalIncoming')" :value="$totalIncoming"
                    icon="layer-group" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalCubicle')" :value="$total_records_all"
                    icon="layer-group" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalCubicle')" :value="$total_records_all"
                    icon="layer-group" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.vll')" :value="round($vll*$mw,0)"
                    icon="layer-group" /> 
        </div>   
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.bebanRealtime')" :value="$bebanRealtime"
                    icon="layer-group" /> 
        </div>   
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.RekapGangguan')" :value="$rekap_gangguan"
                    icon="layer-group" /> 
        </div>   
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.hum')" :value="round($hum->freq??'',0)"
                    icon="layer-group" /> 
        </div>        
        <div class="col-xl-6 col-lg-6 col-md-6 mb-3"> 
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-4 mb-3"> 
                    <x-cards.widget :title="__('modules.dashboard.good')" :value="round($pd_level_good,2)"
                        icon="clock" /> 
                </div> 
                <div class="col-xl-4 col-lg-4 col-md-4 mb-3"> 
                    <x-cards.widget :title="__('modules.dashboard.moderate')" :value="round($pd_level_mod,2)"
                        icon="clock" /> 
                </div> 
                <div class="col-xl-4 col-lg-4 col-md-4 mb-3"> 
                    <x-cards.widget :title="__('modules.dashboard.bad')" :value="round($pd_level_bad,2)"
                        icon="clock" /> 
                </div> 
            </div>
        </div>    
    </div>
    <div class="row">  
    </div>
    <div class="row"> 
        <div class="col-sm-12 col-lg-6 mt-3">
            <x-cards.data :title="__('app.menu.inspeksi-pd')" >
                <x-table>
                    @forelse($EwsInspeksiPD as $key=>$inspeksi)
                        {{-- <div class="card border-0 b-shadow-4 p-20 rounded-0">
                            <div class="card-horizontal">
                                <div class="card-header m-0 p-0 bg-white rounded">
                                    <x-date-badge :month="$inspeksi->tgl_entry->format('M')"
                                        :date=" Carbon\Carbon::parse($inspeksi->tgl_entry)->timezone($global->timezone)->format('d')" />
                                </div>
                                <div class="card-body border-0 p-0 ml-3">
                                    <h4 class="card-title f-14 font-weight-normal text-capitalize mb-0">
                                        {!! __($inspeksi->name) !!}
                                    </h4>
                                    <p class="card-text f-12 text-dark-grey">
                                        <a href="{{ route('cubicle.show', $inspeksi->id_outgoing) }}"
                                            class="text-lightest font-weight-normal text-capitalize f-12">{{ ucwords($inspeksi->name) }}
                                        </a>
                                        <br>
                                        {{ $inspeksi->gardu_name }}
                                    </p>
                                </div>
                            </div>
                        </div> --}}
                        <tr>
                            <td class="pl-20">
                                <h5 class="f-13 text-darkest-grey"><a href="{{ route('cubicle.show', [$inspeksi->id_outgoing]) }}"
                                        class="openRightModal">{{$inspeksi->name}}</a></h5>
                                <div class="text-muted">{{$inspeksi->gardu_name ?? '' }}</div>
                            </td>
                            <td> 
                                <div class="taskEmployeeImg rounded-circle mr-1">
                                    <a href="{{ route('employees.show', $inspeksi->operator) }}">
                                        <img data-toggle="tooltip"
                                            data-original-title="{{ ucwords($inspeksi->user->name) }}"
                                            src="{{ $inspeksi->user->image_url }}">
                                    </a>
                                </div> 
                            </td>
                            <td width="15%">@if(!is_null($inspeksi->tgl_entry)) {{ $inspeksi->tgl_entry->format($global->date_format) }} @else -- @endif</td>
                            <td class="f-14" width="20%">
                                @php
                                    if ($inspeksi->level_pd == 'good') {
                                        $level_pd = 'green';
                                    } elseif ($inspeksi->level_pd == 'moderate') {
                                        $level_pd = 'yellow';
                                    } elseif ($inspeksi->level_pd == 'bad') {
                                        $level_pd = 'red';
                                    } elseif ($inspeksi->level_pd == '') {
                                        $level_pd = 'black';
                                    }
                                @endphp
                                <x-status :style="'color:'.($level_pd)"
                                    :value="$inspeksi->level_pd" />
                            </td>
                        </tr><!-- card end -->
                    @empty
                        <tr>
                            <td colspan="3" class="shadow-none">
                                <x-cards.no-record icon="users" :message="__('messages.noRecordFound')" />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-cards.data>
        </div> 
    </div>
 

<script> 
</script>
