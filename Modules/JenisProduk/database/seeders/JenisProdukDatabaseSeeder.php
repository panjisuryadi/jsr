<?php

namespace Modules\JenisProduk\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\JenisProduk\Models\JenisProduk;
use Carbon\Carbon;
class JenisProdukDatabaseSeeder extends Seeder
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
         * JenisProduks Seed
         * ------------------
         */

        // DB::table('jenisproduks')->truncate();
        // echo "Truncate: jenisproduks \n";

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
        //         $data = JenisProduk::create($row);

        //     }


        JenisProduk::factory()->count(20)->create();
        $rows = JenisProduk::all();
        echo " Insert: jenisproduks \n\n";

        // Enable foreign key checks!
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
