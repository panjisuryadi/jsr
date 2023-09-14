<?php

namespace Modules\PenjualanSale\Listeners\PenjualanSaleDetailCreated;

use Modules\PenjualanSale\Events\PenjualanSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Stok\Models\StockSales;

class UpdateStockSales implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PenjualanSaleDetailCreated $event
     * @return void
     */
    public function handle(PenjualanSaleDetailCreated $event)
    {

        $stock_sales = StockSales::where([
            'sales_id' => $event->penjualan_sale->sales_id,
            'karat_id' => $event->penjualan_sale_detail->karat_id
        ])->first();

        $existingWeight = $stock_sales->weight;
        $stock_sales->update([
            'weight' => $existingWeight - $event->penjualan_sale_detail->weight
        ]);
    }
}
