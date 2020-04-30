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
class ProductsController extends Controller {
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
    public function detail($slug) {
        $data = [];
        try{
            $siteid = config('app.siteid');
            $data['categoryProducts'] = ProductCategory::where('slug',$slug)->with('productCategoryProducts')->CustomWhereBasedData($siteid)->get()->toArray();

            $meta['title']=$data['categoryProducts'][0]['meta_title'];
            $meta['keywords']=$data['categoryProducts'][0]['meta_keywords'];
            $meta['description']=$data['categoryProducts'][0]['meta_description'];
            $data['meta']=$meta;

            return view('web.product.detail')->with($data);
        }catch (\Exception $e) {
            abort(404);
        }
        
    }
}