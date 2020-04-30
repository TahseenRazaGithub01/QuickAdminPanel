<?php
Route::redirect('/admin', 'admin/login');
Route::get('admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('admin/login', 'Auth\LoginController@login');
Route::any('admin/logout', 'Auth\LoginController@logout')->name('logout');
Route::redirect('admin/home', '/admin');
Route::redirect('/admin/register', 'admin/login');
//Route::redirect('admin', '/admin/login');
Route::get('/admin/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

#Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('set-id', 'HomeController@setSiteId');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::resource('users', 'UsersController');

    // Categories
    Route::delete('categories/destroy', 'CategoryController@massDestroy')->name('categories.massDestroy');
    Route::post('categories/media', 'CategoryController@storeMedia')->name('categories.storeMedia');
    Route::resource('categories', 'CategoryController');

    Route::post('ajaxhandleruploadbyck', 'UploadimageController@upload');

    // Blogs
    Route::delete('blogs/destroy', 'BlogController@massDestroy')->name('blogs.massDestroy');
    Route::post('blogs/media', 'BlogController@storeMedia')->name('blogs.storeMedia');
    Route::resource('blogs', 'BlogController');

    // Sites
    Route::delete('sites/destroy', 'SitesController@massDestroy')->name('sites.massDestroy');
    Route::post('sites/media', 'SitesController@storeMedia')->name('sites.storeMedia');
    Route::resource('sites', 'SitesController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Stores
    Route::delete('stores/destroy', 'StoresController@massDestroy')->name('stores.massDestroy');
    Route::post('stores/media', 'StoresController@storeMedia')->name('stores.storeMedia');
    Route::resource('stores', 'StoresController');
    Route::get('store/published', 'StoresController@published');

    // Coupons
    Route::delete('coupons/destroy', 'CouponsController@massDestroy')->name('coupons.massDestroy');
    Route::post('coupons/media', 'CouponsController@storeMedia')->name('coupons.storeMedia');
    Route::resource('coupons', 'CouponsController');
    Route::get('coupon/published', 'CouponsController@published');

    // Events
    Route::delete('events/destroy', 'EventsController@massDestroy')->name('events.massDestroy');
    Route::post('events/media', 'EventsController@storeMedia')->name('events.storeMedia');
    Route::resource('events', 'EventsController');

    // Pages
    Route::delete('pages/destroy', 'PagesController@massDestroy')->name('pages.massDestroy');
    Route::post('pages/media', 'PagesController@storeMedia')->name('pages.storeMedia');
    Route::resource('pages', 'PagesController');

    // Presses
    Route::delete('presses/destroy', 'PressController@massDestroy')->name('presses.massDestroy');
    Route::post('presses/media', 'PressController@storeMedia')->name('presses.storeMedia');
    Route::resource('presses', 'PressController');

    // Tags
    Route::delete('tags/destroy', 'TagsController@massDestroy')->name('tags.massDestroy');
    Route::resource('tags', 'TagsController');

    // Product Categories
    Route::delete('product-categories/destroy', 'ProductCategoryController@massDestroy')->name('product-categories.massDestroy');
    Route::post('product-categories/media', 'ProductCategoryController@storeMedia')->name('product-categories.storeMedia');
    Route::resource('product-categories', 'ProductCategoryController');

    // Products
    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');
    Route::post('products/media', 'ProductsController@storeMedia')->name('products.storeMedia');
    Route::resource('products', 'ProductsController');

    // Addspace Stores
    Route::delete('addspace-stores/destroy', 'AddspaceStoresController@massDestroy')->name('addspace-stores.massDestroy');
    Route::resource('addspace-stores', 'AddspaceStoresController');

    // Add Space Products
    Route::delete('add-space-products/destroy', 'AddSpaceProductsController@massDestroy')->name('add-space-products.massDestroy');
    Route::resource('add-space-products', 'AddSpaceProductsController');

    // Banners
    Route::delete('banners/destroy', 'BannerController@massDestroy')->name('banners.massDestroy');
    Route::post('banners/media', 'BannerController@storeMedia')->name('banners.storeMedia');
    Route::resource('banners', 'BannerController');

    // Networks
    Route::delete('networks/destroy', 'NetworkController@massDestroy')->name('networks.massDestroy');
    Route::resource('networks', 'NetworkController');

    // Subscribers
    // Route::resource('subscribers', 'SubscribersController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);
    Route::resource('subscribers', 'SubscribersController');
    Route::resource('contacts', 'ContactController');

    Route::post('unique_slug', 'SlugController@uniqueSlug');
    Route::post('filter_records', 'FilterController@records');
});
