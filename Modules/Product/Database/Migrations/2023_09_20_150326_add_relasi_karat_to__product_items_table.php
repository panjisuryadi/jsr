<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelasiKaratToProductItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

<<<<<<< Updated upstream
        // Schema::table('product_items', function (Blueprint $table) {
        //       DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //      $table->foreign('karat_id')->references('id')->on('karats');
        //       DB::statement('SET FOREIGN_KEY_CHECKS=1;');
=======
        Schema::table('product_items', function (Blueprint $table) {
              DB::statement('SET FOREIGN_KEY_CHECKS=0;');
             $table->foreign('karat_id')->references('id')->on('karats');
              DB::statement('SET FOREIGN_KEY_CHECKS=1;');
>>>>>>> Stashed changes

        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('_product_items', function (Blueprint $table) {

        // });
    }
}
