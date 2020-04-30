<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedInteger('network_id')->nullable();

            $table->foreign('network_id', 'network_fk_738329')->references('id')->on('networks');
        });
    }
}
