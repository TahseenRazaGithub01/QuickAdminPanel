<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponEventPivotTable extends Migration
{
    public function up()
    {
        Schema::create('coupon_event', function (Blueprint $table) {
            $table->unsignedInteger('event_id');

            $table->foreign('event_id', 'event_id_fk_709247')->references('id')->on('events')->onDelete('cascade');

            $table->unsignedInteger('coupon_id');

            $table->foreign('coupon_id', 'coupon_id_fk_709247')->references('id')->on('coupons')->onDelete('cascade');
        });
    }
}
