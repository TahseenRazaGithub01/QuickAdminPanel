<?php

namespace App\Http\Requests;

use App\Coupon;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCouponRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*'            => [
                'integer',
            ],
            'sites'              => [
                'required',
                'array',
            ],
            'title'              => [
                'required',
            ],
            'store_id'           => [
                'required',
                'integer',
            ],
            'date_available'        => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'date_expiry'        => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            /*'description'        => [
                'required',
            ],
            'sort'               => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'date_available'     => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'categories.*'       => [
                'integer',
            ],
            'categories'         => [
                'array',
            ],*/
            /*'special_event_sort' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],*/
        ];
    }
}
