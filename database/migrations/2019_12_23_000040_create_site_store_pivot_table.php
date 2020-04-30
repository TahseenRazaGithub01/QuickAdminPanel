<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteStorePivotTable extends Migration
{
    public function up()
    {
        Schema::create('site_store', function (Blueprint $table) {
            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_id_fk_686417')->references('id')->on('stores')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_686417')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
