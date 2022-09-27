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
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view"> 
                            <div class="dropdown">
                                <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                                    id="dropdownMenuLink-' . $row->INCOMING_ID . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-options-vertical icons"></i>
                                </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->INCOMING_ID . '" tabindex="0">'; 
                $action .= '<a href=" " class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';

                
                $action .= '<a class="dropdown-item openRightModal" href=" ">
                            <i class="fa fa-edit mr-2"></i>
                            ' . trans('app.edit') . '
                        </a>'; 

                $action .= '<a class="dropdown-item delete-table-row" href="javascript:;" data-user-id="' . $row->INCOMING_ID . '">
                        <i class="fa fa-trash mr-2"></i>
                        ' . trans('app.delete') . '
                    </a>';
            

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
     * @param \App\Models\DC/DcCubicleDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_cubicle $model)
    {
        return $model->newQuery();
        $request = $this->request();
        $dateRange = null;
        $endDate = null; 
        $model = $model->with('dc_apj', 'dc_gardu_induk')
            ->join('dc_apj', 'dc_incoming_feeder.APJ_ID', '=', 'dc_apj.APJ_ID')
            ->join('dc_gardu_induk', 'dc_incoming_feeder.GARDU_INDUK_ID', '=', 'dc_gardu_induk.GARDU_INDUK_ID')
            ->select('dc_apj.INCOMING_ID'); 
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
                    ->setTableId('dc/dccubicledatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
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
