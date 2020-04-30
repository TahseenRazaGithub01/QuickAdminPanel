<?php
namespace App\Http\Controllers\Web;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Store;
use App\Http\Controllers\Controller;
class Routes extends Controller {
  public $slug;
  public function __construct()
  {
//    $this->middleware('checkCountry');
    $this->slug = new Slug;
  }
  public function find_route($parm1 = "", $parm2 = "", $parm3 = "", $parm4 = "") {
    $request = Request();
    
    $parm1 = strtolower($parm1);
    $parm2 = strtolower($parm2);
    $parm3 = strtolower($parm3);
    $parm4 = strtolower($parm4);
    $link = ""; // website.com
    $get = config('app.db_obj');
    
    if(!empty($get)){
        $reg = $get->country_code;
        if(strtolower($parm1) == strtolower($reg)){
            $parm0 = $parm1; $parm1 = $parm2; $parm1 = $parm2; $parm2 = $parm3; $parm3 = $parm4;
        } 
    }
    if(empty($parm1)){
        $link = ""; // website.com
    } 
    else if(empty($parm2)){
        // 1 parameter after public
        // website.com/param1
        $link = $parm1;
    } 
    else if(empty($parm3)) {
        // if there is two params after public but 2nd param is equal to one of following param than
        // it means it is some inner page of store so we have to modify our logic to access that page
        // below is working example of this
        // we will ignore 2nd param and treat link as single param link and will hande logic in controller
        // for param which we ignored
        if(preg_match("/products|special|main|category|compare/is", $parm2))
            $link = $parm1;
        // or if there is two params after public but 2nd param is not equal to any of above param than
        // no need to modify or make any new logic
        // 2 parameters after public
        // website.com/param1/param2
        else
            $link = $parm1."/".$parm2;
    } 
    else if(!empty($parm3)){
        // 3 parameters after public
        // website.com/param1/param2/param3
        $link = $parm1."/".$parm2."/".$parm3;
    }
    // convert browser url in lowercase
    // e.g: example.com/users
    $link = strtolower($link);

    // if there is no parameter or "parameter = home" than redirect to home page
    if(empty($link) || $link == "home"){
        return true;
    }
    
    // Find Slug In Db
//    if (strpos($link, 'stores/') !== false) {
//    $link = str_replace('stores/', '', $link);
//    $store = 'stores';
//    }
      $siteid = config('app.siteid');
    $slug = $this->slug->get_slug($link,$siteid);
      //for old url to new url redirect work 
      if(isset($slug->old_slug) && $slug->old_slug == $link){
          Define("OLD_URL", $slug->old_slug);
        }
      //for old url to new url redirect work end
        
   //dd($link,$slug);
//      dd($link);
    // When Slug Record Not Found
    if(!empty($slug)){
      $controller = $slug->table_name;
      $page_type  = $slug->page_type;
      $obj_id     = $slug->obj_id;
      ///$link_slug  = $store =='stores' ? 'stores/'.$slug->slug : $slug->slug;
      $link_slug  = $slug->slug; 
      Define("ROUTE_PARM1", $parm1);
      Define("ROUTE_PARM2", $parm2);
      Define("ROUTE_PARM3", $parm3);
      Define("ROUTE_PARM4", $parm4);
      // Link That In Url
     
      Define("ROUTE_LINK", $link);
      Define("SLUG_CONTROLLER", ucfirst($controller).'Controller'); // CONTROLLER NAME
      Define("ROUTE_NAME", $controller); // Route Name
      Define("PAGE_TYPE", $page_type); // Page Types E.g: Events In Category
      Define("PAGE_ID", $obj_id); // Page Id That Data Need To Show E.g obj_id From Slugs And Pk From table_name
      Define("SLUG_LINK", $link_slug); // Link Slug From Db E.g Browser Url, E.g www.oci.com/param1/param2/param3
      return true;
    }

    
    return true;
  }
}