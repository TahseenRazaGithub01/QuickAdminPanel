<?php

namespace App\Http\Requests;

use App\Press;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdatePressRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('press_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'short_description' => [
                'required',
            ],
            'slug'              => [
                'required',
            ],
            'sort'              => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'long_description'  => [
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
            ],
        ];
    }
}
