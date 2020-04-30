<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductCategoryRequest;
use App\Http\Requests\StoreProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\ProductCategory;
use App\Site;
use App\Slug;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    public $table = 'product_categories';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = 'product/';
    protected $page_type    = 'product';

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = ProductCategory::with(['sites'])->select(sprintf('%s.*', (new ProductCategory)->table));

            if(isset($request->pcid)) {
                $query = $query->where('id', $request->pcid);
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
                $viewGate      = 'product_category_show';
                $editGate      = 'product_category_edit';
                $deleteGate    = 'product_category_delete';
                $crudRoutePart = 'product-categories';

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
            $table->editColumn('sort', function ($row) {
                return $row->sort ? $row->sort : "";
            });

            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->publish ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'title', 'publish']);

            return $table->make(true);
        }

        return view('admin.productCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('product_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $parents = ProductCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.productCategories.create', compact('sites', 'parents'));
    }

    public function store(StoreProductCategoryRequest $request)
    {
        $productCategory = ProductCategory::create($request->all());
        $productCategory->sites()->sync($request->input('sites', []));

        $last_id    = $productCategory->id;
        $slug       = $productCategory->slug;

        $return = $this->slug->insertSlug($last_id, $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $productCategory->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $productCategory->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

        }


        if(isset($request->test_id)) {
            $url = route('admin.product-categories.index') . $request->test_id;
        } else {
            $url = route('admin.product-categories.index');
        }

        return redirect($url);
    }

    public function edit(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $parents = ProductCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productCategory->load('sites', 'parent');

        $slug = Slug::where('obj_id', $productCategory['id'])->where('table_name', 'product_categories')->get()->toArray();

        return view('admin.productCategories.edit', compact('sites', 'parents', 'productCategory','slug'));
    }

    public function update(UpdateProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->all());
        $productCategory->sites()->sync($request->input('sites', []));


        $id         = $productCategory->id;
        $slug       = $productCategory->slug;

        if($request['old_slug'] != ""){
            $old_slug = $request['slug'];
            $slug = $request['old_slug'];
        }else{
            $old_slug = "";
        }

        $return = $this->slug->updateSlug($id, $slug, $this->table, $request->input('sites', []), 0, $old_slug);

        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                if (!$productCategory->image || $request->input('image') !== $productCategory->image->file_name) {
                    $productCategory->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($productCategory->image) {
                $productCategory->image->delete();
            }

        } else {

            if ($request->input('image', false)) {
                if (!$productCategory->image || $request->input('image') !== $productCategory->image->file_name) {
                    $productCategory->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($productCategory->image) {
                $productCategory->image->delete();
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.product-categories.index') . $request->test_id;
        } else {
            $url = route('admin.product-categories.index');
        }

        return redirect($url);
    }

    public function show(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $productCategory->load('sites', 'parent', 'parentProductCategories', 'productAddSpaceProducts', 'productCategoryProducts');

        return view('admin.productCategories.show', compact('productCategory'));
    }

    public function destroy(ProductCategory $productCategory)
    {
        abort_if(Gate::denies('product_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $productCategory->delete();
        $this->slug->deleteSlug($productCategory->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyProductCategoryRequest $request)
    {
        ProductCategory::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
