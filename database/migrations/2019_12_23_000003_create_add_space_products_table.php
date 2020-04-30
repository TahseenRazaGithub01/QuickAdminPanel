<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddSpaceProductsTable extends Migration
{
    public function up()
    {
        Schema::create('add_space_products', function (Blueprint $table) {
            $table->increments('id');

            $table->longText('horizontal_script');

            $table->longText('vertical_script');

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
