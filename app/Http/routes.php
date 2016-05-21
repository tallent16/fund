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
	
	//~ $user_id	=	Auth::user()->user_id;
	//~ $user		=	App\models\User::find($user_id);
	//~ $role		=	Bican\Roles\Models\Role::find(6);
	//~ $user->attachRole($role);
	
	return View::make('homepage');  
});

// global contants for all requests
Route::group(['prefix' => ''], function() {
	/* Code Master Codes */
	define('USER_STATUS', '1');
	define('BORROWER_STATUS', '2');
	define('INVESTOR_STATUS', '3');
	define('BUSINESS_ORGANISATION', '5'); // THIS IS NOT USED.. 4 IS MISSING
	define('LOAN_BID_TYPE', '6');
	define('LOAN_STATUS', '7');
	define('LOAN_REPAYMENT_TYPE', '8');
	define('LOAN_DOC_STATUS', '9');
	define('PAYMENT_TRANS_TYPE', '10');
	define('PAYMENT_STATUS', '11');
	define('USER_TYPE', '12');
	define('FINANCIAL_RATIOS', '13');
	define('FINANCIAL_NUMBERS', '14');
	define('INDUSTRIES', '15');
	define('LOAN_PURPOSES', '16');
	define('INTEREST_RATE_FILTER', '17');
	define('LOAN_AMOUNT_FILTER', '18');
	define('LOAN_TENURE_FILTER', '19');
	define('BORROWER_GRADES', '20');
	define('BID_STATUS', '21');
	define('INVESTMENT_STATUS', '22');
	define('BANK_VERIFIED_STATUS', '23');
	define('ACTIVE_STATUS', '24');
	define('REPAYMENT_STATUS', '25');
	define('PROFILE_COMMENT_STATUS', '26');
	define('LOAN_FEES_APPLICABLE', '27');
	define('PENALTY_FEES_APPLICABLE', '28');
	define('INVESTOR_REPAYMENT_STATUS', '29');
	define('INVESTOR_BANK_TRANS_TYPE', '30');
	define('INVESTOR_BANK_TRANS_STATUS', '31');


	
	/* Code Master Details */
    define('USER_STATUS_UNVERIFIED', '1');
    define('USER_STATUS_VERIFIED', '2');


    define('BORROWER_STATUS_NEW_PROFILE','1');
    define('BORROWER_STATUS_NEW','1');
    define('BORROWER_STATUS_SUBMITTED_FOR_APPROVAL','2');
    define('BORROWER_STATUS_APPROVED','4');
    define('BORROWER_STATUS_COMMENTS_ON_ADMIN','3');
    define('BORROWER_STATUS_VERIFIED','4');
    define('BORROWER_STATUS_DELETED','5');
    define('BORROWER_STATUS_REJECTED','6');
    
    define('INVESTOR_STATUS_NEW_PROFILE','1');
    define('INVESTOR_STATUS_NEW','1');
    define('INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL','2');
    define('INVESTOR_STATUS_APPROVED','4');
    define('INVESTOR_STATUS_COMMENTS_ON_ADMIN','3');
    define('INVESTOR_STATUS_VERIFIED','4');
    define('INVESTOR_STATUS_DELETED','5');
    define('INVESTOR_STATUS_REJECTED','6');

    define('LOAN_BID_TYPE_OPEN_AUCTION','1');
    define('LOAN_BID_TYPE_CLOSED_AUCTION','2');
    define('LOAN_BID_TYPE_FIXED_INTEREST','3');

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



    /* To do 
     * delete the two status and use BANK_VERIFIED_STATUS instead
     */
    define('BORROWER_BANK_STATUS_VERIFIED','2');
    define('BORROWER_BANK_STATUS_UNVERIFIED','1');
	// End of Todo


    define('BANK_VERIFIED_STATUS_VERIFIED','2');
    define('BANK_VERIFIED_STATUS_UNVERIFIED','1');


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
    define('USER_EMAIL_UNVERIFIED', '0');
    define('USER_EMAIL_VERIFIED', '1');

    define('LOAN_BIDS_STATUS_OPEN', '1');
    define('LOAN_BIDS_STATUS_ACCEPTED', '2');
    define('LOAN_BIDS_STATUS_REJECTED', '3');
    define('LOAN_BIDS_STATUS_CANCELLED', '4');
    define('INVESTOR_BANK_TRANSCATION_STATUS', '1');  
    define('INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT', '1');
    define('INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL', '2');
    
    define('PAYMENT_STATUS_UNVERIFIED','1');
    define('PAYMENT_STATUS_VERIFIED','2');   
    define('PAYMENT_TRANSCATION_LOAN_DISBURSEMENT','1');
    define('PAYMENT_TRANSCATION_LOAN_REPAYMENT','2');
    define('PAYMENT_TRANSCATION_INVESTOR_DEPOSIT','3');
    define('PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL','4');
    define('BORROWER_COMMENT_OPEN','1');
    define('BORROWER_COMMENT_CLOSED','2');
    
    define('PROFILE_COMMENT_OPEN','1');
    define('PROFILE_COMMENT_CLOSED','2');
    
    define('PROCESS_FEES_APPLICABLE_PERCENT_ONLY', '2');
    define('PROCESS_FEES_APPLICABLE_FIXEDFEES_ONLY', '2');
    define('PROCESS_FEES_APPLICABLE_BOTH', '3');

	define('INVESTOR_REPAYMENT_STATUS_UNPAID', '1');
	define('INVESTOR_REPAYMENT_STATUS_PAID', '2');
	define('INVESTOR_REPAYMENT_STATUS_VERIFIED', '3');
	
	define('INVESTOR_BANK_TRANS_STATUS_UNVERIFIED', '1');
	define('INVESTOR_BANK_TRANS_STATUS_VERIFIED', '2');
	
    
});
Route::get('lang/{lang}', 'TranslationController@languagetranslation'); 

