<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Categories
    Route::post('categories/media', 'CategoryApiController@storeMedia')->name('categories.storeMedia');
    Route::apiResource('categories', 'CategoryApiController');

    // Blogs
    Route::post('blogs/media', 'BlogApiController@storeMedia')->name('blogs.storeMedia');
    Route::apiResource('blogs', 'BlogApiController');

    // Sites
    Route::post('sites/media', 'SitesApiController@storeMedia')->name('sites.storeMedia');
    Route::apiResource('sites', 'SitesApiController');

    // Stores
    Route::post('stores/media', 'StoresApiController@storeMedia')->name('stores.storeMedia');
    Route::apiResource('stores', 'StoresApiController');

    // Coupons
    Route::post('coupons/media', 'CouponsApiController@storeMedia')->name('coupons.storeMedia');
    Route::apiResource('coupons', 'CouponsApiController');

    // Events
    Route::post('events/media', 'EventsApiController@storeMedia')->name('events.storeMedia');
    Route::apiResource('events', 'EventsApiController');

    // Pages
    Route::post('pages/media', 'PagesApiController@storeMedia')->name('pages.storeMedia');
    Route::apiResource('pages', 'PagesApiController');

    // Presses
    Route::post('presses/media', 'PressApiController@storeMedia')->name('presses.storeMedia');
    Route::apiResource('presses', 'PressApiController');

    // Tags
    Route::apiResource('tags', 'TagsApiController');

    // Product Categories
    Route::post('product-categories/media', 'ProductCategoryApiController@storeMedia')->name('product-categories.storeMedia');
    Route::apiResource('product-categories', 'ProductCategoryApiController');

    // Products
    Route::post('products/media', 'ProductsApiController@storeMedia')->name('products.storeMedia');
    Route::apiResource('products', 'ProductsApiController');

    // Addspace Stores
    Route::apiResource('addspace-stores', 'AddspaceStoresApiController');

    // Add Space Products
    Route::apiResource('add-space-products', 'AddSpaceProductsApiController');

    // Banners
    Route::post('banners/media', 'BannerApiController@storeMedia')->name('banners.storeMedia');
    Route::apiResource('banners', 'BannerApiController');

    // Networks
    Route::apiResource('networks', 'NetworkApiController');
});
