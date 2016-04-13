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
    define('BORROWER_STATUS_APPROVED','4');
    define('BORROWER_STATUS_COMMENTS_ON_ADMIN','3');
    define('BORROWER_STATUS_VERIFIED','4');
    define('BORROWER_BANK_STATUS_VERIFIED','2');
    define('BORROWER_BANK_STATUS_UNVERIFIED','1');
    define('REPAYMENT_TYPE_ONE_TIME', '1');
    define('REPAYMENT_TYPE_INTEREST_ONLY', '2');
    define('REPAYMENT_TYPE_EMI', '3');
    define('BORROWER_REPAYMENT_STATUS_UNPAID', '1');  
    define('BORROWER_REPAYMENT_STATUS_UNVERIFIED', '2');
    define('BORROWER_REPAYMENT_STATUS_PAID', '3');
    define('BANK_DETAILS_VERIFIED', '2');
    define('BANK_DETAILS_UNVERIFIED', '1');
    define('BANK_DETAILS_ACTIVE', '1');
    define('BANK_DETAILS_INACTIVE', '0');
    define('USER_TYPE_BORROWER', '1');
    define('USER_TYPE_INVESTOR', '2');
    define('USER_TYPE_ADMIN', '3');
    define('USER_STATUS_UNVERIFIED', '1');
    define('USER_STATUS_VERIFIED', '2');
    define('USER_EMAIL_UNVERIFIED', '0');
    define('USER_EMAIL_VERIFIED', '1');
    define('LOAN_STATUS_NEW', '1');
    define('LOAN_STATUS_SUBMITTED_FOR_APPROVAL', '2');
    define('LOAN_STATUS_APPROVED', '3');
    define('LOAN_STATUS_PENDING_COMMENTS', '4');
    define('LOAN_STATUS_CLOSED_FOR_BIDS', '5');
    define('LOAN_STATUS_BIDS_ACCEPTED', '6');
    define('LOAN_STATUS_DISBURSED', '7');
    define('LOAN_STATUS_CANCELLED', '8');
    define('LOAN_STATUS_UNSUCCESSFUL_LOAN', '9');
    define('LOAN_STATUS_LOAN_REPAID', '10');

    define('LOAN_BIDS_STATUS_OPEN', '1');
    define('LOAN_BIDS_STATUS_ACCEPTED', '2');
    define('LOAN_BIDS_STATUS_REJECTED', '3');
    define('LOAN_BIDS_STATUS_CANCELLED', '4');
    define('INVESTOR_BANK_TRANSCATION_STATUS', '1');  
    define('INVESTOR_BANK_TRANSCATION_DEPOSIT', '1');
    define('INVESTOR_BANK_TRANSCATION_WITHDRAWAL', '2');
    define('PAYMENT_STATUS_UNVERIFIED','1');
    define('PAYMENT_STATUS_VERIFIED','2');   
    define('PAYMENT_TRANSCATION_LOAN_DISBURSEMENT','1');
    define('PAYMENT_TRANSCATION_LOAN_REPAYMENT','2');
    define('PAYMENT_TRANSCATION_INVESTOR_DEPOSIT','3');
    define('PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL','4');
    define('BORROWER_COMMENT_OPEN','1');
    define('BORROWER_COMMENT_CLOSED','2');
    
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
   // Route::get('admin',array('middleware' => 'auth', 'uses' => 'AdminController@index'));
    Route::get('admin/login',array('middleware' => 'auth', 'uses' => 'AdminController@index'));
    
    Route::get('admin/manageborrowers', 'AdminManageBorrowersController@indexAction');
    Route::get('admin/loanlisting', 'AdminLoanListingController@indexAction');
    Route::get('admin/managebids/{loan_id}', 'AdminManageBidsController@indexAction');
    Route::get('admin/loanapproval', 'AdminLoanApprovalController@indexAction'); 
    Route::get('admin/disburseloan', 'AdminDisburseLoanController@indexAction');
    Route::get('admin/borrower/profile/{bor_id}', 'AdminManageBorrowersController@viewProfileAction');
});

// The routes (or pages that are applicable for Borrower Users only
Route::group(['middleware' => 'App\Http\Middleware\BorrowerMiddleWare'], function() {
    Route::get('borrower/dashboard', 'BorrowerDashboardController@indexAction');
	Route::match(['get', 'post'],'borrower/profile', 'BorrowerProfileController@indexAction');
	
	Route::match(['get', 'post'],'borrower/applyloan','BorrowerApplyLoanController@indexAction');
	Route::match(['get', 'post'],'borrower/applyloan/{loan_id}','BorrowerApplyLoanController@indexAction');
	Route::get('borrower/docdownload/{doc_id}','BorrowerApplyLoanController@downloadAction');
	
	Route::get('borrower/myloans/{loan_id}', 'LoanDetailsController@indexAction');	
	Route::post('ajax/borrower/send_reply', 'LoanDetailsController@ajaxSubmitReplyAction');	
	
	Route::get('borrower/loanslist', 'LoanListingController@indexAction');	 
	
	Route::get('borrower/myloaninfo', 'BorrowerMyLoanInfoController@indexAction');	
	Route::get('borrower/cancelloan/{loan_id}', 'BorrowerMyLoanInfoController@cancelAction');	
	Route::post('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	
	Route::get('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	
	
	Route::get('borrower/loansummary', 'BorrowerLoanSummaryController@indexAction'); 
	Route::get('borrower/transhistory', 'BorrowerTransHistoryController@indexAction'); 
	Route::post('borrower/ajax/trans_detail', 'BorrowerTransHistoryController@ajaxTransationAction');	
	Route::match(['get', 'post'],'borrower/bankdetails', 'BankProcessController@indexAction');
	Route::get('borrower/repayloans', 'BorrowerRepayLoansController@indexAction');
	Route::get('borrower/settings', 'BorrowerSettingsController@indexAction');	
	Route::match(['get', 'post'],'borrower/makepayment/{repayment_id}/{loan_id}', 'BorrowerRepayLoansController@paymentAction');
});

// The routes (or pages that are applicable for investor users only
Route::group(['middleware' => 'App\Http\Middleware\InvestorMiddleWare'], function()
{
    Route::get('investor/dashboard', 'InvestorDashboardController@indexAction');
    Route::match(['get', 'post'],'investor/profile', 'InvestorProfileController@indexAction');
    Route::post('investor/checkFieldExists', 'InvestorProfileController@ajaxCheckFieldExistsAction');
	Route::get('investor/loanslist', 'LoanListingController@indexAction');
  
    Route::get('investor/myloaninfo', 'InvestorMyLoanInfoController@indexAction');
    Route::match(['get', 'post'],'investor/myloans/{loan_id}', 'LoanDetailsController@indexAction');  
    Route::get('investor/transhistory', 'InvestorTransHistoryController@indexAction'); 
    Route::match(['get', 'post'],'investor/bankdetails', 'BankProcessController@indexAction');   
    Route::match(['get', 'post'],'investor/deposit', 'InvestorBankController@indexAction'); 
    Route::match(['get', 'post'],'investor/withdraw', 'InvestorBankController@withdrawAction');  
    Route::post('ajax/investor/send_comment', 'LoanDetailsController@ajaxSubmitCommentAction');	
    Route::post('ajax/investor/send_reply', 'LoanDetailsController@ajaxSubmitReplyAction');	   	
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
