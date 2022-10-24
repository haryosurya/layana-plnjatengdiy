<?php

namespace App\DataTables\DC;

use App\Models\Dc_cubicle;
use App\Models\Sm_meter_gi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SmMeterGiDatatable extends DataTable
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
            ->addColumn('cubicle', function($row){
                $data = Dc_cubicle::where('OUTGOING_ID',$row->OUTGOING_ID)->first();
                $cubicle ='<a href="' . route('cubicle.show', [$row->OUTGOING_METER_ID]) . '"><i class="fa fa-circle mr-1 text-light-green f-10"></i> '. $data->CUBICLE_NAME.'</a> ';
                return $cubicle;
            }
            )
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->OUTGOING_METER_ID . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->OUTGOING_METER_ID . '" tabindex="0">';
 
                        $action .= '<a href="' . route('cubicle.show', [$row->OUTGOING_METER_ID]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
 
        
                $action .= '</div>
                    </div>
                </div>';

                return $action;
            })
            ->rawColumns(['action','cubicle']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/SmMeterGiDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sm_meter_gi $model)
    {
        $request = $this->request(); 
        $model = $model->with('OUTGOING_ID')
        ->newQuery();
        if ( $request->searchText != '' && $request->searchText  !== null &&  $request->searchText  != 'null') {
            $model = $model->join('dc_cubicle','dc_cubicle.OUTGOING_ID','sm_meter_gi.OUTGOING_ID');
            $model = $model->where(function ($query) {
                $query->where('CUBICLE_NAME',  'like', '%' . request('searchText') . '%');
            });
        }
        if ($request->OUTGOING_ID != '' && $request->OUTGOING_ID  !== null &&  $request->OUTGOING_ID  != 'null') {
            $model = $model-> join('dc_cubicle','dc_cubicle.OUTGOING_ID','sm_meter_gi.OUTGOING_ID');
            $model = $model->where(function ($query) {
                $query->where('OUTGOING_ID',  request('OUTGOING_ID') );
            });
        }
        return $model;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('smmetergidatatable-table')
        ->columns($this->getColumns())
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->orderBy(2)
        ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>") 
        ->destroy(true)
        ->responsive(true)
        ->serverSide(true)
        ->stateSave(true)
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
                window.LaravelDataTables["smmetergidatatable-table"].buttons().container()
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
            __('app.id') => ['data' => 'OUTGOING_METER_ID', 'name' => 'OUTGOING_METER_ID', 'visible' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false ], 
            // Column::make('OUTGOING_METER_ID'),
            Column::make('cubicle'),
            // Column::make('OUTGOING_ID'),
            Column::make('IA'),
            Column::make('IA_TIME'),
            Column::make('IB'),
            Column::make('IB_TIME'),
            Column::make('IC'),
            Column::make('IC_TIME'),
            Column::make('IN'),
            Column::make('IN_TIME'),
            Column::make('VLL'),
            Column::make('VLL_TIME'),
            Column::make('KW'),
            Column::make('KW_TIME'),
            Column::make('PF'),
            Column::make('PF_TIME'),
            Column::make('IFA'),
            Column::make('IFA_TIME'),
            Column::make('IFB'),
            Column::make('IFB_TIME'),
            Column::make('IFC'),
            Column::make('IFC_TIME'),
            Column::make('IFN'),
            Column::make('IFN_TIME'),
            
            
            // Column::computed('action', __('app.action'))
            // ->exportable(false)
            // ->printable(false)
            // ->orderable(false)
            // ->searchable(false)
            // ->addClass('text-right pr-20')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DC/SmMeterGi_' . date('YmdHis');
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
