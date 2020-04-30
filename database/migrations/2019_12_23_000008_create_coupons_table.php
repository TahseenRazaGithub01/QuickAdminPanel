<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');

            $table->longText('description');

            $table->string('affiliate_url')->nullable();

            $table->boolean('verified')->default(0)->nullable();

            $table->integer('sort')->nullable();

            $table->date('date_available')->nullable();

            $table->date('date_expiry')->nullable();

            $table->boolean('exclusive')->default(0)->nullable();

            $table->boolean('featured')->default(0)->nullable();

            $table->boolean('popular')->default(0)->nullable();

            $table->boolean('publish')->default(0)->nullable();

            $table->boolean('free_shipping')->default(0)->nullable();

            $table->string('code')->nullable();

            $table->integer('special_event_sort')->nullable();

            $table->string('type')->nullable();

            $table->string('custom_image_title')->nullable();

            $table->timestamps();

            $table->softDeletes();
        });
    }
}
