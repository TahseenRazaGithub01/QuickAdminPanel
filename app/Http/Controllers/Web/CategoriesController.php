<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Category;
use App\Page;
use App\SiteSetting;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
class CategoriesController extends Controller {
  public function __construct() {
  }
  public function index() {
    $data = [];
    try{
        $siteid = config('app.siteid');
        $data['list'] = Category::CustomWhereBasedData($siteid)->select('id','title')->get()->toArray();
        return view('web.category.index')->with($data);
    }catch (\Exception $e) {
			abort(404);
    }
   
  }
    public function detail() {
        $data = [];
        try{
        $siteid = config('app.siteid');
        $data['detail'] = Category::select('id','title','slug','short_description','long_description','meta_title','meta_keywords','meta_description','sort','parent_id','user_id')->with(['categoryStores'=>function($q1) use ($siteid){
            $q1->select('id','name')->CustomWhereBasedData($siteid);
        }])->CustomWhereBasedData($siteid)->with('parentCategories')->where('id',PAGE_ID)->first();
        if($data['detail']) $data['detail']=$data['detail']->toArray(); else abort(404);
        $data['popular'] = Category::CustomWhereBasedData($siteid)->where('popular',1)->orderBy('title')->get()->toArray();

        $meta['title']=$data['detail']['meta_title'];
        $meta['keywords']=$data['detail']['meta_keywords'];
        $meta['description']=$data['detail']['meta_description'];
        $data['meta']=$meta;

        return view('web.category.detail')->with($data);
        }catch (\Exception $e) {
                abort(404);
        }
   
    }
}