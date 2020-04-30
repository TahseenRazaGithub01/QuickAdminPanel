<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();

            $table->longText('description')->nullable();

            $table->string('slug');

            $table->boolean('publish')->default(0)->nullable();

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
