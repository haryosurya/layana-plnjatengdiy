<?php

namespace App\DataTables\DC;

use App\Models\Dc_apj;
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
            ->rawColumns(['action']);
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
            ->selectRaw(
            'dc_apj.APJ_ID as id,
            dc_apj.APJ_NAMA as name,
            dc_apj.APJ_ALIAS as alias,
            dc_apj.APJ_DCC as dcc,
            dc_apj.TELEGRAM_ID as telegram,
            count(dc_gardu_induk.GARDU_INDUK_NAMA) as total_gardu' 
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
            __('app.name') => ['data' => 'name', 'name' => 'name', 'title' => __('app.name')],
            __('modules.dc.total-gardu') => ['data' => 'total_gardu', 'name' => 'total_gardu', 'title' => __('modules.dc.total-gardu')], 
            __('modules.dc.dcc') => ['data' => 'dcc', 'name' => 'dcc', 'title' => __('modules.dc.dcc')], 
            __('modules.dc.telegram-id') => ['data' => 'telegram', 'name' => 'telegram', 'title' => __('modules.dc.telegram-id')], 
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
        return 'DC/Dcc_' . date('YmdHis');
    }
}
