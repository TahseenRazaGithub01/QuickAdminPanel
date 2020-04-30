<?php

namespace App\Http\Requests;

use App\Blog;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBlogRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('blog_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'long_description'  => [
                'required',
            ],
            'image'             => [
                'required',
            ],
            'sort'              => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'categories.*'      => [
                'integer',
            ],
            'categories'        => [
                'array',
                'required',
            ],
            'tags.*'            => [
                'integer',
            ],
            'tags'              => [
                'array',
            ],
            'meta_title'        => [
                'max:200',
                'required',
            ],
            'meta_keywords'     => [
                'max:150',
                'required',
            ],
            'meta_description'  => [
                'max:500',
                'required',
            ],
        ];
    }
}
