<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomsCt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customs_ct', function (Blueprint $table) {
            $table->id();
            $table->double('berat', 12, 3, true)->nullable();
            $table->integer('harga');
            $table->timestamps();
            $table->unsignedBigInteger('customs_id');
            $table->foreign('customs_id')->references('id')->on('customs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customs_ct');
    }
}
