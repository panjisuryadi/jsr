<?php

namespace Modules\JenisProduk\Console\Commands;

use Illuminate\Console\Command;

class JenisProdukCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:JenisProdukCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JenisProduk Command description';

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
