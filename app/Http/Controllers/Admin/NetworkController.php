<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyNetworkRequest;
use App\Http\Requests\StoreNetworkRequest;
use App\Http\Requests\UpdateNetworkRequest;
use App\Network;
use App\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class NetworkController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('network_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Network::with(['sites'])->select(sprintf('%s.*', (new Network)->table));

            if(isset($request->nid)) {
                $query = $query->where('id', $request->nid);
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
                $viewGate      = 'network_show';
                $editGate      = 'network_edit';
                $deleteGate    = 'network_delete';
                $crudRoutePart = 'networks';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : "";
            });

            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->publish ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'publish']);

            return $table->make(true);
        }

        return view('admin.networks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('network_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        return view('admin.networks.create', compact('sites'));
    }

    public function store(StoreNetworkRequest $request)
    {
        $network = Network::create($request->all());
        $network->sites()->sync($request->input('sites', []));

        if(isset($request->test_id)) {
            $url = route('admin.networks.index') . $request->test_id;
        } else {
            $url = route('admin.networks.index');
        }

        return redirect($url);
    }

    public function edit(Network $network)
    {
        abort_if(Gate::denies('network_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $network->load('sites');

        return view('admin.networks.edit', compact('sites', 'network'));
    }

    public function update(UpdateNetworkRequest $request, Network $network)
    {
        $network->update($request->all());
        $network->sites()->sync($request->input('sites', []));

        if(isset($request->test_id)) {
            $url = route('admin.networks.index') . $request->test_id;
        } else {
            $url = route('admin.networks.index');
        }

        return redirect($url);
    }

    public function show(Network $network)
    {
        abort_if(Gate::denies('network_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $network->load('sites', 'networkStores');

        return view('admin.networks.show', compact('network'));
    }

    public function destroy(Network $network)
    {
        abort_if(Gate::denies('network_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $network->delete();

        return back();
    }

    public function massDestroy(MassDestroyNetworkRequest $request)
    {
        Network::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
