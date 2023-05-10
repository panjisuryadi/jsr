<?php

namespace Modules\ParamaterPoin\database\seeders;
//use Modules\ParamaterPoin\database\seeders\ParamaterPoinDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\ParamaterPoin\Models\ParamaterPoin;
use Carbon\Carbon;
class ParamaterPoinDatabaseSeeder extends Seeder
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
         * ParamaterPoins Seed
         * ------------------
         */

        // DB::table('paramaterpoins')->truncate();
        // echo "Truncate: paramaterpoins \n";

        //  $data = [
        //     [
        //         'id'                 => 1,
        //         'name'               => 'Inclusive',
        //         'description'        => 'Diamond - Inclusive',
        //         'created_at'         => Carbon::now(),
        //         'updated_at'         => Carbon::now(),
        //     ],

        // ];

        //     foreach ($data as $row) {
        //         $data = ParamaterPoin::create($row);

        //     }


        ParamaterPoin::factory()->count(20)->create();
        $rows = ParamaterPoin::all();
        echo " Insert: paramaterpoins \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
