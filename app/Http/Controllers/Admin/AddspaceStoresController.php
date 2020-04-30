<?php

namespace App\Http\Controllers\Admin;

use App\AddspaceStore;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAddspaceStoreRequest;
use App\Http\Requests\StoreAddspaceStoreRequest;
use App\Http\Requests\UpdateAddspaceStoreRequest;
use App\Site;
use App\Store;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AddspaceStoresController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('addspace_store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = AddspaceStore::with(['sites', 'stores'])->select(sprintf('%s.*', (new AddspaceStore)->table));

            if(isset($request->aid)) {
                $query = $query->where('id', $request->aid);
            }

            $query = $query->whereHas('sites', function($q) use ($request) {
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
            })->get();
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'addspace_store_show';
                $editGate      = 'addspace_store_edit';
                $deleteGate    = 'addspace_store_delete';
                $crudRoutePart = 'addspace-stores';

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
            $table->editColumn('store', function ($row) {
                $stores = [];
                foreach ($row->stores as $store) {
                    $stores[] = sprintf('<span class="badge badge-info">%s</span>', $store->name);
                }

                return implode(' ', $stores);
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'store']);

            return $table->make(true);
        }

        return view('admin.addspaceStores.index');
    }

    public function create()
    {
        abort_if(Gate::denies('addspace_store_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('name', 'id');

        return view('admin.addspaceStores.create', compact('sites', 'stores'));
    }

    public function store(StoreAddspaceStoreRequest $request)
    {
        $addspaceStore = AddspaceStore::create($request->all());
        $addspaceStore->sites()->sync($request->input('sites', []));
        $addspaceStore->stores()->sync($request->input('stores', []));

        if(isset($request->test_id)) {
            $url = route('admin.addspace-stores.index') . $request->test_id;
        } else {
            $url = route('admin.addspace-stores.index');
        }

        return redirect($url);
    }

    public function edit(AddspaceStore $addspaceStore)
    {
        abort_if(Gate::denies('addspace_store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) use($addspaceStore) {
            if($addspaceStore->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $addspaceStore->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('name', 'id');

        $addspaceStore->load('sites', 'stores');

        return view('admin.addspaceStores.edit', compact('sites', 'stores', 'addspaceStore'));
    }

    public function update(UpdateAddspaceStoreRequest $request, AddspaceStore $addspaceStore)
    {
        $addspaceStore->update($request->all());
        $addspaceStore->sites()->sync($request->input('sites', []));
        $addspaceStore->stores()->sync($request->input('stores', []));

        if(isset($request->test_id)) {
            $url = route('admin.addspace-stores.index') . $request->test_id;
        } else {
            $url = route('admin.addspace-stores.index');
        }

        return redirect($url);
    }

    public function show(AddspaceStore $addspaceStore)
    {
        abort_if(Gate::denies('addspace_store_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $addspaceStore->load('sites', 'stores');

        return view('admin.addspaceStores.show', compact('addspaceStore'));
    }

    public function destroy(AddspaceStore $addspaceStore)
    {
        abort_if(Gate::denies('addspace_store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $addspaceStore->delete();

        return back();
    }

    public function massDestroy(MassDestroyAddspaceStoreRequest $request)
    {
        AddspaceStore::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
