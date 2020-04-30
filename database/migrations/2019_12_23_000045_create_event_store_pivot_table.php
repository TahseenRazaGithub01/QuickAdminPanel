<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventStorePivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_store', function (Blueprint $table) {
            $table->unsignedInteger('event_id');

            $table->foreign('event_id', 'event_id_fk_709246')->references('id')->on('events')->onDelete('cascade');

            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_id_fk_709246')->references('id')->on('stores')->onDelete('cascade');
        });
    }
}
