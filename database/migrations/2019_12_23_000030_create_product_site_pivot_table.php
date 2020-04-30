<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('product_site', function (Blueprint $table) {
            $table->unsignedInteger('product_id');

            $table->foreign('product_id', 'product_id_fk_709244')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_709244')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
