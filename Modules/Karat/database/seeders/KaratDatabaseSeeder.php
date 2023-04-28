<?php

namespace Modules\Karat\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Tag\Entities\Karat;

class KaratDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        /*
         * Karats Seed
         * ------------------
         */

        // DB::table('karats')->truncate();
        // echo "Truncate: karats \n";

        Karat::factory()->count(5)->create();
        $rows = Karat::all();
        echo " Insert: karats \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
