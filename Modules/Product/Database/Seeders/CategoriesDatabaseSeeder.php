<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\Category;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;


class CategoriesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {


    $produk = [
            [
                'category_code'                  => 'C-00001',
                'category_name'                  => 'Minuman',
                'parent_id'                  => null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00002',
                'category_name'                  => 'Makanan',
                'parent_id'                  => null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],[
                'category_code'                  => 'C-00003',
                'category_name'                  => 'Elekronik',
                'parent_id'                  => null,
                'created_at'                    => Carbon::now(),
                'updated_at'                    => Carbon::now(),
            ],

        ];

        foreach ($produk as $pdata) {
            $produk = Category::create($pdata);

          }






    }








}


