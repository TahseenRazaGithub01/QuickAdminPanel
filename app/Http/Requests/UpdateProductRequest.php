<?php

namespace App\Http\Requests;

use App\Product;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*'              => [
                'integer',
            ],
            'sites'                => [
                'required',
                'array',
            ],
            'product_categories.*' => [
                'integer',
            ],
            'product_categories'   => [
                'required',
                'array',
            ],
            'title'                => [
                'required',
            ],
            'short_description'    => [
                'required',
            ],
            'stores.*'             => [
                'integer',
            ],
            'stores'               => [
                'array',
            ],
            'date'                 => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'sort'                 => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
