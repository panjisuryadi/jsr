<?php

namespace Modules\KategoriBerlian\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\KategoriBerlian\Models\KategoriBerlian;
use Carbon\Carbon;
class KategoriBerlianDatabaseSeeder extends Seeder
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
         * KategoriBerlians Seed
         * ------------------
         */

        // DB::table('kategoriberlians')->truncate();
        // echo "Truncate: kategoriberlians \n";

         $data = [
            [
                'id'                 => 1,
                'name'               => 'Inclusive',
                'description'        => 'Diamond - Inclusive',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],[
                'id'                 => 2,
                'name'               => 'Exlusive',
                'description'        => 'Diamond - Exlusive',
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ],

        ];

            foreach ($data as $row) {
                $data = KategoriBerlian::create($row);

            }


        // KategoriBerlian::factory()->count(20)->create();
        // $rows = KategoriBerlian::all();
        echo " Insert: kategoriberlians \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
