<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjustedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (app()->environment() !== 'testing') {
            Schema::create('adjusted_products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('adjustment_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedBigInteger('id_location')->nullable();
                $table->unsignedBigInteger('sub_location')->nullable();
                $table->integer('quantity');
                $table->string('type');
                $table->foreign('adjustment_id')->references('id')->on('adjustments')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjusted_products');
    }
}
