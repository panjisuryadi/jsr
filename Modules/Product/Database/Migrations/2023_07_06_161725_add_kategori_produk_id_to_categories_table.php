<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddKategoriProdukIdToCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {

            $table->unsignedBigInteger('kategori_produk_id')->nullable()->after('category_code');
            $table->foreign('kategori_produk_id')->references('id')->on('kategoriproduks');
            $table->string('image')->nullable(true)->after('category_name');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
             $table->dropColumn('kategori_produk_id');
             $table->dropColumn('image');

        });
    }
}