// Login/Forgot/Change Password
	//Route::get('reset',  'ManagePasswordController@resetPasswordAction');
	Route::match(['get', 'post'],'reset',  'ManagePasswordController@resetPasswordAction');
	Route::post('forgot',  'ManagePasswordController@forgotPasswordAction');
	Route::post('submitpassword',  'ManagePasswordController@submitPasswordAction');

// The routes (or pages that are applicable for all types of users
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
	Route::get('login',  'CustomAuthController@getLogin');
	Route::post('login', 'CustomAuthController@postLogin');
	Route::get('logout', 'CustomAuthController@getLogout');
});

// The routes (or pages that are applicable for admin users only
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleWare'], function() {

	 Route::get('admin/login',array('middleware' => 'auth', 'uses' => 'AdminController@index'));
	
 //****************************Manage Profiles for Borrowers Starts*********************************************
 
	Route::get('admin/manageborrowers', [	'as' 			=> 	'admin.manageborrowers', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.manageborrowers',
											'uses' 			=>	'AdminManageBorrowersController@indexAction'
										]
				);
	
    Route::get('admin/borrower/updateprofile/{status}/{bor_id}',
										[	'as' 			=> 	'admin.borrower.updateprofile', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit.admin.manageborrowers',
											'redirect_back'	=>	'admin/manageborrowers',
											'action_type'	=>	'update borrower profile status',
											'uses' 			=>	'AdminManageBorrowersController@updateProfileStatusAction'
										]
				);   
    Route::post('admin/borrower/updateprofile',
										[	'as' 			=> 	'admin.borrower.bulkupdateprofile', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit.admin.manageborrowers',
											'redirect_back'	=>	'admin/manageborrowers',
											'action_type'	=>	'update borrower profile status in bulk',
											'uses' 			=>	'AdminManageBorrowersController@updateBulkProfileStatusAction'
										]
				);
										
    Route::get('admin/borrower/profile/{bor_id}',
										[	'as' 			=> 	'admin.borrower.updateprofileview', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.borrowerprofile',
											'redirect_back'	=>	'admin/manageborrowers',
											'action_type'	=>	'view borrower profile status',
											'uses' 			=>	'AdminManageBorrowersController@viewProfileAction'
										]
			);
		
    Route::post('admin/borrower/profile/{bor_id}',
										[	'as' 			=> 	'admin.borrower.updateprofileedit', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.borrowerprofile',
											'redirect_back'	=>	'admin/manageborrowers',
											'action_type'	=>	'update borrower profile status',
											'uses' 			=>	'AdminManageBorrowersController@saveProfileAction'
										]
			);
		
    //****************************Manage Profiles for Borrowers Ends*********************************************
	
	//****************************Manage Profiles for Investors starts*******************************************
	
    Route::get('admin/manageinvestors', [	'as' 			=> 	'admin.manageinvestors', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.manageinvestors',
											'uses' 			=>	'AdminManageInvestorsController@indexAction'
										]
			);
	Route::get('admin/investor/updateprofile/{status}/{inv_id}', 
										[	'as' 			=> 	'admin.investor.updateprofile', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'update Investor profile status',
											'uses' 			=>	'AdminManageInvestorsController@updateProfileStatusAction'
										]
			);   

    Route::post('admin/investor/updateprofile', 
										[	'as' 			=> 	'admin.investor.updateprofile', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'update Investor profile status in bulk',
											'uses' 			=>	'AdminManageInvestorsController@updateBulkProfileStatusAction'
										]
			); 
	 Route::get('admin/investor/profile/{inv_id}',
										[	'as' 			=> 	'admin.investor.updateprofileview', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.investorprofile',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'view investor profile status',
											'uses' 			=>	'AdminManageInvestorsController@viewProfileAction'
										]
			);
		
    Route::post('admin/investor/profile/{inv_id}',
										[	'as' 			=> 	'admin.investor.updateprofileedit', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view.admin.investorprofile',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'update investor profile status',
											'uses' 			=>	'AdminManageInvestorsController@saveProfileAction'
										]
			);
		
    //ajax call
    Route::post('admin/investor/ajax/availableBalance', 'AdminManageInvestorsController@ajaxAvailableBalanceByIDAction');	
    
	//****************************Manage Profiles for Investors ends*****************************************************
	
	//****************************Manage Loans, Approvals Starts ***************************************************************
	
    Route::get('admin/loanlisting', [	'as' 			=> 	'admin.loanlisting', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.manageloans',
										'uses' 			=>	'AdminLoanListingController@indexAction'
									]
			);
	Route::get('admin/managebids/{loan_id}', 
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.manageloanbids',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'manage loan bids',
										'uses' 			=>	'AdminManageBidsController@getLoanDetailsAction'
									]
			);
	Route::post('admin/bidclose', 	[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'closebid.admin.manageloanbids',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'bid close',
										'uses' 			=>	'AdminManageBidsController@bidCloseAction'
									]
			);
    Route::post('admin/bidaccept', [	
										'middleware' 	=> 	'permission',
										'permission'	=>	'closebid.admin.manageloanbids',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'bid close',
										'uses' 			=>	'AdminManageBidsController@acceptBidsAction'
									]
			);
    Route::post('admin/loancancel', [	
										'middleware' 	=> 	'permission',
										'permission'	=>	'closebid.admin.manageloanbids',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'bid close',
										'uses' 			=>	'AdminManageBidsController@loanCancelAction'
									]
			);
    
	 Route::get('admin/loanapproval/{loan_id}',
									[	
										'as' 			=> 	'admin.loanapprovalview', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'view loan approval',
										'uses' 			=>	'AdminLoanApprovalController@indexAction'
									]
			);
		
    Route::post('admin/loanapproval/{loan_id}',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'update loan approval status',
										'uses' 			=>	'AdminLoanApprovalController@saveLoanApprovalAction'
									]
			);
	
    Route::get('admin/disburseloan/{loan_id}',
									[	
										'as' 			=> 	'admin.disburseloanview', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.disburseloan',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'view disburse loan',
										'uses' 			=>	'AdminDisburseLoanController@showDisburseLoanAction'
									]
			);
    Route::post('admin/savedisbursement', 
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit.admin.disburseloan',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'update disburse loan',
										'uses' 			=>	'AdminDisburseLoanController@saveDisburseLoanAction'
									]
			);
	
	//loan documents download action
	Route::get('admin/loandocdownload/{doc_id}', 'AdminLoanApprovalController@downloadLoanDocumentAction'); 
    
	//ajax call actions
	Route::post('ajax/getloanrepayschd', 'AdminDisburseLoanController@ajaxGetLoanRepaySchedAction');	
	Route::get('ajax/getloanrepayschd', 'AdminDisburseLoanController@ajaxGetLoanRepaySchedAction');	
	Route::post('admin/ajaxBidCloseDate/checkvalaidation', 'AdminLoanApprovalController@checkBiCloseDateValidationction'); 
	
	//****************************Manage Loans, Approvals Ends ***************************************************************
	
	//**************************** Manage Banking Transactions for Borrowers Starts*******************************************
    
    Route::get('admin/borrowersrepaylist',
									[	
										'as' 			=> 	'admin.borrowersrepaylist', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.repaymentlist',
										'uses' 			=>	'AdminBorrowersRepaymentListingController@indexAction'
									]
			);

    Route::match(['get', 'post'],'admin/borrowersrepayview/{type}/{installment_id}/{loan_id}', 'AdminBorrowersRepaymentViewController@indexAction');
    
     Route::get('admin/borrowersrepayview/{type}/{installment_id}/{loan_id}', 
									[	
										'as'			=>	'admin.borrowersrepayview',
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.repaymentlist',
										'redirect_back'	=>	'admin.borrowersrepaylist',
										'action_type'	=>	'View Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@indexAction'
									]
			);
		
    Route::post('admin/borrowersrepay/saveadmin',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'save.admin.repaymentlist',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'save Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@saveAction'
									]
			);
    Route::post('admin/borrowersrepay/save',
									[	'uses' 			=>	'AdminBorrowersRepaymentViewController@saveAction'
									]
			);
    Route::post('admin/borrowersrepay/approve',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.repaymentlist',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'Approve Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@approveAction'
									]
			);
    Route::post('admin/borrowersrepay/unapprove',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.repaymentlist',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'UnApprove Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@unapproveAction'
									]
			);
			
	Route::get('admin/approve/borrower/repayment/{repay_schde_id}', 
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.repaymentlist',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'Approve Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentListingController@approveRepaymentAction'
									]
			);
	
	Route::post('admin/bulkapprove/borrowers/repayment', 
								[	
									'middleware' 	=> 	'permission',
									'permission'	=>	'approve.admin.repaymentlist',
									'redirect_back'	=>	'admin.borrowersrepayview',
									'action_type'	=>	'Approve Repayment for bulk action',
									'uses' 			=>	'AdminBorrowersRepaymentListingController@bulkApproveRepaymentAction'
								]
	
			);
	
	//ajax call action
    Route::post('admin/ajax/recalculatePenality','AdminBorrowersRepaymentViewController@recalculatePenalityAction');
    
    //**************************** Manage Banking Transactions for Borrowers Ends********************************************
    
    // Manage Banking Transactions for Investors
    Route::get('admin/investordepositlist',
								[	
										'as' 			=> 	'admin.investordepositlist', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.investorsdeposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@indexAction'
								]
			);
    
    Route::post('admin/investordepositlist/bulkaction/approve', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'approve investor deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkApproveDepositAction'
								]
				);
    Route::post('admin/investordepositlist/bulkaction/unapprove', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'unapprove.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'unpprove investor deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkUnApproveDepositAction'
								]
				);
    Route::post('admin/investordepositlist/bulkaction/delete', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'delete.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'delete investor deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkDeleteDeposit'
								]
				);
  
   Route::match(['get', 'post'],'admin/investordepositview/{type}/{payment_id}/{investor_id}', 'AdminInvestorsDepositListingController@viewDepositAction');
   
   
    Route::get('admin/investorwithdrawallist',
				[ 	'middleware' => 'permission',
					'permission'=>'view.admin.investorswithdrawals',
					'uses'=>'AdminInvestorsWithdrawalsListingController@indexAction'
				]
			);
    Route::post('admin/investorwithdrawallist/bulkaction', 'AdminInvestorsWithdrawalsListingController@InvestorWithDrawListBulkAction');
    
    Route::match(['get', 'post'],'admin/investorwithdrawalview/{type}/{payment_id}/{investor_id}','AdminInvestorsWithdrawalsListingController@viewWithDrawAction');
    
    // Admin Users Creating, Editing,Roles assigning
    
		Route::get('admin/user','UserController@index');
		Route::get('admin/ajax/user_master', 'UserController@view_user');
		Route::post('admin/ajax/user_master', 'UserController@view_user');
		Route::get('admin/roles', 'AdminRolesController@indexAction');
		Route::get('admin/role-users/{role_id}', 'AdminRolesController@roleUsersAction');
		Route::match(['get', 'post'],
								'admin/role-permission/{trantype}/{role_id}', 
								['as' => 'admin.role-permission', 'uses' =>'AdminRolesController@rolePermissionsAction']);
		Route::post('admin/ajax/CheckRoleNameavailability', 'AdminRolesController@CheckRoleNameavailability');
	 // Admin Users Creating, Editing,Roles assigning
	 
	 Route::get('admin/assign-roles/{user_id}',
						[	'as'	=>	'admin.assign-roles',
							'uses'	=>	'AdminAssignRolesController@indexAction'
						]
				);
	 Route::post('admin/assign-roles','AdminAssignRolesController@saveUserRolesAction');
});

