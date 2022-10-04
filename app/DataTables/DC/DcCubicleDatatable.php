<?php

namespace App\DataTables\DC;

use App\Models\Dc_cubicle;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DcCubicleDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query) 
            ->addIndexColumn() 
            ->addColumn('status', function ($row) {
                if ($row['SCB'] == '0' && $row['SCB_INV'] == '0') 
                {
                    $condition = ' <span class="badge badge-success">' . __('app.open')  .'</span>';
                }
                elseif ($row['SCB'] == '1' && $row['SCB_INV'] == '0') 
                {
                    $condition = ' <span class="badge badge-danger">' . __('app.close')  .'</span>'; 
                }
                elseif ($row['SCB'] == '0' && $row['SCB_INV'] == '1') 
                {
                    $condition = ' <span class="badge badge-danger">' . __('app.close')  .'</span>';
                }
                else{
                    $condition = ' <span class="badge badge-success">' . __('app.open')  .'</span>';
                } 
                
                if ($row['SLR'] == '0' && $row['SLR_INV'] == '0') 
                {
                    $lr = ' <span class="badge badge-success">' . __('app.local')  .'</span>' ;
                }
                elseif ($row['SLR'] == '1' && $row['SLR_INV'] == '0') 
                {
                    $lr =' <span class="badge badge-danger">' . __('app.remote')  .'</span>';
                }
                elseif ($row['SLR'] == '0' && $row['SLR_INV'] == '1') 
                { 
                    $lr =' <span class="badge badge-danger">' . __('app.remote')  .'</span>'; 
                }
                elseif ($row['SLR'] == '1' && $row['SLR_INV'] == '1'){
                    $lr = ' <span class="badge badge-success">' . __('app.local')  .'</span>' ; 
                }
                else{
                    $lr = __('app.none') ; 
                }

                if ($row->PD_LEVEL == 'good') {
                    return ' <i class="fa fa-circle mr-1 text-light-green f-10"></i>' . __('app.good')  .' '.$condition.' '.$lr;
                }
                elseif ($row->PD_LEVEL == 'moderate') {
                    return ' <i class="fa fa-circle mr-1 text-yellow f-10"></i>' . __('app.moderate')  .' '.$condition.' '.$lr;
                }
                elseif ($row->PD_LEVEL == 'bad') {
                    return ' <i class="fa fa-circle mr-1 text-red f-10"></i>' . __('app.bad')  .' '.$condition.' '.$lr;
                }
                else {
                    return '<i class="fa fa-circle mr-1 text-dark f-10"></i>' . __('app.none')  .' '.$condition.' '.$lr;
                }
               
            })
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
 
                        $action .= '<a href="' . route('cubicle.show', [$row->id]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
 
        
                $action .= '</div>
                    </div>
                </div>';

                return $action;
            })
            ->addColumn('gi', function ($row) {
                $action =  $row->gardu.' - '.$row->incoming_name ;

                return $action;
            })
            ->rawColumns(['action','status','gi']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/DcCubicleDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_cubicle $model)
    {
        $request = $this->request();
 

        $gardu = $model ->with('dcIncomingFeeder')
            ->withoutGlobalScope('active')
            ->join('dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID', '=', 'dc_cubicle.INCOMING_ID') 
            ->join('dc_apj', 'dc_apj.APJ_ID', 'dc_cubicle.APJ_ID') 
            ->leftJoin('dc_gardu_induk','dc_incoming_feeder.GARDU_INDUK_ID','dc_gardu_induk.GARDU_INDUK_ID') 
             
            ->select(
                'dc_cubicle.OUTGOING_id as id',
                'dc_cubicle.CUBICLE_NAME as name',
                'dc_cubicle.SCB_INV',
                'dc_cubicle.SCB',
                'dc_cubicle.SLR',
                'dc_cubicle.SLR_INV',
                'dc_cubicle.PD_LEVEL',

                'dc_incoming_feeder.NAMA_ALIAS_INCOMING as incoming_name', 
                
                'dc_apj.APJ_NAMA AS APJ_NAMA',
                'dc_apj.APJ_DCC AS dcc',
                'dc_apj.APJ_ALIAS AS dcc_alias', 
                'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK as gardu'
                )
            ;
            if ($request->searchText != '') {
                $gardu = $gardu->where(function ($query) {
                    $query->where('name', 'like', '%' . request('searchText') . '%')
                        ->orWhere('name', 'like', '%' . request('searchText') . '%');
                });
            }
        return $gardu->groupBy('id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dccubicledatatable-table') 
            ->columns($this->getColumns())
            ->minifiedAjax() 
            ->destroy(true)
            // ->orderBy(2)
            ->responsive(true)
            ->serverSide(true)
            ->stateSave(false)
            ->processing(true)
            ->language(__('app.datatable'))
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["dccubicledatatable-table"].buttons().container()
                     .appendTo( "#table-actions")
                 }',
                'fnDrawCallback' => 'function( oSettings ) {
                   //
                   $(".select-picker").selectpicker();
                 }',
            ])
            ->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> ' . trans('app.exportExcel')]));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    { 
            return [ 
                '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => false],
                __('app.id') => ['data' => 'id', 'name' => 'id', 'title' => __('app.id')],
                __('app.name') => ['data' => 'name', 'name' => 'name', 'title' => __('app.name')],
                __('app.status') => ['data' => 'status', 'name' => 'status', 'title' => __('app.status')],
                __('modules.dc.gi') => ['data' => 'gi', 'name' => 'gi', 'title' => __('modules.dc.gi')],
                __('modules.dc.dcc') => ['data' => 'dcc', 'name' => 'dcc', 'title' => __('modules.dc.dcc')],
                // __('modules.dc.apj-nama') => ['data' => 'APJ_NAMA', 'name' => 'APJ_NAMA', 'title' => __('modules.dc.apj-nama')],
                // __('modules.dc.gardu') => ['data' => 'gardu', 'name' => 'gardu', 'title' => __('modules.dc.gardu')],
                // __('modules.dc.incoming-name') => ['data' => 'incoming_name', 'name' => 'incoming_name', 'title' => __('modules.dc.incoming-name')],
                // __('modules.dc.GARDU_INDUK_KODE') => ['data' => 'GARDU_INDUK_KODE', 'name' => 'GARDU_INDUK_KODE', 'title' => __('modules.dc.GARDU_INDUK_KODE')],
                // __('modules.dc.GARDU_INDUK_RTU_ID') => ['data' => 'GARDU_INDUK_RTU_ID', 'name' => 'GARDU_INDUK_RTU_ID', 'title' => __('modules.dc.GARDU_INDUK_RTU_ID')], 
                // __('modules.dc.GARDU_INDUK_ALIAS') => ['data' => 'GARDU_INDUK_ALIAS', 'name' => 'GARDU_INDUK_ALIAS', 'title' => __('modules.dc.GARDU_INDUK_ALIAS')],
                // __('modules.dc.GARDU_INDUK_ALIAS_ROPO') => ['data' => 'GARDU_INDUK_ALIAS_ROPO', 'name' => 'GARDU_INDUK_ALIAS_ROPO', 'title' => __('modules.dc.GARDU_INDUK_ALIAS_ROPO')],
                // __('modules.dc.GARDU_INDUK_ALAMAT') => ['data' => 'GARDU_INDUK_ALAMAT', 'name' => 'GARDU_INDUK_ALAMAT', 'title' => __('modules.dc.GARDU_INDUK_ALAMAT')],
                // __('modules.dc.UPT_ID') => ['data' => 'UPT_ID', 'name' => 'UPT_ID', 'title' => __('modules.dc.UPT_ID')],
                    // 'dc_apj.APJ_NAMA AS APJ_NAMA',
                    // 'dc_gardu_induk.GARDU_INDUK_NAMA',
                    // 'dc_gardu_induk.GARDU_INDUK_KODE',
                    // 'dc_gardu_induk.GARDU_INDUK_RTU_ID',
                    // 'dc_gardu_induk.GARDU_INDUK_ALIAS',
                    // 'dc_gardu_induk.GARDU_INDUK_ALIAS_ROPO',
                    // 'dc_gardu_induk.GARDU_INDUK_ALAMAT',
                    /* 
                    'dc_gardu_induk.UPT_ID',
                    'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK',
                    'dc_gardu_induk.PEMELIHARAAN_GI',
                    'dc_gardu_induk.BATAS_TEGANGAN_BAWAH',
                    'dc_gardu_induk.BATAS_TEGANGAN_ATAS' */  
                Column::computed('action', __('app.action'))
                    ->exportable(false)
                    ->printable(false)
                    ->orderable(false)
                    ->searchable(false)
                    ->addClass('text-right pr-20')
            ]; 
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DC/DcCubicle_' . date('YmdHis');
    }
}
