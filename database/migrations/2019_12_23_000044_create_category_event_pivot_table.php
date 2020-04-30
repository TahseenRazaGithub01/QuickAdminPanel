<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryEventPivotTable extends Migration
{
    public function up()
    {
        Schema::create('category_event', function (Blueprint $table) {
            $table->unsignedInteger('event_id');

            $table->foreign('event_id', 'event_id_fk_687295')->references('id')->on('events')->onDelete('cascade');

            $table->unsignedInteger('category_id');

            $table->foreign('category_id', 'category_id_fk_687295')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
