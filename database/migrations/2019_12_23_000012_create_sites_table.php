<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('country_name');

            $table->string('country_code');

            $table->string('url');

            $table->longText('html_tags')->nullable();

            $table->longText('javascript_tags')->nullable();

            $table->string('twitter')->nullable();

            $table->string('linked_in')->nullable();

            $table->string('facebook')->nullable();

            $table->string('youtube')->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
