<?php

namespace App\Exports\Sale;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Sale\Entities\Sale;

class SaleExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(private $sales_data) {}
    public function headings(): array
    {
        return [
            'Tanggal',
            'Invoice',
            'Cabang',
            'Nominal',
            'Nominal Pembayaran',
            'Nominal Kembalian'
        ];
    }

    public function map($sale): array
    {
        return [
            tanggal($sale->date),
            $sale->reference,
            $sale->cabang->name,
            $sale->total_amount,
            $sale->paid_amount,
            $sale->due_amount
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->sales_data;
    }
}
