<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTagRequest;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Site;
use App\Tag;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TagsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('tag_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Tag::with(['sites'])->select(sprintf('%s.*', (new Tag)->table));

            if(isset($request->tid)) {
                $query = $query->where('id', $request->tid);
            }

            $query = $query->whereHas('sites', function($q) use($request) {
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
                $viewGate      = 'tag_show';
                $editGate      = 'tag_edit';
                $deleteGate    = 'tag_delete';
                $crudRoutePart = 'tags';

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

            $table->rawColumns(['actions', 'placeholder', 'site', 'title', 'publish']);

            return $table->make(true);
        }

        return view('admin.tags.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tag_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        return view('admin.tags.create', compact('sites'));
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->all());
        $tag->sites()->sync($request->input('sites', []));

        if(isset($request->test_id)) {
            $url = route('admin.tags.index') . $request->test_id;
        } else {
            $url = route('admin.tags.index');
        }

        return redirect($url);
    }

    public function edit(Tag $tag)
    {
        abort_if(Gate::denies('tag_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $tag->load('sites');

        return view('admin.tags.edit', compact('sites', 'tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->all());
        $tag->sites()->sync($request->input('sites', []));

        if(isset($request->test_id)) {
            $url = route('admin.tags.index') . $request->test_id;
        } else {
            $url = route('admin.tags.index');
        }

        return redirect($url);
    }

    public function show(Tag $tag)
    {
        abort_if(Gate::denies('tag_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $tag->load('sites', 'tagBlogs');

        return view('admin.tags.show', compact('tag'));
    }

    public function destroy(Tag $tag)
    {
        abort_if(Gate::denies('tag_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $tag->delete();

        return back();
    }

    public function massDestroy(MassDestroyTagRequest $request)
    {
        Tag::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
