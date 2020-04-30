<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->longText('short_description');

            $table->longText('long_description');

            $table->string('store_url');

            $table->string('affiliate_url')->nullable();

            $table->integer('sort')->nullable();

            $table->longText('faq')->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->boolean('publish')->default(0);

            $table->longText('html_tags')->nullable();

            $table->longText('script_tags')->nullable();

            $table->integer('viewed')->nullable();

            $table->string('meta_title');

            $table->string('meta_keywords');

            $table->string('meta_description', 250);

            $table->integer('scrap_store')->nullable();

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->string('slug');

            $table->string('template')->nullable();

            $table->string('old_url')->nullable();

            $table->string('new_url')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
