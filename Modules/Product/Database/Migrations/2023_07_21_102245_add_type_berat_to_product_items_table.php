<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeBeratToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_items', function (Blueprint $table) {
              $table->decimal('berat_total', 10, 4)->nullable()->after('gudang');
              $table->decimal('berat_emas', 10, 4)->nullable()->after('berat_total');
              $table->decimal('berat_accessories', 10, 4)->nullable()->after('berat_emas');
              $table->decimal('berat_label', 10, 4)->nullable()->after('berat_accessories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_items', function (Blueprint $table) {
         // $table->dropColumn('models_id');
         $table->dropColumn('berat_total');
         $table->dropColumn('berat_accessories');
         $table->dropColumn('berat_label');
         $table->dropColumn('berat_emas');
        });
    }
}
