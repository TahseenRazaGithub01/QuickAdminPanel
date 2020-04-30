<?php
namespace App\ViewComposers;
use Illuminate\View\View;
use Illuminate\Http\Request;
use \App\Site as Site;
use App\Event;
use App\Page;

class SiteWideData
{
	public function compose(View $view)
	{
		$data = [];
		$siteid = config('app.siteid') ;
		$data['site_wide_data'] = Site::whereId(config('app.siteid'))->first()->toArray();
		$data['top_event'] = Event::select('id','title','slug')->with('slugs')->where('publish', 1)->where('top', 1)->with('sites')->whereHas('sites', function($q) use ($siteid) {
			$q->where('site_id',$siteid);
		})->orderBy('id', 'desc')->take(4)->get();

		$data['bottom_event'] = Event::select('id','title','slug')->with('slugs')->where('publish', 1)->where('bottom', 1)->with('sites')->whereHas('sites', function($q) use ($siteid) {
			$q->where('site_id',$siteid);
		})->orderBy('id', 'desc')->take(4)->get();

		$data['pages'] = Page::with('sites')->with('slugs')->whereHas('sites', function($page) use ($siteid){
			$page->where('site_id', $siteid);
		})->take(3)->get();
		$view->with($data);

		
	}
}