<?php

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/home', 'HomeController@index')->name('home');

//Route::get('/', 'TestController@index');

Auth::routes();

Route::get('/item', 'ItemController@index')->name('index');

Route::get('/detail/{id}', 'ItemController@detail')->name('detail');

//User認証不要
Route::get('/', function() {
	return redirect('/home');
});

//Userログイン後
Route::group(['middleware' => 'auth:user'], function() {
	Route::get('/home', 'HomeController@index')->name('home');
});

//Admin認証不要
Route::group(['prefix' => 'admin'], function() {
	Route::get('/', function() {
		return redirect('/admin/home');
	});
	Route::get('login', 'Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'Admin\LoginController@login');
});

//Adminログイン後
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function() {
	Route::post('logout', 'Admin\LoginController@logout')->name('admin.logout');
	Route::get('home', 'Admin\HomeController@index')->name('admin.home');
	Route::get('item', 'Admin\ItemController@index')->name('admin.index');
	Route::get('detail/{id}', 'Admin\ItemController@detail')->name('admin.detail');
});
