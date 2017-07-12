<?php

Route::group(['prefix' => 'webmap','middleware' => ['web','auth','application'], 'namespace' => 'Modules\Webmap\Http\Controllers'], function()
{
	Route::get('/',array('as' => 'commerce.project', 'uses' => 'PostController@index'));
	Route::post('/',array('as' => 'commerce.ajax.index', 'uses' => 'PostController@indexAjax'));
	Route::post('/popup/{id}',array('as' => 'commerce.ajax.single', 'uses' => 'PostController@popupAjax'));
	Route::post('/search/popup/{id}',array('as' => 'commerce.ajaxsearch.single', 'uses' => 'PostController@popupAjax'));
	Route::get('/search',array('as' => 'commerce.search', 'uses' => 'PostController@search'));
	Route::post('/search',array('as' => 'commerce.ajax.search', 'uses' => 'PostController@searchAjax'));

	Route::group(['middleware' => ['contributor']], function()
	{
		Route::get('/create',array('as' => 'commerce.create','uses' => 'RevisionController@create'));
		Route::post('/create',array('as' => 'commerce.new','uses' => 'RevisionController@newStore'));
		Route::post('/creategeom',array('as' => 'commerce.creategeom','uses' => 'RevisionController@geomAjax'));
	});
	Route::group(['prefix' => 'admin','middleware' => ['moderator']], function()
	{
		Route::get('/',array('as' => 'commercerevision.dashboard', 'uses' => 'RevisionController@dashboard'));
		Route::get('posts',array('as' => 'commercerevision.indexposts','uses' => 'PostController@admin'));
		Route::delete('post/{id}',array('as' => 'commerce.destroy','uses' => 'PostController@destroy'));
		Route::get('revisions',array('as' => 'commercerevision.index','uses' => 'RevisionController@index'));
		Route::get('revision/{id}',array('as' => 'commercerevision.show','uses' => 'RevisionController@show'));
		Route::post('revision/{id}',array('as' => 'commerce.ajax.single', 'uses' => 'RevisionController@singleAjax'));
		Route::post('revision/{id}/update',array('as' => 'commercerevision.update','uses' => 'RevisionController@update'));
		Route::delete('revision/{id}/delete',array('as' => 'commercerevision.destroy','uses' => 'RevisionController@destroy'));
	});
	
	Route::group(['middleware' => ['perim']], function()
	{
		Route::get('{id}',array('as' => 'commerce.show','uses' => 'PostController@show'));
		Route::post('{id}',array('as' => 'commerce.ajax.single', 'uses' => 'PostController@singleAjax'));
		Route::get ('{id}/pdf', 'PdfController@pdf');
		
		Route::group(['middleware' => ['contributor']], function()
		{
			Route::get('{id}/edit',array('as' => 'webmap.edit','uses' => 'PostController@edit'));
			Route::put('{id}/edit',array('as' => 'commerce.update','uses' => 'RevisionController@storeRevision'));
			Route::post('{id}/editgeom',array('as' => 'commerce.editgeom','uses' => 'PostController@editgeomAjax'));
			Route::post('{id}/updategeom',array('as' => 'commerce.updategeom','uses' => 'RevisionController@geomAjax'));
		});
	}); 
});