<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryStorePivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_store', function (Blueprint $table) {
            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_id_fk_709293')->references('id')->on('stores')->onDelete('cascade');

            $table->unsignedInteger('category_id');

            $table->foreign('category_id', 'category_id_fk_709293')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
