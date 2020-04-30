<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->unique();

            $table->integer('created_by')->nullable();

            $table->integer('update_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
