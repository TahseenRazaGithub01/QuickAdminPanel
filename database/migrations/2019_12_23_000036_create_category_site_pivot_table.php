<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategorySitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_site', function (Blueprint $table) {
            $table->unsignedInteger('category_id');

            $table->foreign('category_id', 'category_id_fk_682016')->references('id')->on('categories')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_682016')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
