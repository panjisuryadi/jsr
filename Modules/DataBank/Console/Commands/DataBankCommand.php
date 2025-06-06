<?php

namespace Modules\DataBank\Console\Commands;

use Illuminate\Console\Command;

class DataBankCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:DataBankCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DataBank Command description';

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
