<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSpaceProductSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('add_space_product_site', function (Blueprint $table) {
            $table->unsignedInteger('add_space_product_id');

            $table->foreign('add_space_product_id', 'add_space_product_id_fk_696207')->references('id')->on('add_space_products')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_696207')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
