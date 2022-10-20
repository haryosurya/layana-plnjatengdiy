<?php

namespace App\DataTables\DC;

use App\Models\ews_inspeksi_aset;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EwsInspeksiAsetDatatable extends DataTable
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
            ->addColumn('action', 'ewsinspeksiasetdatatable.action');
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
            ->join('dc_cubicle','dc_cubicle.OUTGOING_ID', 'ews_inspeksi_pd.id_outgoing')   
            ->join('dc_gardu_induk','dc_gardu_induk.GARDU_INDUK_ID', 'ews_inspeksi_pd.id_gardu_induk')
            ->join('users','users.id', 'ews_inspeksi_pd.id_user')

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
            /*  */
        return $inspeksi->groupBy('id_inspeksi_aset'); 
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
            Column::make('id_inspeksi_aset'),
            Column::make('gardu_name'),
            Column::make('name'),
            Column::make('operator'),
            // 'dc_cubicle.OUTGOING_ID as OUTGOING_ID',
            //     'dc_cubicle.CUBICLE_NAME as name',
            //     'dc_gardu_induk.NAMA_ALIAS_GARDU_INDUK as gardu_name',
            //     'users.name as operator'
            //  	id_outgoing 	id_user 	id_gardu_induk 	tgl_entry 	tgl_inspeksi 	body_cubicle 	lv 	cb 	busbar 	power_cable 	pmt_cb 	announ 	ind_lamp 	ind_volt 	ac220 	dc110 	desis 	dengung 	ngeter 	flash 	sangit 	amis 	feeder 	kubikel 	pmt 	grounding 	sangit2 	slr 	sar 	body_alat 	wiring 	w_prot 	w_meter 	w_acc 	relay_ready 	relay_display 	relay_mr 	relay_ms 	relay_mt 	pm_display 	pm_mr 	pm_ms 	pm_mt 	kwh_meter 	panel_rtu 	door 	fan 	lampu_panel 	grounding_rtu 	temp_panel 	kebersihan 	power_on 	led_txrx 	ethernet 	keterangan 	id_update 	last_update
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
