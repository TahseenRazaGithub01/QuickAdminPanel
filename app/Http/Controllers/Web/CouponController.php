<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Coupon;
use App\Site;
use App\Event;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class CouponController extends Controller {
  public function index() {
    $data = [];
    try{
      $siteid = config('app.siteid');
      $data['detail'] = Event::with('categories')->with('stores')->with('coupons')->with(['sites'=> function($q) use ($siteid) {
      $q->where('site_id',$siteid);
      } ])->where('publish',1)->get()->toArray();
      return view('web.coupon.index')->with($data);
    }catch (\Exception $e) {
			abort(404);
    }
   
  }
  public function detail(){
    //dd($slug);
    $data = [];
    try{
      $siteid = config('app.siteid');
      $data['detail'] = Event::with('categories')->with('stores')->with('coupons')->with(['sites'=> function($q) use ($siteid) {
      $q->where('site_id',$siteid);
      } ])->where('publish',1)->where('id',PAGE_ID)->get()->toArray();
      //->where('id',PAGE_ID)->first()->toArray();

      dd($data['detail']);

      return view('web.coupon.detail')->with($data);
    }catch (\Exception $e) {
      abort(404);
    }
  }
  public function updateCouponViews(Request $request){
    $id = $request->data_id;
    $info = Coupon::where('id',$id)->first();
      if($info){
           $views = $info->viewed+1;
          $a = Coupon::where('id',$id)->update(['viewed' => $views]);
      }
  }

}