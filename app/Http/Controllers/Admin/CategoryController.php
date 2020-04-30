<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Slug;
use App\Site;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'categories/';
    protected $page_type    = 'categories';
    protected $table   = 'categories';

    public function index(Request $request)
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Category::with(['sites'])->select(sprintf('%s.*', (new Category)->table));

            if(isset($request->cid)) {
                $query = $query->where('id', $request->cid);
            }

            $query->whereHas('sites', function($q) use($request) {
                if($request->siteId != 'all') {
                    if($request->siteId != 'all') {
                        if(!empty($request->siteId)) {
                            $q->where('site_id', $request->siteId);
                        } elseif (isset(request()->test_id)) {
                            $q->where('site_id', request()->test_id);
                        } else {
                            $q->where('site_id', getSiteID());
                        }
                    }
                }
            });

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'category_show';
                $editGate      = 'category_edit';
                $deleteGate    = 'category_delete';
                $crudRoutePart = 'categories';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('site', function ($row) {
                $labels = [];

                foreach ($row->sites as $site) {
                    $labels[] = sprintf('<span class="badge badge-info">%s</span>', $site->country_name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('sort', function ($row) {
                return $row->sort ? $row->sort : "";
            });

            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->publish ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'title', 'publish']);

            return $table->make(true);
        }

        return view('admin.categories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $parents = Category::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.categories.create', compact('sites', 'parents'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());
        $category->sites()->sync($request->input('sites', []));

        $last_id    = $category->id;
        $slug       = $category->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('icon', false)) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('icon')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('icon','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('icon', false)) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('icon')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.categories.index') . $request->test_id;
        } else {
            $url = route('admin.categories.index');
        }

        return redirect($url);
    }

    public function edit(Category $category)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $parents = Category::with('sites')->whereHas('sites', function($q) use($category) {
            if($category->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $category->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $category->load('sites', 'parent', 'user');

        return view('admin.categories.edit', compact('sites', 'parents', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());
        $category->sites()->sync($request->input('sites', []));

        $last_id    = $category->id;
        $slug       = $category->slug;

        $return = $this->slug->updateSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            if (!$category->image || $request->input('image') !== $category->image->file_name) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }
        } elseif ($category->image) {
            $category->image->delete();
        }

        if ($request->input('icon', false)) {
            if (!$category->icon || $request->input('icon') !== $category->icon->file_name) {
                $category->addMedia(storage_path('tmp/uploads/' . $request->input('icon')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('icon','s3');
            }
        } elseif ($category->icon) {
            $category->icon->delete();
        }

        if(isset($request->test_id)) {
            $url = route('admin.categories.index') . $request->test_id;
        } else {
            $url = route('admin.categories.index');
        }

        return redirect($url);
    }

    public function show(Category $category)
    {
        abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $category->load('sites', 'parent', 'user', 'parentCategories', 'categoryBlogs', 'categoryCoupons', 'categoryEvents', 'categoryStores');

        return view('admin.categories.show', compact('category'));
    }

    public function destroy(Category $category)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $category->delete();
        $this->slug->deleteSlug($category->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyCategoryRequest $request)
    {
        Category::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
