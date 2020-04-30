<?php

namespace App\Http\Controllers\Admin;

use App\Site;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class HomeController
{
    public function index()
    {
        $sites = Site::all();

        return view('home', compact('sites'));
    }

    public function setSiteId()
    {
        Session::put("SITE_ID", (int)request()->id);
    }
}
