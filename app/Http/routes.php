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
*/

Route::get('/', function()
{
	return View::make('homepage');  
});


Route::get('lang/{lang}', 'TranslationController@languagetranslation'); 

// The routes (or pages that are applicable for all types of users
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
	Route::get('login',  'CustomAuthController@getLogin');
	Route::post('login', 'CustomAuthController@postLogin');
	Route::get('logout', 'CustomAuthController@getLogout');
});


// The routes (or pages that are applicable for admin users only
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleWare'], function() {
    Route::get('admin',array('middleware' => 'auth', 'uses' => 'AdminController@index'));
    Route::get('admin/login',array('middleware' => 'auth', 'uses' => 'AdminController@index'));
});

// The routes (or pages that are applicable for Borrower Users only
Route::group(['middleware' => 'App\Http\Middleware\BorrowerMiddleWare'], function() {
    Route::get('borrower', 'BorrowerDashboardController@indexAction');
	Route::match(['get', 'post'],'borrower/profile', 'BorrowerProfileController@indexAction');
	Route::get('borrower/applyloan', 'BorrowerApplyLoanController@index');
	Route::get('borrower/myloans', 'BorrowerMyLoansController@index');	
	Route::get('borrower/loanslist', 'BorrowerLoanListingController@index');	
	Route::get('borrower/myloaninfo', 'BorrowerMyLoanInfoController@index');	
	Route::get('borrower/transhistory', 'BorrowerTransHistoryController@index'); 
	Route::get('borrower/bankdetails', 'BorrowerBankDetailsController@index');
	Route::get('borrower/repayloans', 'BorrowerRepayLoansController@index');
	Route::get('borrower/settings', 'BorrowerSettingsController@index');
});

// The routes (or pages that are applicable for investor users only
Route::group(['middleware' => 'App\Http\Middleware\InvestorMiddleWare'], function()
{
    Route::get('investor',array('middleware' => 'auth', 'uses' => 'InvestorController@index'));
   
});

Route::get('customRedirectPath', 'HomeController@customRedirectPath');

Route::get('user', 'UserController@index');
Route::get('ajax/user_master', 'UserController@view_user');
Route::post('ajax/user_master', 'UserController@view_user');

Route::post('ajax/CheckEmailavailability', 'RegistrationController@checkEmailavailability');
Route::post('submit_registration', 'RegistrationController@submitAction');
Route::get('register', 'RegistrationController@indexAction');
Route::get('activation/{activation}', 'RegistrationController@activationAction'); 

Route::get('verification', function() {
	echo "<h3>Registration successful, please activate email.</h3>";
});
