<?php
Route::get('/us', function () {
    return redirect('/');
});
Route::group(['namespace' => 'Web', 'prefix' => config('app.route_prefix')], function () {
//Route::group(['as' => 'web.', 'namespace' => 'Web'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/category', 'CategoriesController@index');
    Route::get('/sitemap', 'StoresController@index');
    Route::get('/sitemap.xml', 'SitemapController@sitemap');
    Route::get('/blog', 'BlogsController@index')->name('blog');
    Route::get('/load-more-data', 'BlogsController@load_data');
    Route::get('/blog/author/{slug}', 'BlogsController@blogAuthor');
    Route::post('/author-load-more-data', 'BlogsController@authorLoadMoreData');
    Route::get('/product', 'Product_categoriesController@index')->name('product');
   // Route::get('/product/{slug}', 'ProductsController@detail')->name('product.detail');
//    Route::get('/sitemap', 'SitemapController@index')->name('sitemap');
    Route::get('/coupons', 'CouponController@index')->name('coupons');
    Route::get('/update-coupon-views', 'CouponController@updateCouponViews');
    Route::post('_subscribe', 'ContactController@submitSubscribe')->name('submitsubscribe');
    Route::get('/contact_us', 'ContactController@contactDetails');
    Route::post('contactStore', 'ContactController@contactStore')->name('contact.store');
    Route::get('/search_store', 'StoresController@search');
    Route::get('/search_blog', 'StoresController@searchBlog');
  //Route::get('{slug?}', 'SlugController@slugFinder')->name('slugFinder');
//for old url to new url redirect work 
  if(defined('OLD_URL')){
      Route::get('/'.OLD_URL, function () {
          $reg = config('app.route_prefix') ? '/'.config('app.route_prefix').'/' : config('app.route_prefix');
            return redirect($reg.SLUG_LINK);
      });
  }
//for old url to new url redirect work end
  if(defined('SLUG_LINK')){
  if(ROUTE_NAME == 'pages'){
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'stores'){
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'events') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'blogs') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'presses') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'categories') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'pages') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  }
  if(ROUTE_NAME == 'product_categories') {
    Route::get(SLUG_LINK, SLUG_CONTROLLER.'@detail')->name(ROUTE_NAME);
  } 
}else{
    Route::match(["get","post"], '/{parm1?}/{parm2?}/{parm3?}/{parm4?}', 'HomeController@_404')->name('FourOFour');
}
});