<?php

namespace Modules\Timbangan\database\seeders;
//use Modules\Timbangan\database\seeders\TimbanganDatabaseSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Timbangan\Models\Timbangan;
use Carbon\Carbon;
class TimbanganDatabaseSeeder extends Seeder
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
         * Timbangans Seed
         * ------------------
         */

        // DB::table('timbangans')->truncate();
        // echo "Truncate: timbangans \n";

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
        //         $data = Timbangan::create($row);

        //     }


        Timbangan::factory()->count(20)->create();
        $rows = Timbangan::all();
        echo " Insert: timbangans \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
