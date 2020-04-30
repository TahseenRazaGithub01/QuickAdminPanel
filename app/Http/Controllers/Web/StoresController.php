<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Store;
use App\Page;
use App\SiteSetting;
use App\Blog;
use App\Coupon;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
class StoresController extends Controller {
  public function __construct() {
      $this->store_model = new Store();
  }
  public function index(Request $request) {
    $data = [];
    try{
        if($request->Input('q')){
		$siteid = config('app.siteid');
        $data['list'] = $this->store_model->getAllStores($siteid,$request->Input('q'));
        $data['popular'] = $this->store_model->getPopularStores($siteid);
        return view('web.store.index')->with($data);
		}else{
		$siteid = config('app.siteid');
        $data['list'] = $this->store_model->getAllStores($siteid);
        $data['popular'] = $this->store_model->getPopularStores($siteid);
        return view('web.store.index')->with($data);
		}
    }catch (\Exception $e) {
        abort(404);
    }

  }
    public function detail() {
        $data = [];
        try{
            $siteid = config('app.siteid');
            $dt = Carbon::now();
            $date = $dt->toDateString();
            // $data['detail'] = Store::with('storeCoupons')->with(['storeCoupons'=> function($s) use ($date,$siteid){
            //     $s->where('date_expiry', '>=', $date)->CustomWhereBasedData($siteid);
            // }])->with('categories')->with('sites')->whereHas('sites', function($q) use ($siteid) {
            // $q->where('site_id',$siteid);
            // } )->where('publish',1)->where('id',PAGE_ID)->first()->toArray();

            $data['detail'] = Store::with(['storeCoupons', 'storesAddspaceStores'])->with(['storeCoupons'=> function($s) use ($date,$siteid){
                $s->where('date_expiry', '>=', $date)->CustomWhereBasedData($siteid);
            }])->with('categories')->CustomWhereBasedData($siteid)->where('id',PAGE_ID)->first();
            $data['detail'] = ($data['detail']) ? $data['detail']->toArray() : null;
            if($data['detail'] == null){
                abort(404);
            }

            // $data['popular'] = Store::with('storeCoupons')->with('slugs')->with('categories')->with(['sites'=> function($q) use ($siteid) {
            // $q->where('site_id',$siteid);
            // } ])->where('publish',1)->where('id',PAGE_ID)->where('popular',1)->get()->toArray();

            $data['popular'] = Store::select('id','name','short_description','long_description','html_tags','script_tags','meta_title','meta_keywords','meta_description')->with('storeCoupons')->with('categories')->CustomWhereBasedData($siteid)->where('popular',1)->get()->toArray();

            $meta['title']=$data['detail']['meta_title'];
            $meta['keywords']=$data['detail']['meta_keywords'];
            $meta['description']=$data['detail']['meta_description'];
            $data['meta']=$meta;

            return view('web.store.detail')->with($data);
        }catch (\Exception $e) {
                abort(404);
        }

    }

    public function search(Request $request){
        $data = [];
        try{
            $_search_keyword = $request->search;
            $siteid = config('app.siteid');
            $stores = Store::where('name','LIKE','%'.$_search_keyword.'%')->CustomWhereBasedData($siteid)->get();
        if ($stores) {
			foreach ($stores as $k => $v) {
				$data[$k]['title'] = $v->name;
				$data[$k]['url'] = config('app.app_path').'/'.$v->slugs->slug;
			}
			return ($data);
		} else {
			return 0;
		}
        }catch (\Exception $e) {
                abort(404);
        }
    }

    public function searchBlog(Request $request){
        $data = [];
        try{
            $_search_keyword = $request->search;
            $siteid = config('app.siteid');
            $blogs = Blog::where('title','LIKE','%'.$_search_keyword.'%')->CustomWhereBasedData($siteid)->get();

        if ($blogs) {
            foreach ($blogs as $k => $v) {
                $data[$k]['title'] = $v->title;
                $data[$k]['url'] = config('app.app_path').'/'.$v['slugs']['slug'];
            }
            return ($data);
        } else {
            return 0;
        }
        }catch (\Exception $e) {
                abort(404);
        }
    }
}
