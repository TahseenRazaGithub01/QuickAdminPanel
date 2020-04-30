<?php
namespace App\Http\Controllers\Web;
use Illuminate\Http\Request;
use App\Category;
use App\Page;
use App\Blog;
use App\SiteSetting;
use App\Slug;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Controller;
class BlogsController extends Controller {
  public function __construct() {
  }
  public function index() {
    $data = [];
    try{
      $siteid = config('app.siteid');
      if(!empty($_GET['category'])){
        $category = $_GET['category'];
        $data['blogCategory'] = Category::select('id','title','short_description')->CustomWhereBasedData($siteid)->whereHas('slugs',function($q) use ($category,$siteid){
        $q->where('slug',$category)->where('site_id',$siteid);
        })->with(['blogs'=> function($q1) use ($siteid){
        $q1->with(['slugs','tags'])->CustomWhereBasedData($siteid);
        }])->first();
     if(empty($data['blogCategory'])) abort(404);
        $data['list'] = Category::CustomWhereBasedData($siteid)->with(['blogs'=> function($q1){
          $q1->with(['slugs','tags']);
        }])->select('id','title')->orderBy('title')->get()->toArray();
        $data['pageCss'] = "blog_inner_category";
        return view('web.blog.blog_category')->with($data);
      }

        // $data['list'] = Category::with('slugs')->with(['blogs'=> function($q1){
        //   $q1->with('slugs')->with('tags');
        // }])->with('sites')->whereHas('sites', function($q) use ($siteid) {
        // $q->where('site_id',$siteid);
        // } )->where('publish',1)->orderBy('title')->get()->toArray();

        $data['list'] = Category::select('id','title')->CustomWhereBasedData($siteid)->with(['blogs'=> function($q1) use ($siteid){
          $q1->with('tags')->CustomWhereBasedData($siteid);
        }])->orderBy('title')->get()->toArray();  

        $data['pageCss'] = "blog_main_new";

        // $query = Blog::with('slugs')->with('sites')->whereHas('sites', function($q) use ($siteid){
        //   $q->where('site_id',$siteid);
        // })->with('categories')->get();

        $query = Blog::CustomWhereBasedData($siteid)->with(['categories' => function ($categoryQuery){
          $categoryQuery->select('id','title');
        }] )->get();
        $data['blogWithCategory'] = !$query->isEmpty() ? $query->random(1)->toArray() : $query->toArray();

        // $data['trendingBlog'] = Blog::with('slugs')->with('sites')->whereHas('sites', function($q) use ($siteid){
        //   $q->where('site_id',$siteid);
        // })->orderBy('sort', 'asc')->take(7)->get()->toArray();

        $data['trendingBlog'] = Blog::select('id','title')->CustomWhereBasedData($siteid)->orderBy('sort', 'asc')->take(3)->get()->toArray();

        // $data['latestBlog'] = Blog::with('categories')->with('slugs')->with('sites')->whereHas('sites', function($q) use ($siteid){
        //   $q->where('site_id',$siteid);
        // })->orderBy('id', 'desc')->take(4)->get()->toArray();

        $data['latestBlog'] = Blog::select('id','title')->with(['categories' => function ($categoryQuery){
          $categoryQuery->select('id','title');
        }] )->CustomWhereBasedData($siteid)->orderBy('id', 'desc')->take(4)->get()->toArray();
        return view('web.blog.index')->with($data);
    }catch (\Exception $e) {
        //dd($e);
      abort(404);
    }
  }
    public function detail() {
    $data = [];
    try{
      $siteid = config('app.siteid');
      $data['pageCss'] = "blog_detail";
      $data['list'] = Category::with(['blogs'=> function($q1) use ($siteid){
          $q1->CustomWhereBasedData($siteid);
        }])->CustomWhereBasedData($siteid)->orderBy('title')->get()->toArray();

      $data['detail'] = Blog::CustomWhereBasedData($siteid)->with('tags')->with('categories.slugs')->with('user')->where('id',PAGE_ID)->first();
      if($data['detail']) $data['detail']=$data['detail']->toArray(); else abort(404);
      // dd($data['detail']);
      $data['trendingBlog'] = Blog::CustomWhereBasedData($siteid)->orderBy('sort', 'asc')->take(3)->get()->toArray();

      $data['latestBlog'] = Blog::with('categories')->CustomWhereBasedData($siteid)->orderBy('id', 'desc')->take(5)->get()->toArray();

      $data['blogWithCategory'] = Blog::CustomWhereBasedData($siteid)->with('categories')->take(3)->get()->toArray();


          $meta['title']=$data['detail']['meta_title'];
          $meta['keywords']=$data['detail']['meta_keywords'];
          $meta['description']=$data['detail']['meta_description'];
          $data['meta']=$meta;

          return view('web.blog.detail')->with($data);
      }catch (\Exception $e) {
              abort(404);
      }

    }

