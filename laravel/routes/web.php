<?php

Auth::routes();

//アイテム
Route::group(['prefix' => 'item'], function() {
	Route::get('index', 'ItemController@index')->name('item.index');
	Route::get('/detail/{id}', 'ItemController@detail')->name('item.detail');
});

//カート
Route::group(['prefix' => 'cart', 'middleware' => 'auth:user'], function() {
	Route::post('add', 'CartController@add')->name('cart.add');
	Route::get('index', 'CartController@index')->name('cart.index');
	Route::post('remove', 'CartController@remove')->name('cart.remove');
});

//お届け先住所
Route::group(['prefix' => 'adress', 'middleware' => 'auth:user'], function() {
	Route::get('index', 'AdressController@index')->name('adress.index');
	Route::get('add', 'AdressController@add')->name('adress.add');
	Route::post('add', 'AdressController@create')->name('adress.create');
	Route::get('edit/{id}', 'AdressController@edit')->name('adress.edit');
	Route::post('edit', 'AdressController@update')->name('adress.update');
	Route::get('remove/{id}', 'AdressController@remove')->name('adress.remove');
});

//アカウント編集
Route::group(['prefix' => 'userEdit', 'middleware' => 'auth:user'], function() {
	Route::get('edit', 'UserEditController@edit')->name('userEdit.edit');
	Route::post('edit', 'UserEditController@update')->name('userEdit.update');
	Route::get('email', 'UserEditController@sendChangeEmailLink')->name('userEdit.sendEmail');
	Route::get('reset/{token}', 'UserEditController@reset')->name('userEdit.reset');

});

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
	Route::get('item', 'Admin\ItemController@item')->name('admin.item');
	Route::get('detail/{id}', 'Admin\ItemController@detail')->name('admin.detail');
	Route::get('add', 'Admin\ItemController@add')->name('admin.add');
	Route::post('add', 'Admin\ItemController@create')->name('admin.create');
	Route::get('edit/{id}', 'Admin\ItemController@edit')->name('admin.edit');
	Route::post('edit/{id}', 'Admin\ItemController@update')->name('admin.update');
	Route::get('users', 'Admin\UserController@index')->name('admin.users_index');


});

