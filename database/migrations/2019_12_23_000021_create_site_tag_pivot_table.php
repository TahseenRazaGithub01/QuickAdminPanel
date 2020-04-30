<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('site_tag', function (Blueprint $table) {
            $table->unsignedInteger('tag_id');

            $table->foreign('tag_id', 'tag_id_fk_691486')->references('id')->on('tags')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_691486')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
