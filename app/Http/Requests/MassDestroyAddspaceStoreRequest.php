<?php

namespace App\Http\Requests;

use App\AddspaceStore;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyAddspaceStoreRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('addspace_store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:addspace_stores,id',
        ];
    }
}
