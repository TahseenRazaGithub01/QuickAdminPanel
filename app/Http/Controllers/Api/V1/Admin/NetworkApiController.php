<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNetworkRequest;
use App\Http\Requests\UpdateNetworkRequest;
use App\Http\Resources\Admin\NetworkResource;
use App\Network;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NetworkApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('network_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NetworkResource(Network::with(['sites'])->get());
    }

    public function store(StoreNetworkRequest $request)
    {
        $network = Network::create($request->all());
        $network->sites()->sync($request->input('sites', []));

        return (new NetworkResource($network))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Network $network)
    {
        abort_if(Gate::denies('network_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new NetworkResource($network->load(['sites']));
    }

    public function update(UpdateNetworkRequest $request, Network $network)
    {
        $network->update($request->all());
        $network->sites()->sync($request->input('sites', []));

        return (new NetworkResource($network))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Network $network)
    {
        abort_if(Gate::denies('network_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $network->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
