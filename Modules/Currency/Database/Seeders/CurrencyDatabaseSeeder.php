<?php

namespace Modules\Currency\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Currency\Entities\Currency;

class CurrencyDatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Currency::create([
            'currency_name'      => 'Rupiah',
            'code'               => Str::upper('IDR'),
            'symbol'             => 'Rp. ',
            'thousand_separator' => '.',
            'decimal_separator'  => '.',
            'exchange_rate'      => null
        ]);
    }
}
