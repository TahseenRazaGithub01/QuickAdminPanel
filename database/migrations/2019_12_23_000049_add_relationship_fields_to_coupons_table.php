<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCouponsTable extends Migration
{
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger('coupon_id')->nullable();

            $table->foreign('coupon_id', 'coupon_fk_687309')->references('id')->on('coupons');

            $table->unsignedInteger('store_id');

            $table->foreign('store_id', 'store_fk_751419')->references('id')->on('stores');
        });
    }
}
