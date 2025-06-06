<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuysBackDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys_back_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->string('product_name');
            $table->string('product_code');
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('unit_price');
            $table->integer('sub_total');
            $table->integer('product_discount_amount');
            $table->string('product_discount_type')->default('fixed');
            $table->integer('product_tax_amount');
            $table->foreign('purchase_id')->references('id')->on('buysbacks')->cascadeOnDelete();
            $table->foreign('product_id')->references('id')->on('products')->nullOnDelete();

           $table->foreign('location_id')->references('id')->on('locations')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys_back_details');
    }
}
