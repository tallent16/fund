<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*//*
Route::get('/', function()
{
	return redirect('borrower');
});*/

Route::get('/', function()
{
	return View::make('homepage');  
});
Route::get('lang/{lang}', 'TranslationController@languagetranslation'); 
Route::get('home', 'HomeController@checkUserType');
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
	
	Route::get('login',  'CustomAuthController@getLogin');
	Route::post('login', 'CustomAuthController@postLogin');
	Route::get('logout', 'CustomAuthController@getLogout');
});
Route::group(['prefix' => 'admin', 'middleware' => 'auth.admin'], function() {
    // your routes
});

Route::get('borrower', 'HomeController@index');
Route::get('customRedirectPath', 'HomeController@customRedirectPath');
Route::get('borrower/profile', 'BorrowerProfileController@index');
//Route::get('borrower/directorsinfo', 'BorrowerDirectorController@index');
Route::get('borrower/applyloan', 'BorrowerApplyLoanController@index');

Route::get('user', 'UserController@index');
Route::get('ajax/user_master', 'UserController@view_user');
Route::post('ajax/user_master', 'UserController@view_user');

Route::get('/register', function()
{
	return View::make('register');
});

Route::get('/charts', function()
{
	return View::make('mcharts');
});

Route::get('/tables', function()
{
	return View::make('table');
});

Route::get('/forms', function()
{
	return View::make('form');
});

Route::get('/grid', function()
{
	return View::make('grid');
});

Route::get('/buttons', function()
{
	return View::make('buttons');
});


Route::get('/icons', function()
{
	return View::make('icons');
});

Route::get('/panels', function()
{
	return View::make('panel');
});

Route::get('/typography', function()
{
	return View::make('typography');
});

Route::get('/notifications', function()
{
	return View::make('notifications');
});

Route::get('/blank', function()
{
	return View::make('blank');
});



Route::get('/documentation', function()
{
	return View::make('documentation');
});
