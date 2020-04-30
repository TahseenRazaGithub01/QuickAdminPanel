<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategorySitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_category_site', function (Blueprint $table) {
            $table->unsignedInteger('product_category_id');

            $table->foreign('product_category_id', 'product_category_id_fk_691717')->references('id')->on('product_categories')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_691717')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
