<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->longText('short_description');

            $table->longText('long_description')->nullable();

            $table->string('rating')->nullable();

            $table->string('affiliate_url')->nullable();

            $table->date('date')->nullable();

            $table->string('price')->nullable();

            $table->string('discount_price')->nullable();

            $table->string('discount_percent')->nullable();

            $table->integer('sort')->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->integer('viewed')->nullable();

            $table->string('custom_image_title')->nullable();

            $table->string('code')->nullable();

            $table->boolean('best')->default(0)->nullable();

            $table->boolean('latest')->default(0)->nullable();

            $table->boolean('home_featured')->default(0)->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
