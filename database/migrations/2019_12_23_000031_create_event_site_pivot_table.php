<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('event_site', function (Blueprint $table) {
            $table->unsignedInteger('event_id');

            $table->foreign('event_id', 'event_id_fk_687612')->references('id')->on('events')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_687612')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
