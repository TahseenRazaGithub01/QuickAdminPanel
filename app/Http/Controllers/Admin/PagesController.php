<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPageRequest;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Page;
use App\Site;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PagesController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    public $table = 'pages';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'page/';
    protected $page_type    = 'page';

    public function index()
    {
        abort_if(Gate::denies('page_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $pages = Page::with('sites');

        if(isset(request()->pid)) {
            $pages = $pages->where('id', request()->pid);
        }

        $pages = $pages->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        abort_if(Gate::denies('page_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        return view('admin.pages.create', compact('sites'));
    }

    public function store(StorePageRequest $request)
    {
        $page = Page::create($request->all());
        $page->sites()->sync($request->input('sites', []));

        $last_id    = $page->id;
        $slug       = $page->slug;

        $return = $this->slug->insertSlug($last_id, $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('banner_image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('banner_image','s3');
            }

            if ($request->input('image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('additional_image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('additional_image','s3');
            }

        } else {

            if ($request->input('banner_image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')));
            }

            if ($request->input('image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('additional_image', false)) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.pages.index') . $request->test_id;
        } else {
            $url = route('admin.pages.index');
        }

        return redirect($url);
    }

    public function edit(Page $page)
    {
        abort_if(Gate::denies('page_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $page->load('sites');

        return view('admin.pages.edit', compact('sites', 'page'));
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page->update($request->all());
        $page->sites()->sync($request->input('sites', []));

        $id         = $page->id;
        $slug       = $page->slug;

        $return = $this->slug->updateSlug($id, $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('banner_image', false)) {
            if (!$page->banner_image || $request->input('banner_image') !== $page->banner_image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('banner_image','s3');
            }
        } elseif ($page->banner_image) {
            $page->banner_image->delete();
        }

        if ($request->input('image', false)) {
            if (!$page->image || $request->input('image') !== $page->image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }
        } elseif ($page->image) {
            $page->image->delete();
        }

        if ($request->input('additional_image', false)) {
            if (!$page->additional_image || $request->input('additional_image') !== $page->additional_image->file_name) {
                $page->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('additional_image','s3');
            }
        } elseif ($page->additional_image) {
            $page->additional_image->delete();
        }

        if(isset($request->test_id)) {
            $url = route('admin.pages.index') . $request->test_id;
        } else {
            $url = route('admin.pages.index');
        }

        return redirect($url);
    }

    public function show(Page $page)
    {
        abort_if(Gate::denies('page_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $page->load('sites');

        return view('admin.pages.show', compact('page'));
    }

    public function destroy(Page $page)
    {
        abort_if(Gate::denies('page_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $page->delete();
        $this->slug->deleteSlug($page->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyPageRequest $request)
    {
        Page::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
