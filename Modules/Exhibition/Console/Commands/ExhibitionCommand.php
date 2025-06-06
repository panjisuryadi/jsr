<?php

namespace Modules\Exhibition\Console\Commands;

use Illuminate\Console\Command;

class ExhibitionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ExhibitionCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exhibition Command description';

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
