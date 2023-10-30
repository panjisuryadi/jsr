<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateColumnsDatatypeToStockOfficeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `stock_office` MODIFY `berat_real` DOUBLE(12,3)');
        DB::statement('ALTER TABLE `stock_office` MODIFY `berat_kotor` DOUBLE(12,3)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `stock_office` MODIFY `berat_real` DECIMAL(12,3)');
        DB::statement('ALTER TABLE `stock_office` MODIFY `berat_kotor` DECIMAL(12,3)');
    }
}
