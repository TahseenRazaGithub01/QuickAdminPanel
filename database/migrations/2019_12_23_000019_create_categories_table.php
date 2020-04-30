<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->string('slug')->unique();

            $table->longText('short_description');

            $table->longText('long_description');

            $table->boolean('publish')->default(0)->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->integer('sort');

            $table->integer('created_by')->nullable();

            $table->string('update_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
