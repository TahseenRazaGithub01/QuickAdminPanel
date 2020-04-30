<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Event;
use App\Slug;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\Admin\EventResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EventsApiController extends Controller
{
    public function __construct() {
        $this->slug = new Slug;
    }

    public $table           = 'events';
    protected $primaryKey   = 'id';
    protected $slug_prefix  = '';
    protected $page_type    = 'events';

    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('event_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventResource(Event::with(['sites', 'categories', 'stores', 'coupons'])->get());
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

        if ($request->input('image', false)) {
            $category->addMediaFromUrl($request->input('image'))->toMediaCollection('image');
        }

        if ($request->input('banner', false)) {
            $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->toMediaCollection('banner');
        }

        if ($request->input('menu_icon', false)) {
            $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')))->toMediaCollection('menu_icon');
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Event $event)
    {
        abort_if(Gate::denies('event_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EventResource($event->load(['sites', 'categories', 'stores', 'coupons']));
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->all());
        $event->sites()->sync($request->input('sites', []));
        $event->categories()->sync($request->input('categories', []));
        $event->stores()->sync($request->input('stores', []));
        $event->coupons()->sync($request->input('coupons', []));

        if ($request->input('image', false)) {
            if (!$event->image || $request->input('image') !== $event->image->file_name) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->toMediaCollection('image');
            }
        } elseif ($event->image) {
            $event->image->delete();
        }

        if ($request->input('banner', false)) {
            if (!$event->banner || $request->input('banner') !== $event->banner->file_name) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('banner')))->toMediaCollection('banner');
            }
        } elseif ($event->banner) {
            $event->banner->delete();
        }

        if ($request->input('menu_icon', false)) {
            if (!$event->menu_icon || $request->input('menu_icon') !== $event->menu_icon->file_name) {
                $event->addMedia(storage_path('tmp/uploads/' . $request->input('menu_icon')))->toMediaCollection('menu_icon');
            }
        } elseif ($event->menu_icon) {
            $event->menu_icon->delete();
        }

        return (new EventResource($event))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Event $event)
    {
        abort_if(Gate::denies('event_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $event->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
