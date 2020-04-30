<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('title_heading');

            $table->string('sub_heading')->nullable();

            $table->string('slug');

            $table->longText('description');

            $table->longText('about_description');

            $table->longText('long_description')->nullable();

            $table->integer('sort')->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->string('old_url')->nullable();

            $table->string('new_url')->nullable();

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->string('template')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
