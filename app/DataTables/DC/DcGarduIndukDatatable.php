<?php

namespace App\DataTables\DC;

use App\DataTables\BaseDataTable;
use App\Models\Dc_cubicle;
use App\Models\Dc_gardu_induk;
use App\Models\Dc_incoming_feeder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DcGarduIndukDatatable extends BaseDataTable
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
            ->addColumn('total_trafo', function($row){
                    $result = Dc_incoming_feeder::where('GARDU_INDUK_ID',$row->GARDU_INDUK_ID)->count();
                    return $result;
                } 
            )
            ->addColumn('total_pmt', function($row){
                    $result = Dc_cubicle::
                    join('dc_incoming_feeder','dc_incoming_feeder.INCOMING_ID','dc_cubicle.INCOMING_ID')
                    ->leftJoin('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID','dc_incoming_feeder.GARDU_INDUK_ID') 
                    ->where('dc_gardu_induk.GARDU_INDUK_ID',$row->GARDU_INDUK_ID)->count('OUTGOING_ID');
                    return $result;
                } 
            ) 
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
 

                $action .= '</div>
                    </div>
                </div>';

                return $action;
            })
            ->rawColumns(['action','total_trafo','total_pmt']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DcGarduIndukDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_gardu_induk $model)
    {
        $request = $this->request();
 

        $gardu = $model
            ->withoutGlobalScope('active')
            ->join('dc_apj', 'dc_apj.APJ_ID', '=', 'dc_gardu_induk.APJ_ID') 
            ->select(
                'dc_gardu_induk.GARDU_INDUK_ID',
                'dc_apj.APJ_NAMA AS APJ_NAMA',
                'dc_apj.APJ_DCC AS DCC',
                'dc_gardu_induk.GARDU_INDUK_NAMA',
                'dc_gardu_induk.GARDU_INDUK_KODE',
                'dc_gardu_induk.GARDU_INDUK_RTU_ID',
                'dc_gardu_induk.GARDU_INDUK_ALIAS',
                'dc_gardu_induk.GARDU_INDUK_ALIAS_ROPO',
                'dc_gardu_induk.GARDU_INDUK_ALAMAT',
                'dc_gardu_induk.UPT_ID',
                'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK',
                'dc_gardu_induk.PEMELIHARAAN_GI',
                'dc_gardu_induk.BATAS_TEGANGAN_BAWAH',
                'dc_gardu_induk.BATAS_TEGANGAN_ATAS'
                )
            ;
            if ($request->searchText != '') {
                $gardu = $gardu->where(function ($query) {
                    $query->where('APJ_NAMA', 'like', '%' . request('searchText') . '%')
                        ->orWhere('dc_gardu_induk.GARDU_INDUK_NAMA', 'like', '%' . request('searchText') . '%')
                        ->orWhere('dc_apj.APJ_DCC', 'like', '%' . request('searchText') . '%');
                });
            }
        return $gardu->groupBy('dc_gardu_induk.GARDU_INDUK_ID');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('dcgarduindukdatatable-table') 
            ->columns($this->getColumns())
                    ->minifiedAjax() 
                    ->destroy(true) 
                    ->scrollY("500px")
                    ->scrollX('100%')
                    ->fixedColumns(true)
                    ->scrollCollapse(true)
                    ->fixedColumns( 
                            [
                                'left'=>'2',
                                'right'=>'0'
                            ]
                    ) 
                    ->dom('Bfrtip')
                    ->responsive(true)
                    ->serverSide(true)
                    ->stateSave(false)
                    ->processing(true)
                    ->language(__('app.datatable'))
            ->parameters([
                'initComplete' => 'function () {
                    window.LaravelDataTables["dcgarduindukdatatable-table"].buttons().container()
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
            __('app.id') => ['data' => 'GARDU_INDUK_ID', 'name' => 'GARDU_INDUK_ID', 'title' => __('app.id')],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false, 'visible' => false],
            __('modules.dc.gi') => ['data' => 'GARDU_INDUK_NAMA', 'name' => 'GARDU_INDUK_NAMA', 'title' => __('modules.dc.gi')],
            __('modules.dc.apj-nama') => ['data' => 'APJ_NAMA', 'name' => 'APJ_NAMA', 'title' => __('modules.dc.apj-nama')],
            __('modules.dc.gardu-code') => ['data' => 'GARDU_INDUK_KODE', 'name' => 'GARDU_INDUK_KODE', 'title' => __('modules.dc.gardu-code')],  
            __('modules.dc.dcc') => ['data' => 'DCC', 'name' => 'DCC', 'title' => __('modules.dc.dcc')],
            // Column::make('UPT_ID'),
            // Column::make('GARDU_INDUK_RTU_ID'),
            Column::make('GARDU_INDUK_ALIAS'),
            // Column::make('GARDU_INDUK_ALIAS_ROPO'),
            Column::make('GARDU_INDUK_ALAMAT'),
            Column::make('NAMA_ALIAS_GARDU_INDUK'),
            // Column::make('PEMELIHARAAN_GI'),
            // Column::make('BATAS_TEGANGAN_BAWAH'),
            // Column::make('BATAS_TEGANGAN_ATAS'), 
            __('modules.dc.total-trafo') => ['data' => 'total_trafo', 'name' => 'total_trafo', 'title' => __('modules.dc.total-trafo')], 
            __('modules.dc.total-pmt') => ['data' => 'total_pmt', 'name' => 'total_pmt', 'title' => __('modules.dc.total-pmt')],  
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DcGarduInduk_' . date('YmdHis');
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
