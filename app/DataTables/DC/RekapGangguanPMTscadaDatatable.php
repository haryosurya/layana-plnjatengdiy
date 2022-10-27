<?php

namespace App\DataTables\DC;

use App\Models\Dc_operasi_pmt_scada;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class RekapGangguanPMTscadaDatatable extends DataTable
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

                    $action .= '<a href="' . route('rekap-gangguan-pmt.show', [$row->id]) . '" class="dropdown-item openRightModal"><i class="fa fa-eye mr-2"></i>' . __('app.view') . '</a>';

                    // if ($this->editEmployeePermission == 'all'
                    //     || ($this->editEmployeePermission == 'added' && user()->id == $row->added_by)
                    //     || ($this->editEmployeePermission == 'owned' && user()->id == $row->id)
                    //     || ($this->editEmployeePermission == 'both' && (user()->id == $row->id || user()->id == $row->added_by))
                    // ) {
                    //     $action .= '<a class="dropdown-item openRightModal" href="' . route('employees.edit', [$row->id]) . '">
                    //                 <i class="fa fa-edit mr-2"></i>
                    //                 ' . trans('app.edit') . '
                    //             </a>';
                    // }
    
                    // if ($this->deleteEmployeePermission == 'all' || ($this->deleteEmployeePermission == 'added' && user()->id == $row->added_by)) {
                    //     if (user()->id !== $row->id) {
                    //         $action .= '<a class="dropdown-item delete-table-row" href="javascript:;" data-user-id="' . $row->id . '">
                    //                 <i class="fa fa-trash mr-2"></i>
                    //                 ' . trans('app.delete') . '
                    //             </a>';
                    //     }
                    // }
    
            $action .= '</div>
                </div>
            </div>';

            return $action;
        })
        ->editColumn('TGL_OPERASI_PMT', function ($row) {
            $setting = global_setting();
             
            return Carbon::parse($row->TGL_OPERASI_PMT)->format('Y-m-d H:i:s'); 
        })
        ->editColumn('TGL_NORMAL_PMT', function ($row) {
            $setting = global_setting();
             
            return Carbon::parse($row->TGL_NORMAL_PMT)->format('Y-m-d H:i:s');  
        })
        ->rawColumns(['action','TGL_NORMAL_PMT','TGL_OPERASI_PMT']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/RekapGangguanPMTscadaDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_operasi_pmt_scada $model)
    {
        return $model
        ->join('dc_apj','dc_apj.APJ_ID','dc_operasi_pmt_scada.APJ_ID')
        ->join('dc_cubicle','dc_cubicle.CUBICLE_NAME','dc_operasi_pmt_scada.DETAIL_LOKASI')
        ->join('dc_tipe_gangguan','dc_tipe_gangguan.ID_TIPE_GANGGUAN','dc_operasi_pmt_scada.ID_TIPE_GANGGUAN')
        ->join('dc_indikasi_gangguan','dc_indikasi_gangguan.ID_INDIKASI_GANGGUAN','dc_operasi_pmt_scada.ID_INDIKASI_GANGGUAN')
        ->join('dc_speedjardist_cuaca','dc_speedjardist_cuaca.ID_CUACA','dc_operasi_pmt_scada.CUACA') 
        ->join('dc_jenis_keadaan_pmt','dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT_ID','dc_operasi_pmt_scada.JENIS_OPERASI_PMT') 
        ->select(
            'OPERASI_PMT_ID as id',
            'dc_apj.APJ_DCC as APJ_DCC',
            'DETAIL_LOKASI',
            'TGL_OPERASI_PMT',
            'TGL_NORMAL_PMT',
            'dc_jenis_keadaan_pmt.JENIS_KEADAAN_PMT AS JENIS_KEADAAN_PMT',
            'dc_apj.APJ_ID as APJ_ID',
            'dc_apj.APJ_NAMA as APJ_NAMA',
            'CAKUPAN_KERJA',
            'ALASAN_OPERASI_PMT',
            'dc_tipe_gangguan.NAMA_TIPE_GANGGUAN as TIPE_GANGGUAN',
            'dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN as INDIKASI_GANGGUAN',
            'BEBAN_SBLM_PMT_LEPAS',
            'TEG_SBLM_PMT_LEPAS',
            'BEBAN_SSDH_PMT_LEPAS',
            'TEG_SSDH_PMT_LEPAS',
            'ARUS_GANGGUAN_PH_A',
            'ARUS_GANGGUAN_PH_B',
            'ARUS_GANGGUAN_PH_C',
            'ARUS_GANGGUAN_PH_N',
            'KET_ARUS_GANGGUAN',
            'ASAL_ID',
            'dc_speedjardist_cuaca.CUACA_NAME as CUACA_NAME',
            'LOKASI_GANGGUAN',
            'JARAK_GANGGUAN',
            'NO_POLE_TIANG'
            // 'UPJ_ID' 	
        )
        ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('rekapgangguanpmtscadadatatable-table')
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
                            window.LaravelDataTables["rekapgangguanpmtscadadatatable-table"].buttons().container()
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
                // _ID','TGL_OPERASI_PMT','TGL_NORMAL_PMT','JENIS_OPERASI_PMT','APJ_ID','CAKUPAN_KERJA','DETAIL_LOKASI','ALASAN_OPERASI_PMT','ID_TIPE_GANGGUAN','ID_INDIKASI_GANGGUAN','BEBAN_SBLM_PMT_LEPAS','TEG_SBLM_PMT_LEPAS','BEBAN_SSDH_PMT_LEPAS','TEG_SSDH_PMT_LEPAS','ARUS_GANGGUAN_PH_A','ARUS_GANGGUAN_PH_B','ARUS_GANGGUAN_PH_C','ARUS_GANGGUAN_PH_N','KET_ARUS_GANGGUAN','ASAL_ID','CUACA','LOKASI_GANGGUAN','JARAK_GANGGUAN','NO_POLE_TIANG','UPJ_ID' 	
                Column::make('DETAIL_LOKASI'),
                Column::make('APJ_ID'),
                Column::make('APJ_DCC'),
                Column::make('APJ_NAMA'),
                Column::make('TGL_OPERASI_PMT'),
                Column::make('TGL_NORMAL_PMT'),
                Column::make('JENIS_KEADAAN_PMT'),
                Column::make('TIPE_GANGGUAN'),
                Column::make('INDIKASI_GANGGUAN'),
                Column::make('CAKUPAN_KERJA'),
                Column::make('ARUS_GANGGUAN_PH_A'),
                Column::make('ARUS_GANGGUAN_PH_B'),
                Column::make('ARUS_GANGGUAN_PH_C'),
                Column::make('ARUS_GANGGUAN_PH_N'),
                Column::make('CUACA_NAME'),
                Column::make('ALASAN_OPERASI_PMT'), 
                Column::make('BEBAN_SBLM_PMT_LEPAS'),
                Column::make('TEG_SBLM_PMT_LEPAS'),
                Column::make('TEG_SSDH_PMT_LEPAS'),
                Column::make('KET_ARUS_GANGGUAN'),
                Column::make('ASAL_ID'),
                Column::make('LOKASI_GANGGUAN'),
                Column::make('NO_POLE_TIANG'),
                // Column::make('UPJ_ID'),
                
                // '',
                // '',
                // '',
                // '',
    
            // 'DETAIL_LOKASI',
            // 'ALASAN_OPERASI_PMT',
            // 'dc_tipe_gangguan.NAMA_TIPE_GANGGUAN as TIPE_GANGGUAN',
            // 'dc_indikasi_gangguan.NAMA_INDIKASI_GANGGUAN as INDIKASI_GANGGUAN',
            // 'BEBAN_SBLM_PMT_LEPAS',
            // 'TEG_SBLM_PMT_LEPAS',
            // 'BEBAN_SSDH_PMT_LEPAS',
            // 'TEG_SSDH_PMT_LEPAS',
            // 'KET_ARUS_GANGGUAN',
            // 'ASAL_ID', 
            // 'LOKASI_GANGGUAN',
            // 'JARAK_GANGGUAN',
            // 'NO_POLE_TIANG',
            // 'UPJ_ID' 	
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'), 
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'RekapGangguanPMTscada_' . date('YmdHis');
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
