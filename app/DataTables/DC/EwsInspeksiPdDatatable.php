<?php

namespace App\DataTables\DC;

use App\Models\ews_inspeksi_pd;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EwsInspeksiPdDatatable extends DataTable
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
            ->editColumn('name', function ($row) { 
                return '<a href="' . route('cubicle.show', [$row->OUTGOING_ID]) . '"><i class="fa fa-circle mr-1 text-light-green f-10"></i> '. $row->name.'</a> ';
                 
            })
            ->editColumn( 'level_pd', function ($row) {
                    if ($row['level_pd'] == 'good' && $row['level_pd'] != '') 
                    {
                        return '  <i class="fa fa-circle mr-1 text-light-green f-10"></i> <span class="badge badge-success">' . __('app.good')  .'</span>';
                    }
                    elseif ($row['level_pd'] == 'moderate' && $row['level_pd'] != '') 
                    {
                        return '<i class="fa fa-circle mr-1 text-yellow f-10"></i> <span class="badge badge-warning">' . __('app.moderate')  .'</span>'; 
                    }
                    elseif ($row['level_pd'] == 'bad' && $row['level_pd'] != '') 
                    {
                        return ' <i class="fa fa-circle mr-1 text-red f-10"></i> <span class="badge badge-danger">' . __('app.bad')  .'</span>';
                    }
                    else{
                        return '';
                    }   
                }
            )
            ->addColumn('action', function ($row) {
                $action = '<div class="task_view">

                    <div class="dropdown">
                        <a class="task_view_more d-flex align-items-center justify-content-center dropdown-toggle" type="link"
                            id="dropdownMenuLink-' . $row->id_inspeksi_pd . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id_inspeksi_pd . '" tabindex="0">';
 
                        $action .= '<a href="' . route('cubicle.show', [$row->id_inspeksi_pd]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
 
        
                $action .= '</div>
                    </div>
                </div>';

                return $action;
            }) 
            ->rawColumns(['action','level_pd','name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/EwsInspeksiPdDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ews_inspeksi_pd $model)
    {
        $request = $this->request(); 
        $inspeksi = $model 
            ->withoutGlobalScope('active')
            ->join('dc_cubicle','dc_cubicle.OUTGOING_ID', 'ews_inspeksi_pd.id_outgoing')   
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID', 'ews_inspeksi_pd.id_gardu_induk')
            ->join('users','users.id', 'ews_inspeksi_pd.id_user')

            ->select(
                'ews_inspeksi_pd.*',
                'dc_cubicle.OUTGOING_ID as OUTGOING_ID',
                'dc_cubicle.CUBICLE_NAME as name',
                'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK as gardu_name',
                'users.name as operator'
                )
            ;
            if ($request->searchText != '') {
                $inspeksi = $inspeksi->where(function ($query) {
                    $query->where('name', 'like', '%' . request('searchText') . '%')
                        ->orWhere('name', 'like', '%' . request('searchText') . '%');
                });
            }
        return $inspeksi->groupBy('id_inspeksi_pd');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
     
    {
        return $this->builder()
                    ->setTableId('ewsinspeksipddatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
                    ->dom("<'row'<'col-md-6'l><'col-md-6'Bf>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>") 
                    ->destroy(true)
                    ->responsive(true)
                    ->serverSide(true)
                    ->stateSave(true)
                    ->processing(true)
                    ->language(__('app.datatable'))
                    ->parameters([
                        'initComplete' => 'function () {
                           window.LaravelDataTables["ewsinspeksipddatatable-table"].buttons().container()
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
            __('app.id') => ['data' => 'id_inspeksi_pd', 'name' => 'id_inspeksi_pd', 'visible' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false ], 
            // Column::make('id_inspeksi_pd'),
            Column::make('name'),
            Column::make('gardu_name'),
            Column::make('operator'),
            Column::make('level_pd'),
            Column::make('tgl_entry'),
            Column::make('tgl_inspeksi'),
            Column::computed('action', __('app.action'))
            ->exportable(false)
            ->printable(false)
            ->orderable(false)
            ->searchable(false)
            // ->width(150)
            ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EwsInspeksiPd_' . date('YmdHis');
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
