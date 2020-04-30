<?php

namespace App\Http\Requests;

use App\Event;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEventRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*'           => [
                'integer',
            ],
            'sites'             => [
                'required',
                'array',
            ],
            'title'             => [
                'required',
            ],
            'slug'              => [
                'required',
            ],
            'short_description' => [
                'required',
            ],
            'categories.*'      => [
                'integer',
            ],
            'categories'        => [
                'array',
            ],
            'stores.*'          => [
                'integer',
            ],
            'stores'            => [
                'array',
            ],
            'coupons.*'         => [
                'integer',
            ],
            'coupons'           => [
                'array',
            ],
            'date'              => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'meta_title'        => [
                'max:150',
                'required',
            ],
            'meta_keywords'     => [
                'max:200',
            ],
            'meta_description'  => [
                'max:500',
                'required',
            ],
        ];
    }
}
