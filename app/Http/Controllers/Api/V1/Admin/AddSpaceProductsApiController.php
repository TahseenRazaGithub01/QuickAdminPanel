<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AddSpaceProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddSpaceProductRequest;
use App\Http\Requests\UpdateAddSpaceProductRequest;
use App\Http\Resources\Admin\AddSpaceProductResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddSpaceProductsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('add_space_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddSpaceProductResource(AddSpaceProduct::with(['sites', 'products'])->get());
    }

    public function store(StoreAddSpaceProductRequest $request)
    {
        $addSpaceProduct = AddSpaceProduct::create($request->all());
        $addSpaceProduct->sites()->sync($request->input('sites', []));
        $addSpaceProduct->products()->sync($request->input('products', []));

        return (new AddSpaceProductResource($addSpaceProduct))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AddSpaceProduct $addSpaceProduct)
    {
        abort_if(Gate::denies('add_space_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AddSpaceProductResource($addSpaceProduct->load(['sites', 'products']));
    }

    public function update(UpdateAddSpaceProductRequest $request, AddSpaceProduct $addSpaceProduct)
    {
        $addSpaceProduct->update($request->all());
        $addSpaceProduct->sites()->sync($request->input('sites', []));
        $addSpaceProduct->products()->sync($request->input('products', []));

        return (new AddSpaceProductResource($addSpaceProduct))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AddSpaceProduct $addSpaceProduct)
    {
        abort_if(Gate::denies('add_space_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $addSpaceProduct->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
