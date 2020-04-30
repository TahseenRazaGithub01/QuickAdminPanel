<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddspaceStoresTable extends Migration
{
    public function up()
    {
        Schema::create('addspace_stores', function (Blueprint $table) {
            $table->increments('id');

            $table->longText('horizontal_add_script');

            $table->longText('vertical_add_script');

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
