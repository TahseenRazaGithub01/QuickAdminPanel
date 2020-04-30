<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Category;
use App\Coupon;
use App\Store;
use App\Page;
use App\SiteSetting;
use App\Banner;
use App\Site;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller {
    public function __construct() {
    }
    public function index() {
        $data = [];
        try{
            $siteid = config('app.siteid');
            $dt = Carbon::now();
            $date = $dt->toDateString();
            // $data['banners'] = Banner::with('sites')->whereHas('sites', function($q) use ($siteid){
            //     $q->where('site_id', $siteid);
            // } )->orderBy('sort', 'asc')->get()->toArray();

            $data['banners'] = Banner::CustomWhereBasedData($siteid)->select('id','title','link','sort')->orderBy('sort', 'asc')->get()->toArray();

            // $data['popularStores'] = Store::where('popular',1)->with('slugs')->where('publish',1)
            //     ->with('sites')->whereHas('sites', function($q) use ($siteid){
            //         $q->where('site_id', $siteid);
            // } )->orderBy('name', 'asc')->get()->toArray();

            $data['popularStores'] = Store::select('id','name')->CustomWhereBasedData($siteid)->where('popular',1)->orderBy('name', 'asc')->get()->toArray();
            $query = Coupon::select('id','store_id','description','title','date_expiry','viewed','code','featured','exclusive','verified','popular','affiliate_url')->CustomWhereBasedData($siteid)->where('date_expiry', '>=', $date);
            $query = $query->where(function($q) {
                $q->orwhere('featured', 1)->orwhere('popular', 1);
            });

            // $query = Coupon::with('sites','store:id')->whereHas('sites', function($q2) use ($siteid) {
            //     $q2->where('site_id',$siteid);
            // })->where('publish',1)->where('date_expiry', '>=', $date);
            // $query = $query->where(function($q) {
            //     $q->orwhere('featured', 1)->orwhere('popular', 1);
            // });

            // $data['featuredCouponsAndPopularCoupons'] = $query->orderBy('featured')->orderBy('title', 'asc')->get()->toArray();

            // New Query
            $query = Coupon::select('id','description','title','date_expiry','viewed','code','featured','exclusive','verified','popular','affiliate_url','coupon_id','store_id','recommended','free_shipping')->CustomWhereBasedData($siteid)->where('date_expiry', '>=', $date);
            $query = $query->where(function($q) {
                $q->orwhere('featured', 1)->orwhere('popular', 1)->orwhere('recommended', 1);
            });
            $data['featuredCouponsAndPopularCoupons'] = $query->with('store.slugs')->orderBy('featured')->orderBy('title', 'asc')->get()->toArray();

            // $data['featuredCategories'] = Category::with('slugs')->with('sites')->whereHas('sites', function($q2) use ($siteid) {
            //     $q2->where('site_id',$siteid);
            // })->where('featured',1)->where('publish',1)->orderBy('title', 'asc')->get()->toArray();

            $data['sites'] = Site::select('id','country_name','country_code','url')->wherePublish(1)->get()->toArray();
            return view('web.home.index')->with($data);
        }catch (\Exception $e) {
            abort(404);
        }
    }
    public function _404(){
        $data = [];
        try{
            $data = _404();
            return view('web.home.index')->with($data);
        }catch (\Exception $e) {
            abort(404);
        }    
    }
}
