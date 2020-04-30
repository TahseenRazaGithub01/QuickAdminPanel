<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Product;
use App\ProductCategory;
use App\Site;
use App\Store;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Product::with(['sites', 'product_categories', 'stores'])->select(sprintf('%s.*', (new Product)->table));

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
                $viewGate      = 'product_show';
                $editGate      = 'product_edit';
                $deleteGate    = 'product_delete';
                $crudRoutePart = 'products';

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
            $table->editColumn('product_category', function ($row) {
                $labels = [];

                foreach ($row->product_categories as $product_category) {
                    $labels[] = sprintf('<span class="badge badge-info">%s</span>', $product_category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->editColumn('store', function ($row) {
                $labels = [];

                foreach ($row->stores as $store) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $store->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->publish ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'product_category', 'store', 'publish']);

            return $table->make(true);
        }

        return view('admin.products.index');
    }

    public function create()
    {
        abort_if(Gate::denies('product_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $product_categories = ProductCategory::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('name', 'id');

        $stores = Store::all()->pluck('name', 'id');

        return view('admin.products.create', compact('sites', 'product_categories', 'stores'));
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->sites()->sync($request->input('sites', []));
        $product->product_categories()->sync($request->input('product_categories', []));
        $product->stores()->sync($request->input('stores', []));

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('additional_image', false)) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('additional_image','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('additional_image', false)) {
                $product->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.products.index') . $request->test_id;
        } else {
            $url = route('admin.products.index');
        }

        return redirect($url);
    }

    public function edit(Product $product)
    {
        abort_if(Gate::denies('product_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $product_categories = ProductCategory::with('sites')->whereHas('sites', function($q) use($product) {
            if($product->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $product->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('name', 'id');

        $stores = Store::all()->pluck('name', 'id');

        $product->load('sites', 'product_categories', 'stores');

        return view('admin.products.edit', compact('sites', 'product_categories', 'stores', 'product'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->all());
        $product->sites()->sync($request->input('sites', []));
        $product->product_categories()->sync($request->input('product_categories', []));
        $product->stores()->sync($request->input('stores', []));

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                if (!$product->image || $request->input('image') !== $product->image->file_name) {
                    $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($product->image) {
                $product->image->delete();
            }

            if ($request->input('additional_image', false)) {
                if (!$product->additional_image || $request->input('additional_image') !== $product->additional_image->file_name) {
                    $product->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('additional_image','s3');
                }
            } elseif ($product->additional_image) {
                $product->additional_image->delete();
            }

        } else {

            if ($request->input('image', false)) {
                if (!$product->image || $request->input('image') !== $product->image->file_name) {
                    $product->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($product->image) {
                $product->image->delete();
            }

            if ($request->input('additional_image', false)) {
                if (!$product->additional_image || $request->input('additional_image') !== $product->additional_image->file_name) {
                    $product->addMedia(storage_path('tmp/uploads/' . $request->input('additional_image')));
                }
            } elseif ($product->additional_image) {
                $product->additional_image->delete();
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.products.index') . $request->test_id;
        } else {
            $url = route('admin.products.index');
        }

        return redirect($url);
    }

    public function show(Product $product)
    {
        abort_if(Gate::denies('product_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $product->load('sites', 'product_categories', 'stores');

        return view('admin.products.show', compact('product'));
    }

    public function destroy(Product $product)
    {
        abort_if(Gate::denies('product_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $product->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductRequest $request)
    {
        Product::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
