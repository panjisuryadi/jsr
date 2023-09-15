<?php

namespace Modules\ReturSale\Listeners\ReturSaleDetailCreated;

use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
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
     * @param ReturSaleDetailCreated $event
     * @return void
     */
    public function handle(ReturSaleDetailCreated $event)
    {
        $stock_sales = StockSales::where([
            'sales_id' => $event->retur_sale->sales_id,
            'karat_id' => $event->retur_sale_detail->karat_id
        ])->first();

        $existingWeight = $stock_sales->weight;
        $stock_sales->update([
            'weight' => $existingWeight - $event->retur_sale_detail->weight
        ]);
    }
}
