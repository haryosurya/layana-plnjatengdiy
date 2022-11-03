<?php

namespace App\Traits;

use App\Models\DashboardWidget;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use App\Models\Dc_operasi_pmt_scada;
use App\Models\ews_freq;
use App\Models\ews_inspeksi_pd;
use App\Models\Lead;
use App\Models\Leave;
use App\Models\Payment;
use App\Models\ProjectActivity;
use App\Models\ProjectTimeLog;
use App\Models\sm_material_panel;
use App\Models\Task;
use App\Models\TaskboardColumn;
use App\Models\Ticket;
use App\Models\User;
use App\Models\UserActivity;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Rainwater\Active\Active;
use Stevebauman\Location\Facades\Location;
/**
 *
 */
trait OverviewDashboard
{

    /**
     *
     * @return void
     */
    public function overviewDashboard()
    { 
        $this->activeUserCount = Active::users()->count();
        $this->activeUser = Active::users()->get();
        $this->startDate  = (request('startDate') != '') ? Carbon::createFromFormat($this->global->date_format, request('startDate')) : now($this->global->timezone)->startOfMonth();
        $this->endDate = (request('endDate') != '') ? Carbon::createFromFormat($this->global->date_format, request('endDate')) : now($this->global->timezone);
        $startDate = $this->startDate->toDateString();
        $endDate = $this->endDate->toDateString();
        $this->counts = DB::table('users')
        ->select( 
            DB::raw('(select count(users.id) from `users` inner join role_user on role_user.user_id=users.id inner join roles on roles.id=role_user.role_id WHERE roles.name = "employee" and users.status = "active") as totalEmployees') 
        )
        ->first();
        $this->totalEmployee = User::count();
        // Total MW didapat dari table dc_cubicle, dengan mengalikan colom VLL x Rata-rata(IA,IB,IC)
        $this->vll = Dc_cubicle::sum('VLL'); 
        $this->hum = ews_freq::where('freq_time','!=','')->orderBy('freq_time', 'DESC')->first(); 
        $this->mw = Dc_cubicle::avg('IA','IB','IC');  
        $this->total_records_all = Dc_cubicle::count(); 
        $this->total_records_level = Dc_cubicle::
            where('PD_LEVEL','good') 
            ->orWhere('PD_LEVEL','moderate') 
            ->orWhere('PD_LEVEL','bad') 
            ->count(); 
        $this->pd_level_good = Dc_cubicle::where('PD_LEVEL','good')->count() ;
        $this->pd_level_mod = Dc_cubicle::where('PD_LEVEL','moderate')->count();
        $this->pd_level_bad = Dc_cubicle::where('PD_LEVEL','bad')->count() ; 
        $this->totalOutgoing =  Dc_cubicle::count(); 
        $this->totalIncoming = Dc_incoming_feeder::count();
        $this->totalGardu = Dc_gardu_induk::count();
        $this->countSmoke = sm_material_panel::count(); 
        $this->bebanRealtime = Dc_cubicle::
            where('OPERATION_TYPE', '=', '1') 
            ->groupBy('OUTGOING_ID')
            ->count()
            ; 
        $this->bebanRealtimeGardu = Dc_cubicle:: 
            where(function($query){
                return $query
                ->where('SCB','=','1')
                ->where('SCB_INV', '=', '0');
            })
            ->orWhere(function($query){
                return $query
                ->where('SCB','=','0')
                ->where('SCB_INV', '=', '1');
            })
            ->join('dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID') 
            ->leftJoin('dc_gardu_induk','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID')  
            ->groupBy('dc_incoming_feeder.GARDU_INDUK_ID')->count()
            ; 
        $m = now()->month;
        $y = now()->year;
        $this->rekap_gangguan = Dc_operasi_pmt_scada::whereMonth('TGL_OPERASI_PMT','=', $m)->whereYear('TGL_OPERASI_PMT','=', $y)->count();

        $this->rekap_gangguan2 = Dc_operasi_pmt_scada::whereMonth('TGL_OPERASI_PMT','=', $m)->whereYear('TGL_OPERASI_PMT','=', $y)
                ->select('APJ_ID')
                ->groupBy('APJ_ID') 
                ->count();
        $this->smokecount = sm_material_panel::
            join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','sm_material_panel.GARDU_INDUK_ID')
            ->leftJoin('dc_apj','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')
            ->distinct()
            ->count('dc_apj.APJ_ID');

        // $this->projectActivities = ProjectActivity::with('project')
        // ->join('projects', 'projects.id', '=', 'project_activity.project_id')
        // ->whereNull('projects.deleted_at')->select('project_activity.*')
        // ->limit(15)->orderBy('project_activity.id', 'desc')->groupBy('project_activity.id')->get();
        $this->EwsInspeksiPD = ews_inspeksi_pd::with('Cubicle')
        ->join('dc_cubicle','dc_cubicle.OUTGOING_ID', 'ews_inspeksi_pd.id_outgoing')   
        ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID', 'ews_inspeksi_pd.id_gardu_induk')
        ->join('users','users.id', 'ews_inspeksi_pd.id_user')
        ->limit(15)
        ->orderBy('ews_inspeksi_pd.id_inspeksi_pd', 'desc')
        ->groupBy('ews_inspeksi_pd.id_inspeksi_pd')
        ->select(
            'ews_inspeksi_pd.*',
            'dc_cubicle.OUTGOING_ID as OUTGOING_ID',
            'dc_cubicle.CUBICLE_NAME as name',
            'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK as gardu_name',
            'users.name as operator'
            )
        ->get();


    $this->view = 'dashboard.ajax.overview';
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    // public function 
    public function earningChart($startDate, $endDate)
    {
        $payments = Payment::join('currencies', 'currencies.id', '=', 'payments.currency_id')->where('status', 'complete');

        $payments = $payments->where(DB::raw('DATE(payments.`paid_on`)'), '>=', $startDate);

        $payments = $payments->where(DB::raw('DATE(payments.`paid_on`)'), '<=', $endDate);

        $payments = $payments->orderBy('paid_on', 'ASC')
            ->get([
                DB::raw('DATE_FORMAT(paid_on,"%d-%M-%y") as date'),
                DB::raw('YEAR(paid_on) year, MONTH(paid_on) month'),
                DB::raw('amount as total'),
                'currencies.id as currency_id',
                'currencies.exchange_rate'
            ]);

        $incomes = [];

        foreach ($payments as $invoice) {
            if (!isset($incomes[$invoice->date])) {
                $incomes[$invoice->date] = 0;
            }

            if ($invoice->currency_id != $this->global->currency->id && $invoice->exchange_rate != 0) {
                $incomes[$invoice->date] += floor($invoice->total / $invoice->exchange_rate);

            } else {
                $incomes[$invoice->date] += round($invoice->total, 2);
            }
        }

        $dates = array_keys($incomes);
        $graphData = [];

        foreach ($dates as $date) {
            $graphData[] = [
                'date' => $date,
                'total' => isset($incomes[$date]) ? round($incomes[$date], 2) : 0,
            ];
        }

        usort($graphData, function ($a, $b) {
            $t1 = strtotime($a['date']);
            $t2 = strtotime($b['date']);
            return $t1 - $t2;
        });

        // return $graphData;
        $graphData = collect($graphData);

        $data['labels'] = $graphData->pluck('date');
        $data['values'] = $graphData->pluck('total')->toArray();
        $data['colors'] = [$this->appTheme->header_color];
        $data['name'] = __('app.earnings');

        return $data;
    }

    /**
     * XXXXXXXXXXX
     *
     * @return \Illuminate\Http\Response
     */
    public function timelogChart($startDate, $endDate)
    {
        $timelogs = ProjectTimeLog::whereDate('start_time', '>=', $startDate)
            ->whereDate('end_time', '<=', $endDate);
        $timelogs = $timelogs->where('project_time_logs.approved', 1);
        $timelogs = $timelogs->groupBy('date')
            ->orderBy('start_time', 'ASC')
            ->get([
                DB::raw('DATE_FORMAT(start_time,\'%d-%M-%y\') as date'),
                DB::raw('FLOOR(sum(total_minutes/60)) as total_hours')
            ]);
        $data['labels'] = $timelogs->pluck('date');
        $data['values'] = $timelogs->pluck('total_hours')->toArray();
        $data['colors'] = [$this->appTheme->header_color];
        $data['name'] = __('modules.dashboard.totalHoursLogged');
        return $data;
    }

}
