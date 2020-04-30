<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Category;
use App\Page;
use App\SiteSetting;
use App\ProductCategory;
use App\product;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
use Cache;
class Product_categoriesController extends Controller {
  public function __construct() {
  }
    public function index() {
        $data = [];
        try{
            $siteid = config('app.siteid');
            $data['detail'] = ProductCategory::select('id','name','slug')->CustomWhereBasedData($siteid)->get()->toArray();
            return view('web.product.index')->with($data);
        }catch (\Exception $e) {
            abort(404);
        }
    
    }
    public function detail(Request $request) {
        $data = [];
        try{
            $siteid = config('app.siteid');
            // $data['categoryProducts'] = ProductCategory::where('id',PAGE_ID)->with('productCategoryProducts')->with('sites')->whereHas('sites', function($q) use ($siteid) {
            // $q->where('site_id',$siteid);
            //     } )->first()->toArray();

            $data['categoryProducts'] = ProductCategory::where('id',PAGE_ID)->with('productCategoryProducts')->CustomWhereBasedData($siteid)->first();

            if($data['categoryProducts'] == null){
                abort(404);
            }

            $meta['title']=$data['categoryProducts']['meta_title'];
            $meta['keywords']=$data['categoryProducts']['meta_keywords'];
            $meta['description']=$data['categoryProducts']['meta_description'];
            $data['meta']=$meta;

            return view('web.product.detail')->with($data);
        }catch (\Exception $e) {
            abort(404);
        }
        
    }
}