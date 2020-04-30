<?php

namespace App\Http\Requests;

use App\AddSpaceProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAddSpaceProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('add_space_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'horizontal_script' => [
                'required',
            ],
            'vertical_script'   => [
                'required',
            ],
            'products.*'        => [
                'integer',
            ],
            'products'          => [
                'required',
                'array',
            ],
        ];
    }
}
