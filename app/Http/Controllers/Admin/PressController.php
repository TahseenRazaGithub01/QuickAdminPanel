<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPressRequest;
use App\Http\Requests\StorePressRequest;
use App\Http\Requests\UpdatePressRequest;
use App\Press;
use App\Site;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PressController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    public $table = 'presses';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'press/';
    protected $page_type    = 'press';

    public function index(Request $request)
    {
        abort_if(Gate::denies('press_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Press::with(['sites'])->select(sprintf('%s.*', (new Press)->table));

            if(isset($request->pid)) {
                $query = $query->where('id', $request->pid);
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
                $viewGate      = 'press_show';
                $editGate      = 'press_edit';
                $deleteGate    = 'press_delete';
                $crudRoutePart = 'presses';

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

        return view('admin.presses.index');
    }

    public function create()
    {
        abort_if(Gate::denies('press_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        return view('admin.presses.create', compact('sites'));
    }

    public function store(StorePressRequest $request)
    {
        $press = Press::create($request->all());
        $press->sites()->sync($request->input('sites', []));

        $last_id    = $press->id;
        $slug       = $press->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.presses.index') . $request->test_id;
        } else {
            $url = route('admin.presses.index');
        }

        return redirect($url);

    }

    public function edit(Press $press)
    {
        abort_if(Gate::denies('press_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $press->load('sites');

        return view('admin.presses.edit', compact('sites', 'press'));
    }

    public function update(UpdatePressRequest $request, Press $press)
    {
        $press->update($request->all());
        $press->sites()->sync($request->input('sites', []));

        $id         = $press->id;
        $slug       = $press->slug;

        $return = $this->slug->updateSlug($id, $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                if (!$press->image || $request->input('image') !== $press->image->file_name) {
                    $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($press->image) {
                $press->image->delete();
            }

        } else {

            if ($request->input('image', false)) {
                if (!$press->image || $request->input('image') !== $press->image->file_name) {
                    $press->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($press->image) {
                $press->image->delete();
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.presses.index') . $request->test_id;
        } else {
            $url = route('admin.presses.index');
        }

        return redirect($url);
    }

    public function show(Press $press)
    {
        abort_if(Gate::denies('press_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $press->load('sites');

        return view('admin.presses.show', compact('press'));
    }

    public function destroy(Press $press)
    {
        abort_if(Gate::denies('press_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $press->delete();
        $this->slug->deleteSlug($press->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyPressRequest $request)
    {
        Press::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
