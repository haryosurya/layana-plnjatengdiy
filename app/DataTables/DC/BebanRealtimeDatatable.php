<?php

namespace App\DataTables\DC;

use App\Models\Sm_meter_gi;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BebanRealtimeDatatable extends DataTable
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
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\BebanRealtimeDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Sm_meter_gi $model)
    {
        $request = $this->request();
        $smMeter = $model
            ->withoutGlobalScope('active')
            ->join('dc_cubicle', 'dc_cubicle.OUTGOING_ID', '=', 'sm_meter_gi.OUTGOING_ID') 
            ->select(
            'sm_meter_gi.OUTGOING_METER_ID as id',
            'sm_meter_gi.OUTGOING_ID',
            'sm_meter_gi.IA',
            'sm_meter_gi.IA_TIME',
            'sm_meter_gi.IB',
            'sm_meter_gi.IB_TIME',
            'sm_meter_gi.IC',
            'sm_meter_gi.IC_TIME',
            'sm_meter_gi.IN',
            'sm_meter_gi.IN_TIME',
            'sm_meter_gi.VLL',
            'sm_meter_gi.VLL_TIME',
            'sm_meter_gi.KW',
            'sm_meter_gi.KW_TIME',
            'sm_meter_gi.PF',
            'sm_meter_gi.PF_TIME',
            'sm_meter_gi.IFA',
            'sm_meter_gi.IFA_TIME',
            'sm_meter_gi.IFB',
            'sm_meter_gi.IFB_TIME',
            'sm_meter_gi.IFC',
            'sm_meter_gi.IFC_TIME',
            'sm_meter_gi.IFN',
            'sm_meter_gi.IFN_TIME',
            'dc_cubicle.CUBICLE_NAME as name' 
            ) ;
        if ($request->searchText != '') {
            $smMeter = $smMeter->where(function ($query) {
                $query->where('name', 'like', '%' . request('searchText') . '%');
            });
        }
        return $smMeter->groupBy('id');
    }
 
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('bebanrealtimedatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax() 
                    ->destroy(true) 
                    ->responsive(true)
                    ->serverSide(true) 
                    ->stateSave(false)
                    ->processing(true)
                    ->language(__('app.datatable'))
                    ->parameters([
                        'initComplete' => 'function () {
                            window.LaravelDataTables["bebanrealtimedatatable-table"].buttons().container()
                             .appendTo( "#table-actions")
                         }',
                        'fnDrawCallback' => 'function( oSettings ) {
                           //
                           $(".select-picker").selectpicker();
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
            //   OUTGOING_METER_ID 	OUTGOING_ID 	IA 	IA_TIME 	IB 	IB_TIME 	IC 	IC_TIME 	IN 	IN_TIME 	VLL 	VLL_TIME 	KW 	KW_TIME 	PF 	PF_TIME 	IFA 	IFA_TIME 	IFB 	IFB_TIME 	IFC 	IFC_TIME 	IFN 	IFN_TIME
            Column::make('id'), 
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
        return 'BebanRealtime_' . date('YmdHis');
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
