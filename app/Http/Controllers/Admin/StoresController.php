<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyStoreRequest;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Network;
use App\Site;
use App\Store;
use App\Slug;
use App\User;
use App\Coupon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class StoresController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    protected function getUserName($id) {
        return User::select('name')->where('id', $id)->first()->name;
    }

    use MediaUploadingTrait;

    public $table = 'stores';
    protected $primaryKey   = 'id';
    protected $slug_prefix  =  ''; //'store/';
    protected $page_type    = 'store';

    public function index(Request $request)
    {
        abort_if(Gate::denies('store_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Store::with(['sites', 'storeCoupons', 'categories', 'network'])->select(sprintf('%s.*', (new Store)->table));

            if(isset($request->stid)) {
                $query = $query->where('id', $request->stid);
            }

            $query = $query->whereHas('sites', function($q) use ($request) {
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
                $viewCoupon    = 'view_coupon';
                $viewGate      = 'store_show';
                $editGate      = 'store_edit';
                $deleteGate    = 'store_delete';
                $crudRoutePart = 'stores';

                return view('partials.datatablesActions', compact(
                    'viewCoupon',
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
                $affiliate_url = $row->affiliate_url ? '<small><b>'.trans('cruds.store.fields.affiliate_url').':</b> <a href="'.$row->affiliate_url.'">'.$row->affiliate_url.'</a></small>' : '';
                $name = $row->name ? $row->name : "";
                return new HtmlString('<p style="word-break: break-all">'. $name . ' <br />' . $affiliate_url .'</p>');
            });
            $table->editColumn('sort', function ($row) {
                return $row->sort ? $row->sort : "";
            });
            $table->addColumn('network_name', function ($row) {
                return $row->network ? $row->network->name : '';
            });
            $table->addColumn('coupon_count', function ($row) {
                return $row->storeCoupons ? $row->storeCoupons->count() : '';
            });
            $table->addColumn('created_by', function ($row) {
                $created_by = $row->created_by ? $this->getUserName($row->created_by) . ' / ' : '';
                $created_at = $row->created_at ? $row->created_at : '';
                return $created_by . ' ' . $created_at;
            });
            $table->addColumn('updated_by', function ($row) {
                $updated_by = $row->updated_by ? $this->getUserName($row->updated_by) . ' / ' : '';
                $updated_at = $row->updated_at ? $row->updated_at : '';
                return $updated_by . ' ' . $updated_at;
            });

            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" id="published'.$row->id.'" onclick="published('.$row->id.')" ' . ($row->publish ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'site', 'network', 'publish']);

            return $table->make(true);
        }

        return view('admin.stores.index');//, compact('stores'));
    }

    public function create()
    {
        abort_if(Gate::denies('store_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id');

        $networks = Network::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.stores.create', compact('sites', 'categories', 'networks'));
    }

    public function store(StoreStoreRequest $request)
    {
        $store = Store::create(array_merge($request->all(), ['created_by' => auth()->id(), 'updated_by' => auth()->id()]));
        $store->sites()->sync($request->input('sites', []));
        $store->categories()->sync($request->input('categories', []));

        $last_id    = $store->id;
        $slug       = $store->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $store->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $store->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.stores.index') . $request->test_id;
        } else {
            $url = route('admin.stores.index');
        }

        return redirect($url);
    }

    public function edit(Store $store)
    {
        abort_if(Gate::denies('store_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) use($store) {
            if($store->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $store->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }

        })->pluck('title', 'id');

        $networks = Network::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $store->load('sites', 'categories', 'network');

        $slug = Slug::where('obj_id', $store['id'])->where('table_name', $this->table)->get()->toArray();

        return view('admin.stores.edit', compact('sites', 'categories', 'networks', 'store','slug'));
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $store->update(array_merge($request->all(), ['updated_by' => auth()->id()]));
        $store->sites()->sync($request->input('sites', []));
        $store->categories()->sync($request->input('categories', []));

        $id         = $store->id;
        $slug       = $store->slug;

        if($request['old_slug'] != ""){
            $old_slug = $request['slug'];
            $slug = $request['old_slug'];
        }else{
            $old_slug = "";
        }

        $return = $this->slug->updateSlug($id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []), 0, $old_slug);
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if ($request->input('image', false)) {
            if (!$store->image || $request->input('image') !== $store->image->file_name) {
                $store->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }
        } elseif ($store->image) {
            $store->image->delete();
        }

        if(isset($request->test_id)) {
            $url = route('admin.stores.index') . $request->test_id;
        } else {
            $url = route('admin.stores.index');
        }

        return redirect($url);
    }

    public function show(Store $store)
    {
        abort_if(Gate::denies('store_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $store->load('sites', 'categories', 'network');

        return view('admin.stores.show', compact('store'));
    }

    public function destroy(Store $store)
    {
        abort_if(Gate::denies('store_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');
        //dd($store->id);
        $store->delete();
        $this->slug->deleteSlug($store->id, $this->table);

        return back();
    }

    public function massDestroy(MassDestroyStoreRequest $request)
    {

        Store::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function published(Request $request) {
        $store = Store::find($request->id);
        $store->update($request->all());
        $store_id = $request->id;
        $coupons = Coupon::where('store_id',$store_id)->get(); 
        foreach($coupons as $coupon):
        $coupon = Coupon::find($coupon->id);
        $array = ['id'=>$coupon->id,'publish'=>$request->publish];
        $ab = $coupon->update($array);
        endforeach;
    }
}
