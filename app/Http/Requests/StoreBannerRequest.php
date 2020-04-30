<?php

namespace App\Http\Requests;

use App\Banner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBannerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*' => [
                'integer',
            ],
            'sites'   => [
                'required',
                'array',
            ],
            /*'link'    => [
                'required',
            ],
            'image'   => [
                'required',
            ],*/
            /*'sort'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],*/
        ];
    }
}
