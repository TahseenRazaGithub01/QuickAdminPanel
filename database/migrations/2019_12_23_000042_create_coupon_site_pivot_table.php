<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponSitePivotTable extends Migration
{
    public function up()
    {
        Schema::create('coupon_site', function (Blueprint $table) {
            $table->unsignedInteger('coupon_id');

            $table->foreign('coupon_id', 'coupon_id_fk_686748')->references('id')->on('coupons')->onDelete('cascade');

            $table->unsignedInteger('site_id');

            $table->foreign('site_id', 'site_id_fk_686748')->references('id')->on('sites')->onDelete('cascade');
        });
    }
}
