<script src="{{ asset('vendor/jquery/frappe-charts.min.iife.js') }}"></script>

<div class="row"> 
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3"> 
                <x-cards.widget :title="__('modules.dashboard.totalEmployees')" :value="$counts->totalEmployees"
                    icon="user" /> 
        </div>  
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <a href="{{ route('employees.index') }}">
                <x-cards.widget :title="__('modules.dashboard.LoggedIn')" :value="$activeUserCount"
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
        <div class="col-sm-12 col-lg-6 mt-3">
            <x-cards.data :title="__('modules.dashboard.recentLoginActivities')" >
                <x-table> 
                    <th>
                        <td>Name</td>
                        <td>Login</td>
                        <td>location</td>
                        <td>Browser</td>
                    </th>
                    @forelse($activeUser as $activity) 
                        <tr> 
                            <td> 
                                <div class="taskEmployeeImg rounded-circle mr-1">
                                    <img data-toggle="tooltip"
                                        data-original-title="{{ ucwords($activity->user->name) }}"
                                        src="{{ $activity->user->image_url }}">
                                </div> 
                                <span>
                                    <h5 class="f-13 text-darkest-grey"><a href="{{ route('employees.show', [$activity->user->id]) }}"
                                        class="openRightModal">{{$activity->user->name}}</a></h5>
                                            <div class="text-muted">{{$activity->user->employeeDetails->designation->name ?? '' }}</div>
                                </span>
                            </td> 
                            <td >@if(!is_null($activity->last_activity)) {{date("Y-m-d H:i:s", $activity->last_activity) }} @else -- @endif</td>
                                @if ($activity->ip_address != '127.0.0.1')
                                    @php 
                                        $location =  objetToArray(\Location::get($activity->ip_address));  
                                        $city = $location['cityName'];
                                        // $city = implode($location); 
                                    @endphp 
                                @else
                                    @php                                   
                                        $city = '';
                                    @endphp 
                                @endif
                            <td >@if(!is_null($activity->ip_address)) {{ $activity->ip_address}} -> {{ $city }} @else -- @endif
                            </td>
                            <td >@if(!is_null($activity->last_activity)) {{  $activity->user_agent }} @else -- @endif</td> 
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
    <div class="row"> 
        <div class="col-sm-12 col-lg-6 mt-3">
            <x-cards.data :title="__('app.menu.inspeksi-pd')" >
                <x-table>
                    @forelse($EwsInspeksiPD as $key=>$inspeksi) 
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
