<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('blog_site', function (Blueprint $table) {
            $table->unsignedInteger('blog_id');

            $table->foreign('blog_id', 'blog_id_fk_699782')->references('id')->on('blogs')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_699782')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
