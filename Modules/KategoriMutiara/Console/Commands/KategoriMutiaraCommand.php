<?php

namespace Modules\KategoriMutiara\Console\Commands;

use Illuminate\Console\Command;

class KategoriMutiaraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KategoriMutiaraCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KategoriMutiara Command description';

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
