<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Http\Resources\Admin\SiteResource;
use App\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SitesApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('site_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteResource(Site::all());
    }

    public function store(StoreSiteRequest $request)
    {
        $site = Site::create($request->all());

        if ($request->input('flag', false)) {
            $site->addMedia(storage_path('tmp/uploads/' . $request->input('flag')))->toMediaCollection('flag');
        }

        if ($request->input('logo', false)) {
            $site->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
        }

        if ($request->input('favicon', false)) {
            $site->addMedia(storage_path('tmp/uploads/' . $request->input('favicon')))->toMediaCollection('favicon');
        }

        return (new SiteResource($site))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Site $site)
    {
        abort_if(Gate::denies('site_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SiteResource($site);
    }

    public function update(UpdateSiteRequest $request, Site $site)
    {
        $site->update($request->all());

        if ($request->input('flag', false)) {
            if (!$site->flag || $request->input('flag') !== $site->flag->file_name) {
                $site->addMedia(storage_path('tmp/uploads/' . $request->input('flag')))->toMediaCollection('flag');
            }
        } elseif ($site->flag) {
            $site->flag->delete();
        }

        if ($request->input('logo', false)) {
            if (!$site->logo || $request->input('logo') !== $site->logo->file_name) {
                $site->addMedia(storage_path('tmp/uploads/' . $request->input('logo')))->toMediaCollection('logo');
            }
        } elseif ($site->logo) {
            $site->logo->delete();
        }

        if ($request->input('favicon', false)) {
            if (!$site->favicon || $request->input('favicon') !== $site->favicon->file_name) {
                $site->addMedia(storage_path('tmp/uploads/' . $request->input('favicon')))->toMediaCollection('favicon');
            }
        } elseif ($site->favicon) {
            $site->favicon->delete();
        }

        return (new SiteResource($site))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Site $site)
    {
        abort_if(Gate::denies('site_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $site->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
