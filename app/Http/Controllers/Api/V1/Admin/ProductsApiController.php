<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Product;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsApiController extends Controller
{
    use MediaUploadingTrait;


    public function index()
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource(Product::with(['sites', 'product_categories', 'stores'])->get());
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->sites()->sync($request->input('sites', []));
        $product->product_categories()->sync($request->input('product_categories', []));
        $product->stores()->sync($request->input('stores', []));

        if ($request->input('image', false)) {
            $product->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        if ($request->input('additional_image', false)) {
            $product->addMediaFromUrl($request->input('additional_image'))->toMediaCollection('additional_image');
        }

        

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductResource($product->load(['sites', 'product_categories', 'stores']));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $product->sites()->sync($request->input('sites', []));
        $product->product_categories()->sync($request->input('product_categories', []));
        $product->stores()->sync($request->input('stores', []));

        if ($request->input('image', false)) {
            if (!$product->image || $request->input('image') !== $product->image->file_name) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($product->image) {
            $product->image->delete();
        }

        if ($request->input('additional_image', false)) {
            if (!$product->additional_image || $request->input('additional_image') !== $product->additional_image->file_name) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->toMediaCollection('additional_image');
            }
        } elseif ($product->additional_image) {
            $product->additional_image->delete();
        }

        return (new ProductResource($product))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
