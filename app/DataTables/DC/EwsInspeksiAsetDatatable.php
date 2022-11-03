<?php

namespace App\DataTables\DC;

use App\DataTables\BaseDataTable;
use App\Models\ews_inspeksi_aset;
use Carbon\Carbon;
use DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EwsInspeksiAsetDatatable extends BaseDataTable
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
                            id="dropdownMenuLink-' . $row->id_inspeksi_aset . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="icon-options-vertical icons"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-' . $row->id_inspeksi_aset . '" tabindex="0">';
 
                        // $action .= '<a href="' . route('cubicle.show', [$row->id_inspeksi_pd]) . '" class="dropdown-item"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';
                        $action .= '<a class="dropdown-item openRightModal" href="' . route('inspeksi-aset.edit', [$row->id_inspeksi_aset]) . '">
                            <i class="fa fa-edit mr-2"></i>
                            ' . trans('app.edit') . '
                        </a>';
                        $action .= '<a class="dropdown-item delete-table-row" href="javascript:;" data-user-id="' . $row->id_inspeksi_aset . '">
                            <i class="fa fa-trash mr-2"></i>
                            ' . trans('app.delete') . '
                        </a>';
        
                $action .= '</div>
                    </div>
                </div>';

                return $action;
            }) 
            ->rawColumns(['action','level_pd','name']);
            // ->addColumn('action', 'ewsinspeksiasetdatatable.action')
            ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EwsInspeksiAsetDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ews_inspeksi_aset $model)
    {
        $request = $this->request(); 
        $inspeksi = $model 
            ->withoutGlobalScope('active')
            ->join('dc_cubicle','dc_cubicle.OUTGOING_ID', 'ews_inspeksi_aset.id_outgoing')   
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID', 'ews_inspeksi_aset.id_gardu_induk')
            ->leftJoin('dc_apj','dc_apj.APJ_ID', 'dc_gardu_induk.APJ_ID')   
            ->join('users','users.id', 'ews_inspeksi_aset.id_user')

            ->select(
                'ews_inspeksi_aset.*',
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
            if ($this->request()->startDate !== null && $this->request()->startDate != 'null' && $this->request()->startDate != '') {
                $startDate = Carbon::createFromFormat($this->global->date_format, $this->request()->startDate)->toDateString();
    
                $inspeksi = $inspeksi->having(DB::raw('DATE(ews_inspeksi_aset.`tgl_entry`)'), '>=', $startDate);
            }
    
            if ($this->request()->endDate !== null && $this->request()->endDate != 'null' && $this->request()->endDate != '') {
                $endDate = Carbon::createFromFormat($this->global->date_format, $this->request()->endDate)->toDateString();
                $inspeksi = $inspeksi->having(DB::raw('DATE(ews_inspeksi_aset.`tgl_entry`)'), '<=', $endDate);
            }
            if ($request->gi != 'all' && $request->gi != '' ) { 
                $inspeksi = $inspeksi->where('ews_inspeksi_aset.id_gardu_induk', $request->gi) ; 
            }
            if ($request->apj != 'all' && $request->apj != '' ) {  
                $inspeksi = $inspeksi->where('dc_apj.APJ_ID', $request->apj) ; 
            }

            /*  */
        return $inspeksi->groupBy('ews_inspeksi_aset.id_inspeksi_aset'); 
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('ewsinspeksiasetdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax() 
                    ->destroy(true) 
                    ->scrollY("500px")
                    ->scrollX('100%')
                    ->fixedColumns(true)
                    ->scrollCollapse(true)
                    ->fixedColumns( 
                            [
                                'left'=>'4',
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
                           window.LaravelDataTables["ewsinspeksiasetdatatable-table"].buttons().container()
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
            __('app.id') => ['data' => 'id_inspeksi_aset', 'name' => 'id_inspeksi_aset', 'visible' => false],
            '#' => ['data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false ],  
            Column::make('name')->title('Cubicle'),
            Column::make('gardu_name')->title('Nama Gardu'),
            Column::make('operator'),
            Column::make('tgl_entry'), 
            Column::make('tgl_entry'), 
            Column::make('tgl_inspeksi'), 
            Column::make('body_cubicle'), 
            Column::make('lv'), 
            Column::make('cb'), 
            Column::make('busbar'), 
            Column::make('power_cable'), 
            Column::make('pmt_cb'), 
            Column::make('announ'), 
            Column::make('ind_lamp'), 
            Column::make('ind_volt'), 
            Column::make('ac220'), 
            Column::make('dc110'), 
            Column::make('desis'), 
            Column::make('dengung'), 
            Column::make('ngeter'), 
            Column::make('flash'), 
            Column::make('sangit'), 
            Column::make('amis'), 
            Column::make('feeder'), 
            Column::make('kubikel'), 
            Column::make('pmt'), 
            Column::make('grounding'), 
            Column::make('sangit2'), 
            Column::make('slr'), 
            Column::make('sar'), 
            Column::make('body_alat'), 
            Column::make('wiring'), 
            Column::make('w_prot'), 
            Column::make('w_meter'), 
            Column::make('w_acc'), 
            Column::make('relay_ready'), 
            Column::make('relay_display'), 
            Column::make('relay_mr'), 
            Column::make('relay_ms'), 
            Column::make('relay_mt'), 
            Column::make('pm_display'), 
            Column::make('pm_mr'), 
            Column::make('pm_ms'), 
            Column::make('pm_mt'), 
            Column::make('kwh_meter')->name('ks'), 
            Column::make('panel_rtu'), 
            Column::make('door'), 
            Column::make('fan'), 
            Column::make('lampu_panel'), 
            Column::make('grounding_rtu'), 
            Column::make('temp_panel'), 
            Column::make('kebersihan'), 
            Column::make('power_on'), 
            Column::make('ethernet'), 
            Column::make('power_on'), 
            Column::make('keterangan'), 
            Column::make('id_update'), 
            Column::make('last_update'), 
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
        return 'EwsInspeksiAset_' . date('YmdHis');
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
