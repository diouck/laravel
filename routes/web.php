<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {return view('home');});
Route::post('login', array('as' => 'postlogin','uses' => 'Auth\LoginController@login'));
Route::get('login', array('as' => 'login','uses' => 'Auth\LoginController@showLoginForm'));
Route::get('logout', array('as' => 'logout','uses' => 'Auth\LoginController@logout'));

// Password reset link request routes...
 Route::get('password/reset', array('as' => 'email','uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'));
 Route::post('password/email', array('as' => 'postemail','uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'));
 // Password reset routes...
 Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
 Route::post('password/reset', 'Auth\ResetPasswordController@reset');

