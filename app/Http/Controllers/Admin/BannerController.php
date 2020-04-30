<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBannerRequest;
use App\Http\Requests\StoreBannerRequest;
use App\Http\Requests\UpdateBannerRequest;
use App\Site;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BannerController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $banners = Banner::with('sites');

        if(isset(request()->bid)) {
            $banners = $banners->where('id', request()->bid);
        }

        $banners = $banners->whereHas('sites', function($q) use($request) {
            if($request->siteId != 'all') {
                if(!empty($request->siteId)) {
                    $q->where('site_id', $request->siteId);
                } elseif (isset(request()->test_id)) {
                    $q->where('site_id', request()->test_id);
                } else {
                    $q->where('site_id', getSiteID());
                }
            }
        })->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        return view('admin.banners.create', compact('sites'));
    }

    public function store(StoreBannerRequest $request)
    {
        $banner = Banner::create($request->all());
        $banner->sites()->sync($request->input('sites', []));

        if (\App::environment('production')) {
            if ($request->input('image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('image','s3');
            }

            if ($request->input('store_image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('store_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('store_image','s3');
            }

            if ($request->input('mobile_image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('mobile_image')))->addCustomHeaders([
                    'ACL' => 'public-read'
                ])->toMediaCollection('mobile_image','s3');
            }
        } else {
            if ($request->input('image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
            }

            if ($request->input('store_image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('store_image')));
            }

            if ($request->input('mobile_image', false)) {
                $banner->addMedia(storage_path('tmp/uploads/' . $request->input('mobile_image')));
            }
        }


        if(isset($request->test_id)) {
            $url = route('admin.banners.index') . $request->test_id;
        } else {
            $url = route('admin.banners.index');
        }

        return redirect($url);
    }

    public function edit(Banner $banner)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $sites = Site::all()->pluck('name', 'id');

        $banner->load('sites');

        return view('admin.banners.edit', compact('sites', 'banner'));
    }

    public function update(UpdateBannerRequest $request, Banner $banner)
    {
        $banner->update($request->all());
        $banner->sites()->sync($request->input('sites', []));

        if (\App::environment('production')) {
            if ($request->input('image', false)) {
                if (!$banner->image || $request->input('image') !== $banner->image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('image','s3');
                }
            } elseif ($banner->image) {
                $banner->image->delete();
            }

            if ($request->input('store_image', false)) {
                if (!$banner->store_image || $request->input('store_image') !== $banner->store_image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('store_image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('store_image','s3');
                }
            } elseif ($banner->store_image) {
                $banner->store_image->delete();
            }

            if ($request->input('mobile_image', false)) {
                if (!$banner->mobile_image || $request->input('mobile_image') !== $banner->mobile_image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('mobile_image')))->addCustomHeaders([
                        'ACL' => 'public-read'
                    ])->toMediaCollection('mobile_image','s3');
                }
            } elseif ($banner->mobile_image) {
                $banner->mobile_image->delete();
            }
        } else {
            if ($request->input('image', false)) {
                if (!$banner->image || $request->input('image') !== $banner->image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('image')));
                }
            } elseif ($banner->image) {
                $banner->image->delete();
            }

            if ($request->input('store_image', false)) {
                if (!$banner->store_image || $request->input('store_image') !== $banner->store_image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('store_image')));
                }
            } elseif ($banner->store_image) {
                $banner->store_image->delete();
            }

            if ($request->input('mobile_image', false)) {
                if (!$banner->mobile_image || $request->input('mobile_image') !== $banner->mobile_image->file_name) {
                    $banner->addMedia(storage_path('tmp/uploads/' . $request->input('mobile_image')));
                }
            } elseif ($banner->mobile_image) {
                $banner->mobile_image->delete();
            }
        }

        if(isset($request->test_id)) {
            $url = route('admin.banners.index') . $request->test_id;
        } else {
            $url = route('admin.banners.index');
        }

        return redirect($url);
    }

    public function show(Banner $banner)
    {
        abort_if(Gate::denies('banner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $banner->load('sites');

        return view('admin.banners.show', compact('banner'));
    }

    public function destroy(Banner $banner)
    {
        abort_if(Gate::denies('banner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = (isset(request()->test_id) ? !request()->test_id > 0 : !getSiteID() > 0);
        if($status) return redirect('/admin');

        $banner->delete();

        return back();
    }

    public function massDestroy(MassDestroyBannerRequest $request)
    {
        Banner::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
