<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Coupon;
use App\Event;
use App\Slug;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEventRequest;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Site;
use App\Store;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EventsController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    use MediaUploadingTrait;

    protected $primaryKey   = 'id';
    protected $slug_prefix  = '';//'event/';
    protected $page_type    = 'event';
    protected $table    = 'events';

    public function index(Request $request)
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        if ($request->ajax()) {
            $query = Event::with(['sites'])->select(sprintf('%s.*', (new Event)->table));

            if(isset($request->eid)) {
                $query = $query->where('id', $request->eid);
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
                $viewGate      = 'event_show';
                $editGate      = 'event_edit';
                $deleteGate    = 'event_delete';
                $crudRoutePart = 'events';

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

            $table->rawColumns(['actions', 'placeholder', 'site', 'title']);

            return $table->make(true);
        }

        return view('admin.events.index');
    }

    public function create()
    {
        abort_if(Gate::denies('event_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupons = Coupon::with('sites')->whereHas('sites', function($q) {
            $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.events.create', compact('sites', 'categories', 'stores', 'coupons'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->all());
        $event->sites()->sync($request->input('sites', []));
        $event->categories()->sync($request->input('categories', []));
        $event->stores()->sync($request->input('stores', []));
        $event->coupons()->sync($request->input('coupons', []));

        $last_id    = $event->id;
        $slug       = $event->slug;

        $return = $this->slug->insertSlug($last_id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('banner', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('banner','s3');
            }

            if ($request->input('menu_icon', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('menu_icon','s3');
            }

        } else {

            if ($request->input('image', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('banner', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')));
            }

            if ($request->input('menu_icon', false)) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')));
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.events.index') . $request->test_id;
        } else {
            $url = route('admin.events.index');
        }

        return redirect($url);
    }

    public function edit(Event $event)
    {
        abort_if(Gate::denies('event_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $categories = Category::with('sites')->whereHas('sites', function($q) use($event) {
            if($event->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $event->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('title', 'id');

        $stores = Store::with('sites')->whereHas('sites', function($q) use($event) {
            if($event->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $event->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupons = Coupon::with('sites')->whereHas('sites', function($q) use($event) {
            if($event->sites()->pluck('site_id')->count() > 0) {
                $q->whereIn('site_id', $event->sites()->pluck('site_id'));
            } else {
                $q->where('site_id', isset(request()->test_id) ? request()->test_id : getSiteID());
            }
        })->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $event->load('sites', 'categories', 'stores', 'coupons');

        return view('admin.events.edit', compact('sites', 'categories', 'stores', 'coupons', 'event'));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->sites()->sync($request->input('sites', []));
        $event->categories()->sync($request->input('categories', []));
        $event->stores()->sync($request->input('stores', []));
        $event->coupons()->sync($request->input('coupons', []));

        $id         = $event->id;
        $slug       = $event->slug;

        $return = $this->slug->updateSlug($id, $this->slug_prefix . $slug, $this->table, $request->input('sites', []));
        if (isset($return['status']) && $return['status'] === false) {
            return $return;
        }

        if (\App::environment('production')) {

            if ($request->input('image', false)) {
                if (!$event->image || $request->input('image') !== $event->image->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($event->image) {
                $event->image->delete();
            }

            if ($request->input('banner', false)) {
                if (!$event->banner || $request->input('banner') !== $event->banner->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('banner','s3');
                }
            } elseif ($event->banner) {
                $event->banner->delete();
            }

            if ($request->input('menu_icon', false)) {
                if (!$event->menu_icon || $request->input('menu_icon') !== $event->menu_icon->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('menu_icon','s3');
                }
            } elseif ($event->menu_icon) {
                $event->menu_icon->delete();
            }

        } else {

            if ($request->input('image', false)) {
                if (!$event->image || $request->input('image') !== $event->image->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($event->image) {
                $event->image->delete();
            }

            if ($request->input('banner', false)) {
                if (!$event->banner || $request->input('banner') !== $event->banner->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')));
                }
            } elseif ($event->banner) {
                $event->banner->delete();
            }

            if ($request->input('menu_icon', false)) {
                if (!$event->menu_icon || $request->input('menu_icon') !== $event->menu_icon->file_name) {
                    $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')));
                }
            } elseif ($event->menu_icon) {
                $event->menu_icon->delete();
            }

        }

        if(isset($request->test_id)) {
            $url = route('admin.events.index') . $request->test_id;
        } else {
            $url = route('admin.events.index');
        }

        return redirect($url);
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $event->load('sites', 'categories', 'stores', 'coupons');

        return view('admin.events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $event->delete();
        $this->slug->deleteSlug($event->id, $this->table);
        return back();
    }

    public function massDestroy(MassDestroyEventRequest $request)
    {
        Event::whereIn('id', request('ids'))->delete();
        $this->slug->massdeleteSlug(request('ids'), $this->table);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
