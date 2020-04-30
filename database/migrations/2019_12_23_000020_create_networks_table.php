<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNetworksTable extends Migration
{
    public function up()
    {
        Schema::create('networks', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->string('api_key');

            $table->string('secret_key')->nullable();

            $table->string('affiliate')->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->integer('created_by')->nullable();

            $table->integer('updated_by')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
