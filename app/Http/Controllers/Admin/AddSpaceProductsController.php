<?php

namespace App\Http\Controllers\Admin;

use App\AddSpaceProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAddSpaceProductRequest;
use App\Http\Requests\StoreAddSpaceProductRequest;
use App\Http\Requests\UpdateAddSpaceProductRequest;
use App\ProductCategory;
use App\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class AddSpaceProductsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('add_space_product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = AddSpaceProduct::with(['sites', 'products'])->select(sprintf('%s.*', (new AddSpaceProduct)->table));

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
                $viewGate      = 'add_space_product_show';
                $editGate      = 'add_space_product_edit';
                $deleteGate    = 'add_space_product_delete';
                $crudRoutePart = 'add-space-products';

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

            $table->editColumn('product', function ($row) {
                $products = [];
                foreach ($row->products as $product) {
                    $products[] = sprintf('<span class="badge badge-info">%s</span>', $product->name);
                }

                return implode(' ', $products);
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'product']);

            return $table->make(true);
        }

        return view('admin.addSpaceProducts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('add_space_product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $products = ProductCategory::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('name', 'id');

        return view('admin.addSpaceProducts.create', compact('sites', 'products'));
    }

    public function store(StoreAddSpaceProductRequest $request)
    {
        $addSpaceProduct = AddSpaceProduct::create($request->all());
        $addSpaceProduct->sites()->sync($request->input('sites', []));
        $addSpaceProduct->products()->sync($request->input('products', []));

        if(isset($request->test_id)) {
            $url = route('admin.add-space-products.index') . $request->test_id;
        } else {
            $url = route('admin.add-space-products.index');
        }

        return redirect($url);
    }

    public function edit(AddSpaceProduct $addSpaceProduct)
    {
        abort_if(Gate::denies('add_space_product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $products = ProductCategory::with('sites')->whereHas('sites', function($q) use($addSpaceProduct) {
            if($addSpaceProduct->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $addSpaceProduct->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('name', 'id');

        $addSpaceProduct->load('sites', 'products');

        return view('admin.addSpaceProducts.edit', compact('sites', 'products', 'addSpaceProduct'));
    }

    public function update(UpdateAddSpaceProductRequest $request, AddSpaceProduct $addSpaceProduct)
    {
        $addSpaceProduct->update($request->all());
        $addSpaceProduct->sites()->sync($request->input('sites', []));
        $addSpaceProduct->products()->sync($request->input('products', []));

        if(isset($request->test_id)) {
            $url = route('admin.add-space-products.index') . $request->test_id;
        } else {
            $url = route('admin.add-space-products.index');
        }

        return redirect($url);
    }

    public function show(AddSpaceProduct $addSpaceProduct)
    {
        abort_if(Gate::denies('add_space_product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $addSpaceProduct->load('sites', 'products');

        return view('admin.addSpaceProducts.show', compact('addSpaceProduct'));
    }

    public function destroy(AddSpaceProduct $addSpaceProduct)
    {
        abort_if(Gate::denies('add_space_product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $addSpaceProduct->delete();

        return back();
    }

    public function massDestroy(MassDestroyAddSpaceProductRequest $request)
    {
        AddSpaceProduct::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
