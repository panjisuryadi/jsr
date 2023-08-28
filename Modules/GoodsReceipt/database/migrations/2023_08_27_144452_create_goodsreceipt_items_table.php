<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsreceiptItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('goodsreceipt_id');
            $table->string('code');
            $table->decimal('berat_barang', 13, 2)->default(0.01);
            $table->decimal('berat_real', 13, 2)->default(0.01);
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('qty_diterima')->nullable();
            $table->decimal('harga', 13, 2)->nullable();
            $table->foreign('goodsreceipt_id')->references('id')->on('goodsreceipts')->onDelete('cascade');
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
        Schema::dropIfExists('goodsreceipt_items');
    }
}
