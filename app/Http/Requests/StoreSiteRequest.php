<?php

namespace App\Http\Requests;

use App\Site;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreSiteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('site_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'         => [
                'required',
            ],
            'country_name' => [
                'required',
            ],
            'country_code' => [
                'required',
            ],
            'flag'         => [
                'required',
            ],
            'url'          => [
                'required',
            ],
            'logo'         => [
                'required',
            ],
            'favicon'      => [
                'required',
            ],
        ];
    }
}
