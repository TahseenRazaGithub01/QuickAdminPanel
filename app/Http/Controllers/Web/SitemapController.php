<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Category;
use App\Page;
use App\Store;
use App\Blog;
use App\Event;
use App\SiteSetting;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
class SitemapController extends Controller {
  	public function __construct() {
  	}

  	public function index() {
  	  	$data = [];
		//    $data['seo'] = SiteSetting::orderBy('id', 'desc')->select('meta_title', 'meta_keywords', 'meta_description')->first();
    	return view('web.sitemap.index')->with($data);
  	}

  	public function sitemap(){
  		$siteid = config('app.siteid') ;

  		$data['pages'] = Page::select('id','title')->CustomWhereBasedData($siteid)->where('publish',1)->orderBy('title', 'ASC')->get()->toArray();

  		$data['categories'] = Category::select('id','title','parent_id')->CustomWhereBasedData($siteid)->where('publish',1)->orderBy('title', 'ASC')->get()->toArray();

  		$data['stores'] = Store::select('id','name')->CustomWhereBasedData($siteid)->where('publish',1)->orderBy('updated_at', 'DESC')->get()->toArray();

  		$data['blog'] = Blog::select('id','title')->CustomWhereBasedData($siteid)->where('publish',1)->orderBy('created_at', 'DESC')->get()->toArray();

  		$data['events'] = Event::select('id','title')->CustomWhereBasedData($siteid)->where('publish',1)->orderBy('title', 'ASC')->get()->toArray();

  		return response()->view("web.common.sitemap", with($data))->header('Content-Type', 'text/xml');
  	}
}