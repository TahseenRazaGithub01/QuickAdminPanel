<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoryPivotTable extends Migration
{
    public function up()
    {
        Schema::create('blog_category', function (Blueprint $table) {
            $table->unsignedInteger('blog_id');

            $table->foreign('blog_id', 'blog_id_fk_658637')->references('id')->on('blogs')->onDelete('cascade');

            $table->unsignedInteger('category_id');

            $table->foreign('category_id', 'category_id_fk_658637')->references('id')->on('categories')->onDelete('cascade');
        });
    }
}
