<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AddspaceStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddspaceStoreRequest;
use App\Http\Requests\UpdateAddspaceStoreRequest;
use App\Http\Resources\Admin\AddspaceStoreResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddspaceStoresApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('addspace_store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddspaceStoreResource(AddspaceStore::with(['sites', 'stores'])->get());
    }

    public function store(StoreAddspaceStoreRequest $request)
    {
        $addspaceStore = AddspaceStore::create($request->all());
        $addspaceStore->sites()->sync($request->input('sites', []));
        $addspaceStore->stores()->sync($request->input('stores', []));

        return (new AddspaceStoreResource($addspaceStore))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AddspaceStore $addspaceStore)
    {
        abort_if(Gate::denies('addspace_store_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddspaceStoreResource($addspaceStore->load(['sites', 'stores']));
    }

    public function update(UpdateAddspaceStoreRequest $request, AddspaceStore $addspaceStore)
    {
        $addspaceStore->update($request->all());
        $addspaceStore->sites()->sync($request->input('sites', []));
        $addspaceStore->stores()->sync($request->input('stores', []));

        return (new AddspaceStoreResource($addspaceStore))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AddspaceStore $addspaceStore)
    {
        abort_if(Gate::denies('addspace_store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addspaceStore->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
