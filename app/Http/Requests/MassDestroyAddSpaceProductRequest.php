<?php

namespace App\Http\Requests;

use App\AddSpaceProduct;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAddSpaceProductRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('add_space_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:add_space_products,id',
        ];
    }
}
