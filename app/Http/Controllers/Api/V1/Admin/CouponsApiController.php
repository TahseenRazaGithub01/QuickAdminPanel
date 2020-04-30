<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Resources\Admin\CouponResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponsApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponResource(Coupon::with(['sites', 'categories', 'store', 'coupon'])->get());
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->all());
        $coupon->sites()->sync($request->input('sites', []));
        $coupon->categories()->sync($request->input('categories', []));

        if ($request->input('image', false)) {
            $coupon->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        return (new CouponResource($coupon))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponResource($coupon->load(['sites', 'categories', 'store', 'coupon']));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());
        $coupon->sites()->sync($request->input('sites', []));
        $coupon->categories()->sync($request->input('categories', []));

        if ($request->input('image', false)) {
            if (!$coupon->image || $request->input('image') !== $coupon->image->file_name) {
                $coupon->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($coupon->image) {
            $coupon->image->delete();
        }

        return (new CouponResource($coupon))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
