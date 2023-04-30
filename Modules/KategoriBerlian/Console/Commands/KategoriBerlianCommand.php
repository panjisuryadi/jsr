<?php

namespace Modules\KategoriBerlian\Console\Commands;

use Illuminate\Console\Command;

class KategoriBerlianCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:KategoriBerlianCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'KategoriBerlian Command description';

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
