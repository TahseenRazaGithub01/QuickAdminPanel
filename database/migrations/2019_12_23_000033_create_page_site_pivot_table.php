<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('page_site', function (Blueprint $table) {
            $table->unsignedInteger('page_id');

            $table->foreign('page_id', 'page_id_fk_687610')->references('id')->on('pages')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_687610')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
