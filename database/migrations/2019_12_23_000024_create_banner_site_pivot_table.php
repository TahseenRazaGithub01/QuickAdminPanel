<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('banner_site', function (Blueprint $table) {
            $table->unsignedInteger('banner_id');

            $table->foreign('banner_id', 'banner_id_fk_697389')->references('id')->on('banners')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_697389')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
