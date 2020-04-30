<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->longText('short_description');

            $table->longText('long_description');

            $table->boolean('publish')->default(0)->nullable();

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->integer('sort');

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->integer('view')->nullable();

            $table->integer('created_by')->nullable();

            $table->integer('update_by')->nullable();

            $table->string('slug');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
