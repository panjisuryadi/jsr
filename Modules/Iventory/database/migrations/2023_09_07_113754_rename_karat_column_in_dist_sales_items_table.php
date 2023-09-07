<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameKaratColumnInDistSalesItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dist_sales_items', function (Blueprint $table) {
            $table->renameColumn('karat', 'harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dist_sales_items', function (Blueprint $table) {
            $table->renameColumn('harga', 'karat');
        });
    }
}
