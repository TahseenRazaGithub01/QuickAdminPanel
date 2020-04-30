<?php

namespace App\Http\Requests;

use App\Store;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'name'              => [
                'required',
            ],
            /*'slug'              => [
                'required',
            ],
            'categories.*'      => [
                'integer',
            ],
            'categories'        => [
                'array',
            ],
            'short_description' => [
                'required',
            ],
            'long_description'  => [
                'required',
            ],
            'store_url'         => [
                'required',
            ],
            'image'             => [
                'required',
            ],
            'sort'              => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'publish'           => [
                'required',
            ],
            'meta_title'        => [
                'max:150',
                'required',
            ],
            'meta_keywords'     => [
                'max:200',
                'required',
            ],
            'meta_description'  => [
                'max:500',
                'required',
            ],*/
        ];
    }
}
