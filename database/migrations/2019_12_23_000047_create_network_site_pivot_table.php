<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworkSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('network_site', function (Blueprint $table) {
            $table->unsignedInteger('network_id');

            $table->foreign('network_id', 'network_id_fk_697402')->references('id')->on('networks')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_697402')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
