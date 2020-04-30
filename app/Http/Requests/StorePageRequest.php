<?php

namespace App\Http\Requests;

use App\Page;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StorePageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*'          => [
                'integer',
            ],
            'sites'            => [
                'required',
                'array',
            ],
            'slug'             => [
                'required',
            ],
            /*'meta_title'       => [
                'max:150',
                'required',
            ],
            'meta_keywords'    => [
                'max:200',
                'required',
            ],
            'meta_description' => [
                'max:500',
                'required',
            ],*/
        ];
    }
}
