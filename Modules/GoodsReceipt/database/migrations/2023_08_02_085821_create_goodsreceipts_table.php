<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodsreceipts', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->string('no_invoice');
            $table->decimal('berat_barang', 5, 2)->default(0.01);
            $table->decimal('berat_real', 5, 2)->default(0.01);
            $table->bigInteger('qty')->nullable();
            $table->bigInteger('qty_diterima')->nullable();
            $table->string('pengirim')->nullable();
            $table->text('note')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
           
            $table->foreign('user_id')->references('id')
            ->on('users')->nullOnDelete();

            $table->foreign('supplier_id')->references('id')
            ->on('suppliers')->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goodsreceipts');
    }
};
