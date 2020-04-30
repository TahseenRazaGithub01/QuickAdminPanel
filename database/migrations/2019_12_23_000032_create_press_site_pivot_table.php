<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePressSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('press_site', function (Blueprint $table) {
            $table->unsignedInteger('press_id');

            $table->foreign('press_id', 'press_id_fk_687611')->references('id')->on('presses')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_687611')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
