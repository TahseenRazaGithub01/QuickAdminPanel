<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\Category;
use App\Slug;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBlogRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Site;
use App\Tag;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    protected $table   = 'blogs';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'blog/';
    protected $page_type    = 'categories';

    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('blog_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Blog::with(['sites'])->select(sprintf('%s.*', (new Blog)->table));

            if(isset($request->bid)) {
                $query = $query->where('id', $request->bid);
            }

            $query = $query->whereHas('sites', function($q) use($request) {
                if($request->siteId != 'all') {
                    if(!empty($request->siteId)) {
                        $q->where('site_id', $request->siteId);
                    } elseif (isset(request()->test_id)) {
                        $q->where('site_id', request()->test_id);
                    } else {
                        $q->where('site_id', getSiteID());
                    }
                }
            });
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'blog_show';
                $editGate      = 'blog_edit';
                $deleteGate    = 'blog_delete';
                $crudRoutePart = 'blogs';

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
                return $row->title ? str_limit($row->title, 60) : "";
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

        return view('admin.blogs.index');
    }

    public function create()
    {
        abort_if(Gate::denies('blog_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::all()->pluck('title', 'id');

        $users = User::all()->pluck('name', 'id');

        $tags = Tag::all()->pluck('title', 'id');

        return view('admin.blogs.create', compact('sites', 'categories', 'tags', 'users'));
    }

    public function store(StoreBlogRequest $request)
    {
        $blog = Blog::create($request->all());
        $blog->sites()->sync($request->input('sites', []));
        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        $last_id    = $blog->id;
        $slug       = $blog->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {
            if ($request->input('image', false)) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('banner_image', false)) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('banner_image','s3');
            }
        } else {
            if ($request->input('image', false)) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('banner_image', false)) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')));
            }
        }

        if(isset($request->test_id)) {
            $url = route('admin.blogs.index') . $request->test_id;
        } else {
            $url = route('admin.blogs.index');
        }

        return redirect($url);
    }

    public function edit(Blog $blog)
    {
        abort_if(Gate::denies('blog_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::all()->pluck('title', 'id');

        $users = User::all()->pluck('name', 'id');

        $tags = Tag::all()->pluck('title', 'id');

        $blog->load('sites', 'categories', 'tags','user');

        return view('admin.blogs.edit', compact('sites', 'categories', 'tags', 'blog', 'users'));
    }

    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        $blog->update($request->all());
        $blog->sites()->sync($request->input('sites', []));
        $blog->categories()->sync($request->input('categories', []));
        $blog->tags()->sync($request->input('tags', []));

        $last_id    = $blog->id;
        $slug       = $blog->slug;

        $return = $this->slug->updateSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            if (!$blog->image || $request->input('image') !== $blog->image->file_name) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }
        } elseif ($blog->image) {
            $blog->image->delete();
        }

        if ($request->input('banner_image', false)) {
            if (!$blog->banner_image || $request->input('banner_image') !== $blog->banner_image->file_name) {
                $blog->addMedia(storage_path('tmp/uploads/' . $request->input('banner_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('banner_image','s3');
            }
        } elseif ($blog->banner_image) {
            $blog->banner_image->delete();
        }

        if(isset($request->test_id)) {
            $url = route('admin.blogs.index') . $request->test_id;
        } else {
            $url = route('admin.blogs.index');
        }

        return redirect($url);

    }

    public function show(Blog $blog)
    {
        abort_if(Gate::denies('blog_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $blog->load('sites', 'categories', 'tags');

        return view('admin.blogs.show', compact('blog'));
    }

    public function destroy(Blog $blog)
    {
        abort_if(Gate::denies('blog_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $blog->delete();
        $this->slug->deleteSlug($blog->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyBlogRequest $request)
    {
        Blog::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
