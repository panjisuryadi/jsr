<?php

namespace Modules\ReturSale\Listeners\ReturSaleDetailCreated;

use Modules\ReturSale\Events\ReturSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Stok\Models\StockOffice;

class UpdateStockOffice implements ShouldQueue
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
        $stock_office = StockOffice::where([
            'karat_id' => $event->retur_sale_detail->karat_id
        ])->first();

        $existingWeight = $stock_office->berat_real;
        $stock_office->update([
            'berat_real' => $existingWeight + $event->retur_sale_detail->weight
        ]);
    }
}
