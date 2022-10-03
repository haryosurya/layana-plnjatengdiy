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
                            id="dropdownMenuLink-' . $row->id . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id . '" tabindex="0">';
 

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
        $request = $this->request();
 

        $gardu = $model->with('dc_apj')
            ->withoutGlobalScope('active')
            ->join('dc_apj', 'dc_apj.APJ_ID', '=', 'dc_gardu_induk.APJ_ID') 
            ->select(
                'dc_gardu_induk.GARDU_INDUK_ID',
                'dc_apj.APJ_NAMA AS APJ_NAMA',
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
                        ->orWhere('dc_gardu_induk.GARDU_INDUK_NAMA', 'like', '%' . request('searchText') . '%');
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
            ->setTableId('dccubicledatatable-table') 
            ->columns($this->getColumns())
            ->minifiedAjax() 
            ->destroy(true)
            ->orderBy(2)
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
