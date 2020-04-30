<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddspaceStoreStorePivotTable extends Migration
{
    public function up()
    {
        Schema::create('addspace_store_store', function (Blueprint $table) {
            $table->unsignedInteger('addspace_store_id');

            $table->foreign('addspace_store_id', 'addspace_store_id_fk_696126')->references('id')->on('addspace_stores')->onDelete('cascade');

            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_id_fk_696126')->references('id')->on('stores')->onDelete('cascade');
        });
    }
}
