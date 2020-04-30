<?php

namespace App\Http\Requests;

use App\ProductCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreProductCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            /*'name'              => [
                'required',
            ],
            'title_heading'     => [
                'required',
            ],
            'slug'              => [
                'required',
            ],
            'description'       => [
                'required',
            ],
            'about_description' => [
                'required',
            ],
            'sort'              => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'image'             => [
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
