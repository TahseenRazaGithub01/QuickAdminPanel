<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\Admin\PageResource;
use App\Page;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesApiController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    public $table           = 'pages';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = '';
    protected $page_type    = 'pages';

    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PageResource(Page::with(['sites'])->get());
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->all());
        $page->sites()->sync($request->input('sites', []));

        $last_id    = $page->id;
        $slug       = $page->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            $category->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        if ($request->input('banner_image', false)) {
            $page->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->toMediaCollection('banner_image');
        }

        if ($request->input('additional_image', false)) {
            $page->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->toMediaCollection('additional_image');
        }

        return (new PageResource($page))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PageResource($page->load(['sites']));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->all());
        $page->sites()->sync($request->input('sites', []));

        if ($request->input('banner_image', false)) {
            if (!$page->banner_image || $request->input('banner_image') !== $page->banner_image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->toMediaCollection('banner_image');
            }
        } elseif ($page->banner_image) {
            $page->banner_image->delete();
        }

        if ($request->input('image', false)) {
            if (!$page->image || $request->input('image') !== $page->image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($page->image) {
            $page->image->delete();
        }

        if ($request->input('additional_image', false)) {
            if (!$page->additional_image || $request->input('additional_image') !== $page->additional_image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->toMediaCollection('additional_image');
            }
        } elseif ($page->additional_image) {
            $page->additional_image->delete();
        }

        return (new PageResource($page))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $page->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
