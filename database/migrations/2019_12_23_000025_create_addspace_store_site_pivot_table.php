<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddspaceStoreSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('addspace_store_site', function (Blueprint $table) {
            $table->unsignedInteger('addspace_store_id');

            $table->foreign('addspace_store_id', 'addspace_store_id_fk_696201')->references('id')->on('addspace_stores')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_696201')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
