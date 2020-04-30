<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductStorePivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_store', function (Blueprint $table) {
            $table->unsignedInteger('product_id');

            $table->foreign('product_id', 'product_id_fk_756877')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_id_fk_756877')->references('id')->on('stores')->onDelete('cascade');
        });
    }
}
