<?php
namespace App\Http\Controllers\Admin;
use App\Blog;
use App\Press;
use App\Page;
use App\Store;
use App\Category;
use App\Event;
use App\Slug;
use App\ProductCategory;
use Request;
use App\Http\Controllers\Controller;

class SlugController extends Controller {
    public $press = '';
    public $blog = '';
    public $pages = '';
    public $category = '';
    public function __construct() {
        $this->blog = new Blog;
        $this->pages = new Page;
        $this->press = new Press;
        $this->store = new Store;
        $this->category = new Category;
        $this->event = new Event;
        $this->productcategory = new ProductCategory;
    }

    public function uniqueSlug() {
        /*if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        }*/
        $array          = array();
        $slug           = Request::get("slug");
        $org_slug       = Request::get('org_slug');
        $slug_model     = Request::get('slug_model');
        $edit_id        = Request::get('edit_id');
        $parent_slug    = Request::get('parent_slug');
        $slug_chk       = Request::get('slug_chk') ?? 0;
        $sites          = Request::get('sites') ?? [];
        $checkNo        = 0;

        $get_related_data = $this->{$slug_model}->getBasicData();

        $slug = ltrim($slug, "/");

        if(empty($slug)){
            echo 0;
            return;
        }

        $parent_slug_check = '';

        if(!empty($parent_slug) || $parent_slug != 0){
            $get2 = $this->{$slug_model}->getparentData($parent_slug);
            if($get2){
                $parent_slug_check = $get2['parent_slug'].'/';
            } else {
                $parent_slug_check = '';
            }
        }

        $org_slug = sanitize_slug($org_slug);
        $slug = sanitize_slug($slug);

        if((empty($org_slug) && empty($edit_id)) || $slug_chk > 0){

            $query = Slug::where('table_name', $get_related_data['table_name']);
            if (count($sites) > 0) {
                $query->whereIn('site_id', $sites);
            }
            $query = $query->where('slug', $parent_slug_check . $get_related_data['slug_prefix'] . $slug);
            $checkNo = $query->count();

            if($checkNo > 0){
                $array['message'] = 'slug-not-unique';
                $array['return_slug'] = $slug.'-'.$query->latest()->first()->id;
            } else {
                $array['message'] = 'slug-unique';
                $array['return_slug'] = $slug;
            }

        }
        else if(!empty($org_slug) && empty($edit_id)){

            if($parent_slug_check.$get_related_data['slug_prefix'].$org_slug == $parent_slug_check.$get_related_data['slug_prefix'].$slug) {
                $query = Slug::where('table_name', $get_related_data['table_name']);
                if(count($sites) > 0) {
                    $query->whereIn('site_id', $sites);
                }
                $checkNo = $query->where('slug', $parent_slug_check.$get_related_data['slug_prefix'].$slug)->count();
            }

            if($checkNo > 0){
                $array['message'] = 'slug-not-unique';
                $array['return_slug'] = $slug.'-'.$query->latest()->first()->id;
            }
            else{
                $array['message'] = 'slug-unique';
                $array['return_slug'] = $org_slug;
            }
        }
        else if(empty($org_slug) && !empty($edit_id)){

            $query = Slug::where('table_name', $get_related_data['table_name']);
            if(count($sites) > 0) {
                $query->whereIn('site_id', $sites);
            }
            $checkNo = $query->where('slug', $parent_slug_check.$get_related_data['slug_prefix'].$slug)
                ->where('obj_id', $edit_id)
                ->count();

            if($checkNo > 1){
                $array['message'] = 'slug-not-unique';
                $array['return_slug'] = $slug.'-'.$query->latest()->first()->id;
            } else {
                $array['message'] = 'slug-unique';
                $array['return_slug'] = $slug;
            }
        }
        else if(!empty($org_slug) && !empty($edit_id)){

            $query = Slug::where('table_name', $get_related_data['table_name']);
            if (count($sites) > 0) {
                $query->whereIn('site_id', $sites);
            }
            $checkNo = $query->where('slug', $parent_slug_check . $get_related_data['slug_prefix'] . $slug)
                ->count();

            if($checkNo > 0){
                $array['message'] = 'slug-not-unique';
                $array['return_slug'] = $slug.'-'.$query->latest()->first()->id;
            } else {
                $array['message'] = 'slug-unique';
                $array['return_slug'] = $slug;
            }
        }

        return json_encode($array);
    }
}
