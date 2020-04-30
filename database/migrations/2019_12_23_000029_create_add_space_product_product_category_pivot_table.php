<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSpaceProductProductCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('add_space_product_product_category', function (Blueprint $table) {
            $table->unsignedInteger('add_space_product_id');

            $table->foreign('add_space_product_id', 'add_space_product_id_fk_696210')->references('id')->on('add_space_products')->onDelete('cascade');

            $table->unsignedInteger('product_category_id');

            $table->foreign('product_category_id', 'product_category_id_fk_696210')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }
}
