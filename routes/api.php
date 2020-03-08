<?php

// Open Routes
Route::prefix('v1.0')->group(function() {


});

// Auth Routes
Route::prefix('v1.0')
    ->middleware(['auth:api', 'suspended'])
    ->group(function () {
    Route::get('me', 'Auth\UserController@index')->name('me');

    // User
    Route::put('user', 'Users\UpdateController')->name('user.update');
    Route::post('user/avatar', 'Users\AvatarController')->name('user.avatar');
    Route::put('user/password', 'Users\PasswordController')->name('user.password');

    // Vendors
    Route::get('vendors', 'VendorsController@index')->name('vendors.index');
    Route::post('vendors', 'VendorsController@store')->name('vendors.store');
    Route::post('vendors/{vendor}/products', 'Vendors\ProductsController@store')->name('products.store');

    // Products

    Route::get('products', 'ProductsController@index')->name('products.index');
});

// Admin Routes
Route::prefix('v1.0')
    ->middleware(['auth:api', 'verified', 'role:admin'])
    ->group(function () {

    // Users
    Route::apiResource('users', 'UsersController');

    Route::post('users/{user}/suspend', 'UsersController@suspend')->name('users.suspend');
    Route::post('users/{user}/unsuspend', 'UsersController@unsuspend')->name('users.unsuspend');
});
