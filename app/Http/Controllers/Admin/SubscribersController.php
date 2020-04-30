<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use App\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use url;

class SubscribersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('subscriber_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        abort_if((!getSiteID() > 0), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subscribers = Subscriber::all();
        return view('admin.subscribers.index', compact('subscribers'));
    }
    public function show(Subscriber $subscriber)
    {
        $subscriber = Subscriber::where('id', $subscriber['id'])->first();
        return view('admin.subscribers.show', compact('subscriber'));
    }
}
