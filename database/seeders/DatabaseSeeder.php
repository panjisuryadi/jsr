<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\People\Database\Seeders\PeopleDatabaseSeeder;
use Modules\Currency\Database\Seeders\CurrencyDatabaseSeeder;
use Modules\Setting\Database\Seeders\SettingDatabaseSeeder;
use Modules\User\Database\Seeders\PermissionsTableSeeder;
use Modules\Product\Database\Seeders\CategoriesDatabaseSeeder;
use Modules\Product\Database\Seeders\ProductDatabaseSeeder;
use Modules\Locations\Database\Seeders\LocationsDatabaseSeeder;
use Modules\Locations\Database\Seeders\UsersLocationsDatabaseSeeder;
use Modules\KategoriBerlian\database\seeders\KategoriBerlianDatabaseSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        $this->call(CategoriesDatabaseSeeder::class);
        $this->call(ProductDatabaseSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(SuperUserSeeder::class);
        $this->call(CurrencyDatabaseSeeder::class);
        $this->call(SettingDatabaseSeeder::class);
        $this->call(PeopleDatabaseSeeder::class);
        $this->call(LocationsDatabaseSeeder::class);
        $this->call(UsersLocationsDatabaseSeeder::class);
        $this->call(KategoriBerlianDatabaseSeeder::class);
    }
}
