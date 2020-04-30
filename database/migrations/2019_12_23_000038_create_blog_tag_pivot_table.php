<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogTagPivotTable extends Migration
{
    public function up()
    {
        Schema::create('blog_tag', function (Blueprint $table) {
            $table->unsignedInteger('blog_id');

            $table->foreign('blog_id', 'blog_id_fk_691683')->references('id')->on('blogs')->onDelete('cascade');

            $table->unsignedInteger('tag_id');

            $table->foreign('tag_id', 'tag_id_fk_691683')->references('id')->on('tags')->onDelete('cascade');
        });
    }
}
