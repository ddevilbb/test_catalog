<?php

Route::group(['middleware' => ['web']], function () {
    $namespace = 'App\Applications\Catalog\Http\Controllers\\';
    Route::get('/', $namespace . 'CatalogController@index')->name('main');
    Route::get('/catalog/{alias}', $namespace . 'CatalogController@showCategory')->name('show_category');
    Route::get('/catalog/{alias}/{id}', $namespace . 'CatalogController@showProduct')->name('show_product');
    Route::get('/search', $namespace . 'CatalogController@search')->name('search');
});