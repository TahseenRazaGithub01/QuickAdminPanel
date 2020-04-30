<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePressesTable extends Migration
{
    public function up()
    {
        Schema::create('presses', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->string('slug');

            $table->longText('short_description');

            $table->longText('long_description');

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->integer('created_by')->nullable();

            $table->integer('update_by')->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->longText('related_links')->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('show_on_listing')->default(0)->nullable();

            $table->integer('viewed')->nullable();

            $table->integer('sort');

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
