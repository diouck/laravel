<?php
/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
|*/
Route::group(['prefix' => 'admin',	'middleware' => ['web','admin'],'namespace' => 'Modules\Acl\Http\Controllers'], function(){

	Route::get('/',array('as' => 'dashboard', 'uses' => 'AclController@index'));
	
	Route::resource('user', 'UserController');
	Route::resource('application', 'ApplicationController');
	Route::resource('role', 'RoleController');
	Route::resource('perimeter', 'PerimeterController');
	Route::resource('authorization', 'AuthorizationController');
});