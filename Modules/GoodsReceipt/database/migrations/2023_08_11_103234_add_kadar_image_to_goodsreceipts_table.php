<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKadarImageToGoodsreceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {
            $table->string('images')->nullable()->after('user_id');
            $table->unsignedBigInteger('parameter_kadar_id')
            ->nullable()->after('images');
            
            $table->foreign('parameter_kadar_id')->references('id')
            ->on('parameterkadars')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goodsreceipts', function (Blueprint $table) {

        });
    }
}
