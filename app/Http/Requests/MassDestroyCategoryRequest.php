<?php

namespace App\Http\Requests;

use App\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'unique:categories,slug,' . request()->route('category')->id,
            ],
            'short_description' => [
                'required',
            ],
            'sort'              => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'meta_title'        => [
                'required',
            ],
            'meta_keywords'     => [
                'required',
            ],
            'meta_description'  => [
                'required',
            ],
        ];
    }
}
