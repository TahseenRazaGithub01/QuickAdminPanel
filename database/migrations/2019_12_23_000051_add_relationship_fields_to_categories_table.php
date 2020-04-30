<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('parent_id')->nullable();

            $table->foreign('parent_id', 'parent_fk_681782')->references('id')->on('categories');

            $table->unsignedInteger('user_id')->nullable();

            $table->foreign('user_id', 'user_fk_681787')->references('id')->on('users');
        });
    }
}
