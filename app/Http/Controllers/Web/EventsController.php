<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Coupon;
use App\Site;
use App\Event;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class EventsController extends Controller {
  public function detail(){
    $data = [];
    try{
      $siteid = config('app.siteid');
      $dt = Carbon::now();
      $date = $dt->toDateString();
      $data['detail'] = Event::select('id','title','short_description','long_description','meta_title','meta_keywords','meta_description')->with('categories')->with(['stores'=>function($storeQuery) use ($siteid) {
        $storeQuery->CustomWhereBasedData($siteid);
      }])->with(['coupons'=> function($d) use ($date){
        $d->select(['id','store_id','title','description','affiliate_url','verified','sort','date_expiry','code','viewed','free_shipping','exclusive'])->with('store.slugs')->where('date_expiry', '>=', $date)->wherePublish(1);
      } ])->CustomWhereBasedData($siteid)->where('id',PAGE_ID)->first();
      if($data['detail']) $data['detail']=$data['detail']->toArray(); else abort(404);
      
      $meta['title']=$data['detail']['meta_title'];
      $meta['keywords']=$data['detail']['meta_keywords'];
      $meta['description']=$data['detail']['meta_description'];
      $data['meta']=$meta;
      return view('web.event.detail')->with($data);
    }catch (\Exception $e) {
      abort(404);
    }
  }

}