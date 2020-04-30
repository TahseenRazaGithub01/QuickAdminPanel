<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Http\Resources\Admin\StoreResource;
use App\Store;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StoresApiController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    public $table           = 'stores';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = '';
    protected $page_type    = 'stores';

    public function index()
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StoreResource(Store::with(['sites', 'categories', 'network'])->get());
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create($request->all());
        $store->sites()->sync($request->input('sites', []));
        $store->categories()->sync($request->input('categories', []));

        $last_id    = $store->id;
        $slug       = $store->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }


        if ($request->input('image', false)) {
            $store->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        return (new StoreResource($store))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Store $store)
    {
        abort_if(Gate::denies('store_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new StoreResource($store->load(['sites', 'categories', 'network']));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update($request->all());
        $store->sites()->sync($request->input('sites', []));
        $store->categories()->sync($request->input('categories', []));

        if ($request->input('image', false)) {
            if (!$store->image || $request->input('image') !== $store->image->file_name) {
                $store->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($store->image) {
            $store->image->delete();
        }

        return (new StoreResource($store))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Store $store)
    {
        abort_if(Gate::denies('store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $store->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
