<?php

namespace App\DataTables\DC;

use App\Models\Dc_apj;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use App\Models\ews_inspeksi_pd;
use DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DccDatatable extends DataTable
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
            ->addColumn('total_gardu', function($row){
                    $result = Dc_gardu_induk::where('APJ_ID',$row->id)->count();
                    return $result;
                } 
            )
            ->addColumn('total_trafo', function($row){
                    $result = Dc_incoming_feeder::where('APJ_ID',$row->id)->count();
                    return $result;
                } 
            )
            ->addColumn('total_pmt', function($row){
                    $result = Dc_cubicle::where('APJ_ID',$row->id)->count();
                    return $result;
                } 
            )
            ->addColumn('inspeksi-pmt', function ($row) {
                $action ='';
                $pmt = ews_inspeksi_pd::where('id_outgoing',$row->id)
                ->select(
                    DB::raw('(select count(ews_inspeksi_pd.id_inspeksi_pd) from `ews_inspeksi_pd` join dc_cubicle on dc_cubicle.OUTGOING_ID = ews_inspeksi_pd.id_outgoing inner join dc_apj on dc_apj.APJ_ID=dc_cubicle.APJ_ID where dc_apj.APJ_ID=' . $row->id . ' and ews_inspeksi_pd.level_pd="good" ) as good'),
                    DB::raw('(select count(ews_inspeksi_pd.id_inspeksi_pd) from `ews_inspeksi_pd` join dc_cubicle on dc_cubicle.OUTGOING_ID = ews_inspeksi_pd.id_outgoing inner join dc_apj on dc_apj.APJ_ID=dc_cubicle.APJ_ID where dc_apj.APJ_ID=' . $row->id . ' and ews_inspeksi_pd.level_pd="moderate") as moderate'),
                    DB::raw('(select count(ews_inspeksi_pd.id_inspeksi_pd) from `ews_inspeksi_pd` join dc_cubicle on dc_cubicle.OUTGOING_ID = ews_inspeksi_pd.id_outgoing inner join dc_apj on dc_apj.APJ_ID=dc_cubicle.APJ_ID where dc_apj.APJ_ID=' . $row->id . ' and ews_inspeksi_pd.level_pd="bad") as bad')

                )
                ->first()
                ;
                if(!empty($pmt)){
                    $action = '<i class="fa fa-circle mr-1 text-light-green f-10"></i>'.$pmt['good'].' ' . __('app.good')  .' | <i class="fa fa-circle mr-1 text-yellow f-10"></i>'.$pmt->moderate.' ' . __('app.moderate') .' | <i class="fa fa-circle mr-1 text-red f-10"></i>'.$pmt->bad.' ' . __('app.bad');
                    // $action = $pmt['good'];
                }

                return $action;
            })
            // ->addColumn('total_pmt', function($row){
            //         $result = Dc_cubicle::join('dc_incoming_feeder','dc_incoming_feeder.incoming_id','dc_incoming_feeder.incoming_id')
            //         ->where('dc_incoming_feeder.GARDU_INDUK_ID',$row->id)->count();
            //         return $result;
            //     } 
            // )
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
 
                        $action .= '<a href="' . route('employees.show', [$row->id]) . '" class="dropdown-item openRightModal"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';

                        if ($this->editEmployeePermission == 'all'
                            || ($this->editEmployeePermission == 'added' && user()->id == $row->added_by)
                            || ($this->editEmployeePermission == 'owned' && user()->id == $row->id)
                            || ($this->editEmployeePermission == 'both' && (user()->id == $row->id || user()->id == $row->added_by))
                        ) {
                            $action .= '<a class="dropdown-item openRightModal" href="' . route('employees.edit', [$row->id]) . '">
                                        <i class="fa fa-edit mr-2"></i>
                                        ' . trans('app.edit') . '
                                    </a>';
                        }
        
                        if ($this->deleteEmployeePermission == 'all' || ($this->deleteEmployeePermission == 'added' && user()->id == $row->added_by)) {
                            if (user()->id !== $row->id) {
                                $action .= '<a class="dropdown-item delete-table-row" href="javascript:;" data-user-id="' . $row->id . '">
                                        <i class="fa fa-trash mr-2"></i>
                                        ' . trans('app.delete') . '
                                    </a>';
                            }
                        }
        
                $action .= '</div>
                    </div>
                </div>';

                return $action;
            })
            ->rawColumns(['action','total_gardu','total_trafo','total_pmt','inspeksi-pmt']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/DccDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_apj $model)
    { 
        $request = $this->request(); 
        $gardu = $model 
            ->withoutGlobalScope('active')  
            ->join('dc_gardu_induk','dc_apj.APJ_ID','dc_gardu_induk.APJ_ID')  
            ->leftJoin('dc_cubicle','dc_apj.APJ_ID','dc_cubicle.APJ_ID')  
            ->leftJoin('dc_incoming_feeder','dc_apj.APJ_ID','dc_incoming_feeder.APJ_ID')  
            ->selectRaw(
            'dc_apj.APJ_ID as id,
            dc_apj.APJ_NAMA as name,
            dc_apj.APJ_ALIAS as alias,
            dc_apj.APJ_DCC as dcc,
            dc_apj.TELEGRAM_ID as telegram' 
        ); 

        if ($request->searchText != '') {
            $gardu = $gardu->where(function ($query) {
                $query->where('dc_apj.APJ_NAMA', 'like', '%' . request('searchText') . '%')
                    ->orWhere('dc_apj.APJ_DCC', 'like', '%' . request('searchText') . '%');
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
                    ->setTableId('dccdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax() 
                    ->destroy(true) 
                    ->responsive(true)
                    ->serverSide(true)
                    ->stateSave(false)
                    ->processing(true)
                    
                    ->fixedColumns( 
                        [
                            'left'=>'2',
                            'right'=>'0'
                        ]
                    ) 
                    ->language(__('app.datatable'))
                    ->parameters([
                        'initComplete' => 'function () {
                            window.LaravelDataTables["dccdatatable-table"].buttons().container()
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
            __('modules.dc.dcc') => ['data' => 'dcc', 'name' => 'dcc', 'title' => __('modules.dc.dcc')], 
            __('app.name') => ['data' => 'name', 'name' => 'name', 'title' => __('app.name')],
            __('app.aliases') => ['data' => 'alias', 'name' => 'alias', 'title' => __('app.aliases')],
            __('modules.dc.telegram-id') => ['data' => 'telegram', 'name' => 'telegram', 'title' => __('modules.dc.telegram-id')], 
            __('modules.dc.total-gardu') => ['data' => 'total_gardu', 'name' => 'total_gardu', 'title' => __('modules.dc.total-gardu')], 
            __('modules.dc.total-trafo') => ['data' => 'total_trafo', 'name' => 'total_trafo', 'title' => __('modules.dc.total-trafo')], 
            __('modules.dc.total-pmt') => ['data' => 'total_pmt', 'name' => 'total_pmt', 'title' => __('modules.dc.total-pmt')], 
            __('modules.dc.inspeksi-pmt') => ['data' => 'inspeksi-pmt', 'name' => 'inspeksi-pmt', 'title' => __('modules.dc.inspeksi-pmt')],

            // Column::computed('action', __('app.action'))
            //     ->exportable(false)
            //     ->printable(false)
            //     ->orderable(false)
            //     ->searchable(false)
            //     ->addClass('text-right pr-20')
        ]; 
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Dcc_' . date('YmdHis');
    }
    public function pdf()
    {
        set_time_limit(0);

        if ('snappy' == config('datatables-buttons.pdf_generator', 'snappy')) {
            return $this->snappyPdf();
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('datatables::print', ['data' => $this->getDataForPrint()]);

        return $pdf->download($this->getFilename() . '.pdf');
    }
}
