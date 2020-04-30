<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Http\Resources\Admin\ProductCategoryResource;
use App\ProductCategory;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductCategoryApiController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    public $table           = 'product_categories';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = '';
    protected $page_type    = 'productCategory';

    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductCategoryResource(ProductCategory::with(['sites', 'parent'])->get());
    }


    public function store(StoreProductCategoryRequest $request)
    {
        $productCategory = ProductCategory::create($request->all());
        $productCategory->sites()->sync($request->input('sites', []));

        $last_id    = $productCategory->id;
        $slug       = $productCategory->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            $productCategory->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        return (new ProductCategoryResource($productCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductCategoryResource($productCategory->load(['sites', 'parent']));
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->all());
        $productCategory->sites()->sync($request->input('sites', []));

        $last_id    = $productCategory->id;
        $slug       = $productCategory->slug;

        $return = $this->slug->updateSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            if (!$productCategory->image || $request->input('image') !== $productCategory->image->file_name) {
                /*$productCategory->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');*/
                $productCategory->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
            }
        } elseif ($productCategory->image) {
            $productCategory->image->delete();
        }

        return (new ProductCategoryResource($productCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
