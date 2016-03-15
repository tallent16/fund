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

// global contants for all requests
Route::group(['prefix' => ''], function() {
    define('BORROWER_STATUS_NEW_PROFILE','1');
    define('BORROWER_STATUS_NEW','1');
    define('BORROWER_STATUS_SUBMITTED_FOR_APPROVAL','2');
    define('BORROWER_STATUS_COMMENTS_ON_ADMIN','3');
    define('BORROWER_STATUS_VERIFIED','4');
    define('BORROWER_BANK_STATUS_VERIFIED','2');
    define('BORROWER_BANK_STATUS_UNVERIFIED','1');
    define('REPAYMENT_TYPE_ONE_TIME', '1');
    define('REPAYMENT_TYPE_INTEREST_ONLY', '2');
    define('REPAYMENT_TYPE_EMI', '3');
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
    Route::get('borrower/dashboard', 'BorrowerDashboardController@indexAction');
	Route::match(['get', 'post'],'borrower/profile', 'BorrowerProfileController@indexAction');
	
	Route::match(['get', 'post'],'borrower/applyloan','BorrowerApplyLoanController@indexAction');
	Route::match(['get', 'post'],'borrower/applyloan/{loan_id}','BorrowerApplyLoanController@indexAction');
	Route::get('borrower/docdownload/{doc_id}','BorrowerApplyLoanController@downloadAction');
	
	Route::get('borrower/myloans/{loan_id}', 'LoanDetailsController@indexAction');	
	Route::post('ajax/borrower/send_comment', 'LoanDetailsController@ajaxSubmitReplyAction');	
	Route::get('ajax/borrower/send_comment', 'LoanDetailsController@ajaxSubmitReplyAction');	
	
	Route::get('borrower/loanslist', 'LoanListingController@indexAction');	 
	/*Route::get('borrower/loanlist', function() {
			return View::make('Borrower-loanlisting'); }
			);*/
	Route::get('borrower/myloaninfo', 'BorrowerMyLoanInfoController@indexAction');	
	Route::post('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	
	Route::get('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	
	
	Route::get('borrower/transhistory', 'BorrowerTransHistoryController@indexAction'); 
	Route::get('borrower/bankdetails', 'BorrowerBankDetailsController@indexAction');
	Route::get('borrower/repayloans', 'BorrowerRepayLoansController@indexAction');
	Route::get('borrower/settings', 'BorrowerSettingsController@indexAction');
	Route::get('borrower/makepayment', 'BorrowerMakePaymentController@indexAction');
});

// The routes (or pages that are applicable for investor users only
Route::group(['middleware' => 'App\Http\Middleware\InvestorMiddleWare'], function()
{
  //Route::get('investor/dashboard',array('middleware' => 'auth', 'uses' => 'InvestorDashboardController@indexAction'));
    Route::get('investor/dashboard', 'InvestorDashboardController@indexAction');
    Route::get('investor/profile', 'InvestorProfileController@indexAction');
	Route::get('investor/loanslist', 'LoanListingController@indexAction');

    Route::get('investor/loandetails', 'InvestorLoanDetailsController@indexAction');
    Route::get('investor/myloaninfo', 'InvestorMyLoanInfoController@indexAction');
    Route::get('investor/myloans/{loan_id}', 'LoanDetailsController@indexAction');  
    Route::get('investor/transhistory', 'InvestorTransHistoryController@indexAction'); 
    Route::get('investor/bankdetails', 'InvestorBankDetailsController@indexAction'); 
    Route::get('investor/withdraw', 'InvestorWithdrawController@indexAction');  
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
/*Route::get('/test_loanlisting', function()
{
	return View::make('test_loanlisting');
});
*/
