<?php

namespace App\DataTables\DC;

// use App\Models\DC/IncomingFeederDatatable;

use App\DataTables\BaseDataTable;
use App\Models\Dc_incoming_feeder;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class IncomingFeederDatatable extends BaseDataTable
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
            ->addColumn('action', 'dc/incomingfeederdatatable.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\DC/IncomingFeederDatatable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Dc_incoming_feeder $model)
    {
        return $model->newQuery();
        $request = $this->request();
        $dateRange = null;
        $endDate = null;

        if ($request->dateRange !== null && $request->dateRange != 'null' && $request->dateRange != '') {
            $startDate = Carbon::createFromFormat($this->global->date_format, $request->dateRange)->toDateString();
        }

        if ($request->endDate !== null && $request->endDate != 'null' && $request->endDate != '') {
            $endDate = Carbon::createFromFormat($this->global->date_format, $request->endDate)->toDateString();
        }

        $model = $model->with('contractType', 'client', 'signature', 'client.clientDetails')
            ->join('users', 'users.id', '=', 'contracts.client_id')
            ->join('client_details', 'users.id', '=', 'client_details.user_id')
            ->select('contracts.*');

        if ($startDate !== null && $endDate !== null) {
            $model->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween(DB::raw('DATE(contracts.`end_date`)'), [$startDate, $endDate]);

                $q->orWhereBetween(DB::raw('DATE(contracts.`start_date`)'), [$startDate, $endDate]);
            });
        }

        if ($request->client != 'all' && !is_null($request->client)) {
            $model = $model->where('contracts.client_id', '=', $request->client);
        }

        if ($request->contract_type != 'all' && !is_null($request->contract_type)) {
            $model = $model->where('contracts.contract_type_id', '=', $request->contract_type);
        }

        if (request('signed') == 'yes') {
            $model = $model->has('signature');
        }

        if ($request->searchText != '') {
            $model = $model->where(function ($query) {
                $query->where('contracts.subject', 'like', '%' . request('searchText') . '%')
                    ->orWhere('contracts.amount', 'like', '%' . request('searchText') . '%')
                    ->orWhere('client_details.company_name', 'like', '%' . request('searchText') . '%');
            });
        }

        if ($this->viewContractPermission == 'added') {
            $model = $model->where('contracts.added_by', '=', user()->id);
        }

        if ($this->viewContractPermission == 'owned') {
            $model = $model->where('contracts.client_id', '=', user()->id);
        }

        if ($this->viewContractPermission == 'both') {
            $model = $model->where(function ($query) {
                $query->where('contracts.added_by', '=', user()->id)
                    ->orWhere('contracts.client_id', '=', user()->id);
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
                    ->setTableId('incomingfeederdatatable-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(2)
                    ->destroy(true)
                    ->responsive(true)
                    ->serverSide(true)
                    /* ->stateSave(true) */
                    ->processing(true)
                    ->language(__('app.datatable'))
                    ->parameters([
                        'initComplete' => 'function () {
                           window.LaravelDataTables["incomingfeederdatatable-table"].buttons().container()
                            .appendTo( "#table-actions")
                        }',
                        'fnDrawCallback' => 'function( oSettings ) {
                            $("body").tooltip({
                                selector: \'[data-toggle="tooltip"]\'
                            })
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
            Column::make('INCOMING_ID'), 
            Column::make('GARDU_INDUK_ID'), 
            Column::make('INCOMING_NAME'), 
            Column::make('MERK_TRAFO'), 
            Column::make('DAYA_REAKTIF_TRAFO'), 
            Column::make('RASIO_TEGANGAN'), 
            Column::make('NAMA_ALIAS_INCOMING'), 
            Column::make('I_NOMINAL_HV'), 
            Column::make('I_NOMINAL_LV'), 
            Column::make('PABRIKAN_RELAY'), 
            Column::make('METER'), 

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'IncomingFeeder_' . date('YmdHis');
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
