<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function records(Request $request) {

        if ($request->modelName == "pages") {
            $data = Page::with('sites')->whereHas('sites', function($q) use ($request) {
                if($request->siteId != 'all') $q->where('site_id', $request->siteId);
            })->get();
        }

        else if ($request->modelName == "banners") {
            $data = Banner::with('sites')->whereHas('sites', function($q) use ($request) {
                if($request->siteId != 'all') $q->where('site_id', $request->siteId);
            })->get();
        }

        echo json_encode($data);
    }
}
