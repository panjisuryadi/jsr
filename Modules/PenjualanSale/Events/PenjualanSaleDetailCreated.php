<?php

namespace Modules\PenjualanSale\Events;

use Illuminate\Queue\SerializesModels;
use Modules\PenjualanSale\Models\PenjualanSale;
use Modules\PenjualanSale\Models\PenjualanSaleDetail;

class PenjualanSaleDetailCreated
{
    use SerializesModels;

    public $penjualan_sale;
    public $penjualan_sale_detail;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PenjualanSale $penjualanSale,PenjualanSaleDetail $penjualanSaleDetail)
    {
        $this->penjualan_sale = $penjualanSale;
        $this->penjualan_sale_detail = $penjualanSaleDetail;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
