<?php

namespace App\Http\Requests;

use App\AddspaceStore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreAddspaceStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('addspace_store_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'sites.*'               => [
                'integer',
            ],
            'sites'                 => [
                'required',
                'array',
            ],
            'horizontal_add_script' => [
                'required',
            ],
            'vertical_add_script'   => [
                'required',
            ],
            'stores.*'              => [
                'integer',
            ],
            'stores'                => [
                'required',
                'array',
            ],
        ];
    }
}
