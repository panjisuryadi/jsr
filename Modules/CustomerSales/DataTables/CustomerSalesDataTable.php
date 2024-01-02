<?php

namespace Modules\CustomerSales\DataTables;


use Modules\CustomerSales\Entities\CustomerSales;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerSalesDataTable extends DataTable
{

    public function dataTable($query) {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', function ($data) {
                return view('customersales::customersales.partials.actions', compact('data'));
            });
    }

    public function query(CustomerSales $model) {
        return $model->newQuery();
    }

    public function html() {
        return $this->builder()
            ->setTableId('customersales-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom("<'row'<'col-md-3'l><'col-md-5 mb-2'B><'col-md-4'f>> .
                                       'tr' .
                                 <'row'<'col-md-5'i><'col-md-7 mt-2'p>>")
            ->orderBy(4)
            ->buttons(
                Button::make('excel')
                    ->text('<i class="bi bi-file-earmark-excel-fill"></i> Excel'),
                Button::make('print')
                    ->text('<i class="bi bi-printer-fill"></i> Print'),
                Button::make('reset')
                    ->text('<i class="bi bi-x-circle"></i> Reset'),
                Button::make('reload')
                    ->text('<i class="bi bi-arrow-repeat"></i> Reload')
            );
    }

    protected function getColumns() {
        return [
            Column::make('customer_name')
                ->title(__('Customer Sales'))
                ->className('text-center align-middle'),

            Column::make('market')
                ->title(__('Market'))
                ->className('text-center align-middle'),

            Column::make('customer_phone')
                ->title(__('Phone'))
                ->className('text-center align-middle'),

            Column::computed('action')
                ->title(__('action'))
                ->exportable(false)
                ->printable(false)
                ->className('text-center align-middle'),

            Column::make('created_at')
                ->visible(false)
        ];
    }

    protected function filename() {
        return 'CustomerSales_' . date('YmdHis');
    }
}
