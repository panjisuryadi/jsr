<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockKroomHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_kroom_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_kroom_id')->constrained('stock_kroom');
            $table->morphs('transaction');
            $table->boolean('in');
            $table->foreignId('karat_id')->constrained('karats');
            $table->double('berat_real',12,3);
            $table->double('berat_kotor',12,3);
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
        Schema::dropIfExists('stock_kroom_history');
    }
}
