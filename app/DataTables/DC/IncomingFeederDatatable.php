<?php

namespace App\DataTables\DC;

// use App\Models\DC/IncomingFeederDatatable;

use App\DataTables\BaseDataTable;
use App\Models\Dc_incoming_feeder;
use Carbon\Carbon;
use DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncomingFeederDatatable extends BaseDataTable
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
             ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/IncomingFeederDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_incoming_feeder $model)
    { 
        $request = $this->request();
        $dateRange = null;
        $endDate = null; 
        $model = $model->with('dcCubicles', 'dcGarduInduk')
            ->withoutGlobalScope('active')
            ->join('dc_gardu_induk', 'dc_gardu_induk.GARDU_INDUK_ID','=', 'dc_incoming_feeder.GARDU_INDUK_ID')
            ->leftjoin('dc_apj', 'dc_apj.APJ_ID', '=', 'dc_gardu_induk.APJ_ID')
            ->select(
                'dc_incoming_feeder.INCOMING_ID',
                'dc_incoming_feeder.GARDU_INDUK_ID',
                'dc_gardu_induk.GARDU_INDUK_NAMA as gardu',
                'dc_gardu_induk.GARDU_INDUK_ALIAS as alias',
                'dc_apj.APJ_DCC as DCC',
                'dc_apj.APJ_NAMA as NAMA_APJ',
                'dc_incoming_feeder.INCOMING_NAME',
                'dc_incoming_feeder.MERK_TRAFO',
                'dc_incoming_feeder.NAMA_ALIAS_INCOMING',
                'dc_incoming_feeder.DAYA_REAKTIF_TRAFO',
                'dc_incoming_feeder.RASIO_TEGANGAN'
            )
            ; 
        if ($request->searchText != '') {
            $model = $model->where(function ($query) {
                $query->where('dc_incoming_feeder.INCOMING_NAME', 'like', '%' . request('searchText') . '%')
                    ->orWhere('dc_incoming_feeder.NAMA_ALIAS_INCOMING', 'like', '%' . request('searchText') . '%');
            });
        }
        return $model->groupBy('dc_incoming_feeder.INCOMING_ID');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('incomingfeederdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    // ->orderBy(2)
                    ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>") 
                    ->destroy(true)
                    ->responsive(true)
                    ->serverSide(true)
                    ->stateSave(true)
                    ->processing(true)
                    ->language(__('app.datatable'))
                    ->parameters([
                        'initComplete' => 'function () {
                           window.LaravelDataTables["incomingfeederdatatable-table"].buttons().container()
                            .appendTo( "#table-actions")
                        }',
                        'fnDrawCallback' => 'function( oSettings ) {
                            $("body").tooltip({
                                selector: \'[data-toggle="tooltip"]\'
                            })
                        }',
                    ])
                    ->buttons(Button::make(['extend' => 'excel', 'text' => '<i class="fa fa-file-export"></i> ' . trans('app.exportExcel'). '&nbsp;<span class="caret"></span>']));
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            
            __('app.id') => ['data' => 'INCOMING_ID', 'name' => 'INCOMING_ID', 'visible' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false ], 
            Column::make('INCOMING_ID'),  
            Column::make('INCOMING_NAME'),  
            Column::make('NAMA_ALIAS_INCOMING'),  
            Column::make('gardu'),   
            Column::make('NAMA_APJ'),   
            Column::make('DCC'),   
            // __('modules.dc.gi') => ['data' => 'gardu', 'name' => 'gardu', 'title' => __('modules.dc.gi')], 
            // __('modules.dc.gi') => ['data' => 'alias', 'name' => 'alias', 'title' => __('modules.dc.gi')], 
            // Column::make('alias'),  
            Column::make('MERK_TRAFO'),  
            Column::make('DAYA_REAKTIF_TRAFO'),  
            Column::make('RASIO_TEGANGAN'),  
            // Column::computed('action', __('app.action'))
            // ->exportable(false)
            // ->printable(false)
            // ->orderable(false)
            // ->searchable(false) 
            // ->addClass('text-center')

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'IncomingFeeder_' . date('YmdHis');
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
