<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePressRequest;
use App\Http\Requests\UpdatePressRequest;
use App\Http\Resources\Admin\PressResource;
use App\Press;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PressApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('press_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PressResource(Press::with(['sites'])->get());
    }

    public function store(StorePressRequest $request)
    {
        $press = Press::create($request->all());
        $press->sites()->sync($request->input('sites', []));

        if ($request->input('image', false)) {
            $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
        }

        return (new PressResource($press))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Press $press)
    {
        abort_if(Gate::denies('press_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PressResource($press->load(['sites']));
    }

    public function update(UpdatePressRequest $request, Press $press)
    {
        $press->update($request->all());
        $press->sites()->sync($request->input('sites', []));

        if ($request->input('image', false)) {
            if (!$press->image || $request->input('image') !== $press->image->file_name) {
                $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($press->image) {
            $press->image->delete();
        }

        return (new PressResource($press))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Press $press)
    {
        abort_if(Gate::denies('press_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $press->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
