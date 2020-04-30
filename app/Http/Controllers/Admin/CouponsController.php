<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Coupon;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Site;
use App\Store;
use App\User;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CouponsController extends Controller
{
    use MediaUploadingTrait;

    private function getStoreName($sid)
    {
        $data = Store::select('name', 'id')->where('id', $sid)->first();
        return $data;
    }

    protected function getUserName($id) {
        return User::select('name')->where('id', $id)->first()->name;
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $store = [];

        if(isset($request->sid)) {
            $store = $this->getStoreName(decrypt($request->sid));
        }

        if ($request->ajax()) {
            $query = Coupon::with(['sites', 'categories', 'store', 'coupon'])->select(sprintf('%s.*', (new Coupon)->table))->whereHas('sites', function($q) use($request, $store) {
                if(isset($request->sid)) {
                    $q->where('site_id', getSiteID())->where('store_id', $store->id);
                }
                else if($request->siteId != 'all') {
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

            if(isset($request->cid)) {
                $query = $query->where('id', $request->cid);
            }

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'coupon_show';
                $editGate      = 'coupon_edit';
                $deleteGate    = 'coupon_delete';
                $crudRoutePart = 'coupons';

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
                $affiliate_url = $row->affiliate_url ? '<small><b>'.trans('cruds.coupon.fields.affiliate_url').':</b> <a href="'.$row->affiliate_url.'">'.$row->affiliate_url.'</a></small>' : '';
                $title = $row->title ? $row->title : "";
                return new HtmlString('<p style="word-break: break-all">'. $title . ' <br />' . $affiliate_url .'</p>');
            });
            $table->addColumn('store_name', function ($row) {
                return $row->store ? $row->store->name : '';
            });

            $table->addColumn('date_expiry', function ($row) {
                $class = "badge badge-danger";
                if($row->date_expiry) {
                    if($row->date_expiry >= Carbon::now()->format('Y-m-d')) {
                        $class = "badge badge-primary";
                    }
                }
                return $row->date_expiry ? new HtmlString('<p style="word-break: break-all" class="'.$class.'">'.$row->date_expiry.'</p>') : '';
            });

            $table->editColumn('publish', function ($row) {
                return '<input type="checkbox" id="published'.$row->id.'" onclick="published('.$row->id.')" ' . ($row->publish ? 'checked' : null) . '>';
            });
            $table->editColumn('code', function ($row) {
                return $row->code ? $row->code : "";
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

            $table->rawColumns(['actions', 'placeholder', 'site', 'store', 'publish']);

            return $table->make(true);
        }

        return view('admin.coupons.index', compact('store'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('name', 'id');

        $coupons = Coupon::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.coupons.create', compact('sites', 'categories', 'stores', 'coupons'));
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create(array_merge($request->all(), ['created_by' => auth()->id(), 'updated_by' => auth()->id()]));
        $coupon->sites()->sync($request->input('sites', []));
        $coupon->categories()->sync($request->input('categories', []));

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $coupon->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $coupon->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

        }

        $url = request()->sid ? route('admin.coupons.index', 'sid=' . request()->sid) : route('admin.coupons.index');

        if(isset($request->test_id)) {
            $url = $url . $request->test_id;
        }

        return redirect($url);
    }

    public function edit(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) use($coupon) {
            if($coupon->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $coupon->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('title', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) use($coupon) {
            if($coupon->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $coupon->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('name', 'id');

        $coupons = Coupon::with('sites')->whereHas('sites', function($q) use($coupon) {
            if($coupon->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $coupon->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupon->load('sites', 'categories', 'store', 'coupon');

        return view('admin.coupons.edit', compact('sites', 'categories', 'stores', 'coupons', 'coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {

        $coupon->update(array_merge($request->all(), ['updated_by' => auth()->id()]));
        $coupon->sites()->sync($request->input('sites', []));
        $coupon->categories()->sync($request->input('categories', []));

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                if (!$coupon->image || $request->input('image') !== $coupon->image->file_name) {
                    $coupon->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($coupon->image) {
                $coupon->image->delete();
            }

        } else {

            if ($request->input('image', false)) {
                if (!$coupon->image || $request->input('image') !== $coupon->image->file_name) {
                    $coupon->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($coupon->image) {
                $coupon->image->delete();
            }

        }

        $url = request()->sid ? route('admin.coupons.index', 'sid=' . request()->sid) : route('admin.coupons.index');

        if(isset($request->test_id)) {
            $url = $url . $request->test_id;
        }

        return redirect($url);
    }

    public function show(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $coupon->load('sites', 'categories', 'store', 'coupon', 'couponCoupons', 'couponEvents');

        return view('admin.coupons.show', compact('coupon'));
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $coupon->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponRequest $request)
    {
        Coupon::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function published(Request $request) {
        $coupon = Coupon::find($request->id);
        $coupon->update($request->all());
    }
}