    public function load_data(Request $request){
      $siteid = config('app.siteid');
      if($request->ajax()){
        if($request['data_id'] > 0){
          $output = '';
          $last_id = '';
          $category_id = $request['category_id'];
          $data = Blog::where('id', '>', $request['data_id'])->CustomWhereBasedData($siteid)->orderBy('id', 'ASC')->limit(2)->get()->toArray();

          if(!empty($data)){
            foreach($data as $record){
                $url = config("app.app_path")."/".$record['slugs']['slug'] ;
                $image = $record['image']['url'];
                $output .= '
                  <div class="col-1 standard-post horizontal" >
                      <div class="inner">
                          <div class="post-image">
                              <a href="'.$url.'" class="image">
                                  <img src="'.$image.'" alt="">
                              </a>
                          </div>
                          <div class="post-details">
                              <a href="#">
                                  <div class="category-details">
                                      <div class="category-tags">
                                          <span >'.$record["title"].'</span>
                                      </div>
                                  </div>
                                  <div class="post-title">
                                      <h2>'.$record["short_description"].'</h2>
                                  </div>
                              </a>
                          </div>
                          <span class="btm-line"></span>
                      </div>
                  </div>
                  ';
                $last_id = $record['id'];
              }

             $output .= '
             <div id="load_more">
              <button type="button" name="load_more_button" class="blgLoadMore form-control " blog-category-id="'.$category_id.'" data-id="'.$last_id.'" id="load_more_button">Load More</button>
             </div>
           ';

           echo $output;

          }else{

            $output .= '
             <div id="load_more">
              <button type="button" name="load_more_button" class="blgLoadMore form-control">No More Blogs</button>
             </div>
           ';

           echo $output ;

          }


        }else{

        }

      }
    }

    public function blogAuthor($slug){
      $data = [];
      $siteid = config('app.siteid');
      $data['pageCss'] = "blog_author";
      $user_id = User::where('name', $slug)->first();
      if($user_id) $user_id=$user_id->id; else abort(404);
      $data['list'] = Category::with(['blogs'=> function($q1) use ($siteid){
          $q1->CustomWhereBasedData($siteid);
        }])->CustomWhereBasedData($siteid)->orderBy('title')->get()->toArray();

      $data['blogListing'] = Blog::with('user')->with('categories')->CustomWhereBasedData($siteid)->orderBy('id', 'DESC')->where('user_id', $user_id)->get()->toArray();
      return view('web.blog.author')->with($data);

    }

    public function authorLoadMoreData(Request $request){
        $siteid = config('app.siteid');
        if($request->ajax()){
          if($request['data_id'] > 0){
            $output = '';
            $last_id = '';
            $data = Blog::where('id', '<', $request['data_id'])->with('categories')->CustomWhereBasedData($siteid)->orderBy('id', 'DESC')->take(3)->get()->toArray();

            if(!empty($data)){
            foreach($data as $blog){
                $url = config("app.app_path")."/".$blog['slugs']['slug'] ;
                $image = $blog['image']['url'];
                $blogImage = $blog['categories'][0]['icon']['url'];
                $blogCategoryTitle = $blog['categories'][0]['title'];
                $blogTitle = $blog['title'];

                $postTitle = substr($blog['title'], 0, 68);
                $postTitleLength = strlen($blog['title']);

                if($postTitleLength > 68){
                   $blogTitle = $postTitle." ... ";
                }else{
                    $blogTitle = $blog['title'];
                }

                $output .= '
                  <div class="col-3 standard-post">
                    <div class="inner">
                        <div class="post-image">
                            <a href="'.$url.'" class="image">
                                <img src="'.$image.'" alt="">
                            </a>
                        </div>
                        <div class="post-details">
                            <a href="'.$url.'">
                                <div class="category-details">
                                    <span class="cat-icon">
                                        <img src="'.$blogImage.'" data-src="'.$blogImage.'">
                                    </span>
                                    <div class="category-title">
                                        <span>'.$blogCategoryTitle.'</span>
                                    </div>
                                </div>
                                <div class="post-title">
                                    <h2>'.$blogTitle.'</h2>
                                </div>
                            </a>
                            <span class="btm-line"></span>
                        </div>
                    </div>
                </div>
                  ';
                $last_id = $blog['id'];
              }

             $output .= '
             <div id="load_more" style="width: 100%;">
              <button type="button" id="blog_load_more_button" blog-author-id="1" data-id="'.$last_id.'" class="blgLoadMore">LOAD MORE</button>
            </div>
           ';

           echo $output;

          }else{

            $output .= '
             <div id="load_more" style="width: 100%;">
              <button type="button" name="blog_load_more_button" class="blgLoadMore form-control">No More Blogs</button>
             </div>
           ';

           echo $output ;

          }

          }else{



          }

        }
    }

}
