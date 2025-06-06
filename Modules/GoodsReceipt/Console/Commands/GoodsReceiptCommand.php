<?php

namespace Modules\GoodsReceipt\Console\Commands;

use Illuminate\Console\Command;

class GoodsReceiptCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:GoodsReceiptCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'GoodsReceipt Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}
