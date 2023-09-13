<?php

namespace Modules\DistribusiSale\Listeners\DistribusiSaleDetailCreated;

use Modules\DistribusiSale\Events\DistribusiSaleDetailCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Stok\Models\StockSales;

class UpdateOrCreateStockSales implements ShouldQueue
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
     * @param DistribusiSaleDetailCreated $event
     * @return void
     */
    public function handle(DistribusiSaleDetailCreated $event)
    {
        $dist_sale = $event->dist_sale;
        $dist_sale_detail = $event->dist_sale_detail;
        // reduce stock sales, distribusi_sales_id, karat_id

        $existingWeight = StockSales::where(['sales_id' => $dist_sale->sales_id, 'karat_id' => $dist_sale_detail->karat_id])->value('weight');

        StockSales::updateOrCreate(
            ['sales_id'=>$dist_sale->sales_id,'karat_id'=>$dist_sale_detail->karat_id],
            ['weight'=>$dist_sale_detail->berat_bersih + $existingWeight]
        );
    }
}