// The routes (or pages that are applicable for Borrower Users only
Route::group(['middleware' => 'App\Http\Middleware\BorrowerMiddleWare'], function() {
	// Borrower Dashboard
    Route::get('borrower/dashboard', 'BorrowerDashboardController@indexAction');
    
    // Borrower Profile
	Route::match(['get', 'post'],'borrower/profile', 'BorrowerProfileController@indexAction');
	
	// Borrower Apply Loan
	Route::match(['get', 'post'],'borrower/applyloan','BorrowerApplyLoanController@indexAction');
	Route::match(['get', 'post'],'borrower/applyloan/{loan_id}','BorrowerApplyLoanController@indexAction');
	Route::post('borrower/ajaxApplyLoan/checkvalaidation','BorrowerApplyLoanController@checkApplyLoanValidationction');
	Route::get('borrower/docdownload/{doc_id}','BorrowerApplyLoanController@downloadAction');
	
	// Borrower Loan Details
	Route::get('borrower/myloans/{loan_id}', 'LoanDetailsController@indexAction');	
	
	Route::get('borrower/managebids/{loan_id}', 'AdminManageBidsController@getLoanDetailsAction');
    Route::post('borrower/bidclose', 'AdminManageBidsController@bidCloseAction');
    Route::post('borrower/bidaccept', 'AdminManageBidsController@acceptBidsAction');
    
	Route::post('ajax/borrower/send_reply', 'LoanDetailsController@ajaxSubmitReplyAction');	
	Route::get('borrower/myloaninfo', 'BorrowerMyLoanInfoController@indexAction');	
	Route::get('borrower/cancelloan/{loan_id}', 'BorrowerMyLoanInfoController@cancelAction');	
	Route::post('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	
	Route::get('ajax/borower_repayment_schedule', 'BorrowerMyLoanInfoController@ajaxRepayScheduleAction');	

	// Borrower Banking
	Route::match(['get', 'post'],'borrower/bankdetails', 'BankProcessController@indexAction');
		
	// Borrower Loan Listing
	Route::get('borrower/loanslist', 'LoanListingController@indexAction');	 
	Route::get('borrower/loansummary', 'BorrowerLoanSummaryController@indexAction'); 
	Route::get('borrower/transhistory', 'BorrowerTransHistoryController@indexAction'); 
	Route::post('borrower/ajax/trans_detail', 'BorrowerTransHistoryController@ajaxTransationAction');	
	Route::get('borrower/repayloans', 'BorrowerRepayLoansController@indexAction');
	Route::get('borrower/settings', 'BorrowerSettingsController@indexAction');	
	Route::match(['get', 'post'],'borrower/makepayment/{repayment_id}/{loan_id}', 'BorrowerRepayLoansController@paymentAction');
	Route::post('borrower/ajax/recalculatePenality','BorrowerRepayLoansController@recalculatePenalityAction');
});

// The routes (or pages that are applicable for investor users only
Route::group(['middleware' => 'App\Http\Middleware\InvestorMiddleWare'], function()
{
	// Investor Dashboard
    Route::get('investor/dashboard', 'InvestorDashboardController@indexAction');
    
    // Investor Profile
    Route::match(['get', 'post'],'investor/profile', 'InvestorProfileController@indexAction');
    Route::post('investor/checkFieldExists', 'InvestorProfileController@ajaxCheckFieldExistsAction');
	Route::get('investor/loanslist', 'LoanListingController@indexAction');
  
	// Loans 
    Route::get('investor/myloaninfo', 'InvestorMyLoanInfoController@indexAction');
    Route::match(['get', 'post'],'investor/myloans/{loan_id}', 'LoanDetailsController@indexAction');  
    
    // Transaction History
    Route::get('investor/transhistory', 'InvestorTransHistoryController@indexAction'); 
    
    // Banking
    Route::get('investor/depositlist', 'InvestorsDepositListingController@indexAction');
    Route::match(['get', 'post'],'investor/deposit/{type}/{payment_id}', 'InvestorsDepositListingController@viewDepositAction');
    
    Route::get('investor/withdrawallist', 'InvestorsWithdrawalsListingController@indexAction');
    Route::match(['get', 'post'],'investor/withdrawal/{type}/{payment_id}', 
															'InvestorsWithdrawalsListingController@viewWithDrawAction');
    Route::match(['get', 'post'],'investor/bankdetails', 'BankProcessController@indexAction');   
    
    Route::post('ajax/investor/send_comment', 'LoanDetailsController@ajaxSubmitCommentAction');	
    Route::post('ajax/investor/send_reply', 'LoanDetailsController@ajaxSubmitReplyAction');	   	
    Route::post('investor/ajax/availableBalance', 'LoanDetailsController@ajaxAvailableBalanceAction');	   	
});

// Common Modules
Route::get('customRedirectPath', 'HomeController@customRedirectPath');


Route::post('ajax/CheckEmailavailability', 'RegistrationController@checkEmailavailability');
Route::post('ajax/CheckUserNameavailability', 'RegistrationController@CheckUserNameavailability');
Route::post('submit_registration', 'RegistrationController@submitAction');
Route::get('register', 'RegistrationController@indexAction');
Route::get('activation/{activation}', 'RegistrationController@activationAction'); 

Route::get('verification', function() {
	echo "<h3>Registration successful, please activate email.</h3>";
});
