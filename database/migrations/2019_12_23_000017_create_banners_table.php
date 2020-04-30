<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->nullable();

            $table->string('link');

            $table->integer('sort');

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
