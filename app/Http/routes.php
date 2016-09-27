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

Route::get('/', [
		'uses' => 'HomeController@indexAction', 
		'as' => 'home'
	]);
Route::get('/home', function()
{
	return redirect("/");  
});


//~ Route::get('/', function()
//~ {
	//~ return View::make('homepage');  
//~ });

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
    define('BORROWER_REPAYMENT_STATUS_CANCELLED', '4');
    define('BORROWER_REPAYMENT_STATUS_OVERDUE', '5');

    define('BANK_DETAILS_VERIFIED', '2');
    define('BANK_DETAILS_UNVERIFIED', '1');
    
    define('NEWBANK_DETAIL_VERIFIED', '1');
    define('NEWBANK_DETAIL_UNVERIFIED', '0');
    
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
Route::get('reset',  [	'as' 			=> 	'reset', 
						'uses' 			=>	'ManagePasswordController@resetPasswordAction'
					]
		);
//submit action from  reset page
Route::get('forgotpassword',  	[	'as' 			=> 	'get.forgot', 
									'uses' 			=>	'ManagePasswordController@forgotPasswordAction'
								]
			);
Route::get('changepassword',  	[	'as' 			=> 	'get.change', 
									'uses' 			=>	'ManagePasswordController@forgotPasswordAction'
								]
			);
Route::post('forgotpassword',  'ManagePasswordController@forgotPasswordAction');
Route::post('changepassword',  'ManagePasswordController@forgotPasswordAction');

//confirmation action from forgot /change password page
Route::post('submit/forgotpassword',  'ManagePasswordController@submitForgotPasswordAction');
Route::post('submit/changepassword',  'ManagePasswordController@submitChangePasswordAction');

//Only registered Email can reset password
Route::post('ajax/checkEmailavailable', 'ManagePasswordController@checkEmailavailable');

// The routes (or pages that are applicable for all types of users
Route::group(['prefix' => 'auth', 'as' => 'auth.'], function(){
	Route::get('login',  'CustomAuthController@getLogin');
	Route::post('login', 'CustomAuthController@postLogin');
	Route::get('logout', 'CustomAuthController@getLogout');
});

//Settings Configuration
//Route::get('admin/settings',  'AdminSettingsController@indexAction');

//Route::get('admin/changeofbank',  'AdminChangeofBankController@indexAction');
//Route::get('admin/approvechangeofbank/{usertype}/{borid}/{borbankid}',  'AdminChangeofBankController@editApproveAction'); 


//audit trail
//~ Route::get('admin/audit_trial',  'AdminAuditTrailController@indexAction');
//~ Route::get('admin/audit_trial/{module_name}',  'AdminAuditTrailController@getTableListAction');

Route::get('admin/audit_trial',  	[	'as' 			=> 	'admin.audit_trial', 
										'middleware' 	=> 	'permission',										
										'uses' 			=>	'AdminAuditTrailController@indexAction'
									]
				);
Route::get('admin/audit_trial/module/{module_name}/{module_names}',  	
									[	
										
										'middleware' 	=> 	'permission',										
										'redirect_back'	=>	'admin.audit_trial',
										'uses' 			=>	'AdminAuditTrailController@getTableListAction'
												
									]
			);	
Route::get('admin/audit_trial/{tablename}/{auditkey}',  	
									[	
										
										'middleware' 	=> 	'permission',										
										'redirect_back'	=>	'admin.audit_trial',
										'uses' 			=>	'AdminAuditTrailController@getAuditDetailsAction'
												
									]
			);	
					
Route::post('admin/audit_trial/optionfilter',  'AdminAuditTrailController@getselectedmoduleAction');	
		
// The routes (or pages that are applicable for admin users only
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleWare'], function() {

	 Route::get('admin/dashboard',array('middleware' => 'auth', 
													'uses' => 'AdminDashboardController@indexAction'));
	 
	 Route::get('admin/bidAutoClose',array('middleware' => 'auth', 
													'uses' => 'AdminManageBidsController@bidAutoCloseAction'));
	 
//****************************Settings - General & Messages Starts********************************************

	Route::get('admin/settings',  	[	'as' 			=> 	'admin.settings', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view_general_message.admin.settings',
										'uses' 			=>	'AdminSettingsController@indexAction'
									]
				);
	
	Route::post('admin/system/settings/save',  	
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit_general_message.admin.settings',
										'redirect_back'	=>	'admin.settings',
										'uses' 			=>	'AdminSettingsController@saveSystemSettingsAction'
												
									]
			);
			
	
	Route::post('admin/system/messages/save',  									
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit_general_message.admin.settings',
										'redirect_back'	=>	'admin.settings',
										'uses' 			=>	'AdminSettingsController@saveSystemMessagesAction'
												
									]			
												
				);
	Route::post('admin/system/emaildata/save',  
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit_general_message.admin.settings',
										'redirect_back'	=>	'admin.settings',
										'uses' 			=>	'AdminSettingsController@saveSystemEmailAction'
												
									]			
				);
//****************************Settings - General & Messages Ends***********************************************

//****************************Settings - Challenge questions Starts*******************************************

Route::get('admin/challengequestions',  [	'as' 			=> 	'admin.challengequestions', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view_challenge_question.admin.settings',
											'uses' 			=>	'AdminChallengeQuestionsController@indexAction'
										]
			);
Route::post('admin/challengequestions', [	
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit_challenge_question.admin.settings',
											'redirect_back'	=>	'admin.challengequestions',
											'uses' 			=>	'AdminChallengeQuestionsController@saveAction'
										]
			);

//****************************Settings - Challenge questions Ends*******************************************

//****************************Settings - Organisation type  Starts*******************************************

Route::get('admin/businessorgtype',  [		'as' 			=> 	'admin.businessorgtype', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view_organisation_type.admin.settings',
											'uses' 			=>	'AdminBusinessOrgTypeController@indexAction'
										]
			);
Route::post('admin/businessorgtype', [	
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit_organisation_type.admin.settings',
											'redirect_back'	=>	'admin.businessorgtype',
											'uses' 			=>	'AdminBusinessOrgTypeController@saveAction'
										]
			);


//****************************Settings - Organisation type  Ends*******************************************

//****************************Settings - Industries  Starts*******************************************

Route::get('admin/industries',  [			'as' 			=> 	'admin.industries', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view_industries.admin.settings',
											'uses' 			=>	'AdminIndustriesController@indexAction'
										]
			);
Route::post('admin/industries', [	
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit_industries.admin.settings',
											'redirect_back'	=>	'admin.industries',
											'uses' 			=>	'AdminIndustriesController@saveAction'
										]
			);


//****************************Settings - Industries  Ends*******************************************

//****************************Settings - loandocrequired  Starts*******************************************

Route::get('admin/loandocrequired',  [		'as' 			=> 	'admin.loandocrequired', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'view_documents_required.admin.settings',
											'uses' 			=>	'AdminLoanDocumentsController@indexAction'
									]
			);
Route::post('admin/loandocrequired', [	
											'middleware' 	=> 	'permission',
											'permission'	=>	'edit_documents_required.admin.settings',
											'redirect_back'	=>	'admin.loandocrequired',
											'uses' 			=>	'AdminLoanDocumentsController@saveAction'
									]
			);


//****************************Settings - loandocrequired  Ends*******************************************

//****************************Settings - changeofbank  Starts*******************************************

Route::get('admin/changeofbank',  	[	'as' 			=> 	'admin.changeofbank', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view_changeofbank.admin.banking',
										'uses' 			=>	'AdminChangeofBankController@indexAction'
									]
			);
Route::get('admin/approvechangeofbank/{usertype}/{borid}/{borbankid}',
									[	
									'as' 			=> 	'admin.changeofbankedit', 
									'middleware' 	=> 	'permission',
									'permission'	=>	'edit_changeofbank.admin.banking',
									'redirect_back'	=>	'admin.changeofbank',
									'uses' 			=>	'AdminChangeofBankController@editApproveAction'
									]
			);

Route::post('admin/approvechangeofbank/approve', 
									[	 
											
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve_changeofbank.admin.banking',
										'redirect_back'	=>	'admin.changeofbankedit',
										'uses' 			=>	'AdminChangeofBankController@updateApproveBankAction'
									]
			);
Route::post('admin/approvechangeofbank/reject',  
									[	 
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'reject_changeofbank.admin.banking',
										'redirect_back'	=>	'admin.changeofbankedit',
										'uses' 	=>	'AdminChangeofBankController@rejectBankAction'
									]
			);


//****************************Settings - changeofbank  Ends*******************************************


 //****************************Manage Profiles for Borrowers Starts*********************************************
 
	Route::get('admin/manageborrowers', [	'as' 			=> 	'admin.manageborrowers', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'listview.admin.manageborrowers',
											'uses' 			=>	'AdminManageBorrowersController@indexAction'
										]
				);
	
    Route::get('admin/manageborrowers/approve/{bor_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'approve borrower',
											'uses' 			=>	'AdminManageBorrowersController@approveBorrowerAction'
										]
				);   
				
    Route::get('admin/manageborrowers/reject/{bor_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'reject.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'reject borrower',
											'uses' 			=>	'AdminManageBorrowersController@rejectBorrowerAction'
										]
				);   
				
    Route::get('admin/manageborrowers/delete/{bor_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'delete.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'delete borrower',
											'uses' 			=>	'AdminManageBorrowersController@deleteBorrowerAction'
										]
				);   
    Route::post('admin/manageborrowers/bulkapprove',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'approve borrowers in bulk',
											'uses' 			=>	'AdminManageBorrowersController@approveBorrowerBulkAction'
										]
				);
    Route::post('admin/manageborrowers/bulkreject',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'reject.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'reject borrowers in bulk',
											'uses' 			=>	'AdminManageBorrowersController@rejectBorrowerBulkAction'
										]
				);
    Route::post('admin/manageborrowers/bulkdelete',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'delete.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'delete borrowers in bulk',
											'uses' 			=>	'AdminManageBorrowersController@deleteBorrowerBulkAction'
										]
				);
										
    Route::get('admin/borrower/profile/{bor_id}',
										[	
											'as' 			=> 	'admin.borrowerprofile',
											'middleware' 	=> 	'permission',
											'permission'	=>	'detailview.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'view borrower profile',
											'uses' 			=>	'AdminManageBorrowersController@viewProfileAction'
										]
			);
		
    Route::post('admin/borrower/profile/save',
										[	
											
											'uses' 			=>	'AdminManageBorrowersController@saveBorrowerProfileAction'
										]
			);
    Route::post('admin/borrower/profile/save_comments',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'admin.savecomment',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'save comments borrower profile',
											'uses' 			=>	'AdminManageBorrowersController@saveCommentProfileAction'
										]
			);
    Route::post('admin/borrower/profile/return_borrower',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'returnborrower.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'return to borrower borrower profile',
											'uses' 			=>	'AdminManageBorrowersController@returnBorrowerProfileAction'
										]
			);
    Route::post('admin/borrower/profile/approve',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'approve borrower',
											'uses' 			=>	'AdminManageBorrowersController@approveBorrowerProfileAction'
										]
			);
    Route::post('admin/borrower/profile/update_grade',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'updategrade.admin.manageborrowers',
											'redirect_back'	=>	'admin.manageborrowers',
											'action_type'	=>	'update grade borrower profile',
											'uses' 			=>	'AdminManageBorrowersController@updateGradeProfileAction'
										]
			);
		
    //****************************Manage Profiles for Borrowers Ends*********************************************
	
	//****************************Manage Profiles for Investors starts*******************************************
	
    Route::get('admin/manageinvestors', [	'as' 			=> 	'admin.manageinvestors', 
											'middleware' 	=> 	'permission',
											'permission'	=>	'listview.admin.manageinvestors',
											'uses' 			=>	'AdminManageInvestorsController@indexAction'
										]
			);
	Route::get('admin/manageinvestors/approve/{inv_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'approve investor',
											'uses' 			=>	'AdminManageInvestorsController@approveInvestorAction'
										]
				);   
				
    Route::get('admin/manageinvestors/reject/{inv_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'reject.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'reject investor',
											'uses' 			=>	'AdminManageInvestorsController@rejectInvestorAction'
										]
				);   
				
    Route::get('admin/manageinvestors/delete/{inv_id}',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'delete.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'delete investor',
											'uses' 			=>	'AdminManageInvestorsController@deleteInvestorAction'
										]
				);   
    Route::post('admin/manageinvestors/bulkapprove',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'approve investors in bulk',
											'uses' 			=>	'AdminManageInvestorsController@approveInvestorBulkAction'
										]
				);
    Route::post('admin/manageinvestors/bulkreject',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'reject.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'reject investors in bulk',
											'uses' 			=>	'AdminManageInvestorsController@rejectInvestorBulkAction'
										]
				);
    Route::post('admin/manageinvestors/bulkdelete',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'delete.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'delete investors in bulk',
											'uses' 			=>	'AdminManageInvestorsController@deleteInvestorBulkAction'
										]
				);
										
    Route::get('admin/investor/profile/{inv_id}',
										[	
											'as' 			=> 	'admin.investorprofile',
											'middleware' 	=> 	'permission',
											'permission'	=>	'detailview.admin.manageinvestors',
											'redirect_back'	=>	'admin.manageinvestors',
											'action_type'	=>	'view investor profile',
											'uses' 			=>	'AdminManageInvestorsController@viewProfileAction'
										]
			);
		
    Route::post('admin/investor/profile/save',
										[	'uses' 			=>	'AdminManageInvestorsController@saveInvestorProfileAction'
										]
			);
    Route::post('admin/investor/profile/save_comments',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'admin.savecomment',
											'redirect_back'	=>	'admin.investorprofile',
											'action_type'	=>	'save comments investor profile',
											'uses' 			=>	'AdminManageInvestorsController@saveCommentProfileAction'
										]
			);
    Route::post('admin/investor/profile/return_investor',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'returninvestor.admin.manageinvestors',
											'redirect_back'	=>	'admin.investorprofile',
											'action_type'	=>	'return to investor investor profile',
											'uses' 			=>	'AdminManageInvestorsController@returnInvestorProfileAction'
										]
			);
    Route::post('admin/investor/profile/approve',
										[	
											'middleware' 	=> 	'permission',
											'permission'	=>	'approve.admin.manageinvestors',
											'redirect_back'	=>	'admin.investorprofile',
											'action_type'	=>	'approve investor',
											'uses' 			=>	'AdminManageInvestorsController@approveInvestorProfileAction'
										]
			);
	
    //ajax call
    Route::post('admin/investor/ajax/availableBalance', 'AdminManageInvestorsController@ajaxAvailableBalanceByIDAction');	
    
	//****************************Manage Profiles for Investors ends*****************************************************
	
	//****************************Manage Loans, Approvals Starts *********************************************************
	
    Route::get('admin/loanlisting', [	'as' 			=> 	'admin.loanlisting', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.manageloans',
										'uses' 			=>	'AdminLoanListingController@indexAction'
									]
			);
			
    Route::get('admin/loandisplayorder', [	'as' 			=> 	'admin.loandisplayorder', 
											'uses' 			=>	'AdminLoanDisplayController@indexAction'
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
										'as' 			=> 	'admin.loanapproval', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'view loan approval',
										'uses' 			=>	'AdminLoanApprovalController@indexAction'
									]
			);
		
    Route::post('admin/loanapproval/save',
									[	
										'uses' 			=>	'AdminLoanApprovalController@saveLoanApprovalAction'
									]
			);
		
    Route::post('admin/loanapproval/updateBidCloseDate',
									[	
										'uses' 			=>	'AdminLoanApprovalController@updateBidCloseDateAction'
									]
			);
    Route::post('admin/loanapproval/save_comments',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'admin.savecomment',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'save comments loan approval',
										'uses' 			=>	'AdminLoanApprovalController@saveCommentLoanApprovalAction'
									]
			);
    Route::post('admin/loanapproval/return_borrower',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'returnborrower.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'return borrower loan approval',
										'uses' 			=>	'AdminLoanApprovalController@returnBorrowerLoanApprovalAction'
									]
			);
    Route::post('admin/loanapproval/approve',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'approve loan approval',
										'uses' 			=>	'AdminLoanApprovalController@approveLoanApprovalAction'
									]
			);
    Route::post('admin/loanapproval/cancel',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'cancel.admin.loanapproval',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'cancel loan approval',
										'uses' 			=>	'AdminLoanApprovalController@canelLoanApprovalAction'
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
	
    Route::post('admin/saveResched',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'admin.reschedule.loans',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'view disburse loan',
										'uses' 			=>	'AdminDisburseLoanController@saveReschedAction'
									]
			);
	
	
    Route::post('admin/disburseloan/{loan_id}',
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
	
	 Route::get('admin/loanview/{loan_id}',
									[	
										'as' 			=> 	'admin.loanview', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'view.admin.disburseloan',
										'redirect_back'	=>	'admin.loanlisting',
										'action_type'	=>	'view loan detail',
										'uses' 			=>	'AdminDisburseLoanController@showViewLoanAction'
									]
			);
	//loan documents download action
	Route::get('admin/loandocdownload/{doc_id}', 'AdminLoanApprovalController@downloadLoanDocumentAction'); 
	Route::post('admin/downloadAllFiles', 'AdminLoanApprovalController@downloadAllFilesAction'); 
    
	//ajax call actions
	Route::post('ajax/getloanrepayschd', 'AdminDisburseLoanController@ajaxGetLoanRepaySchedAction');	
	Route::get('ajax/getloanrepayschd', 'AdminDisburseLoanController@ajaxGetLoanRepaySchedAction');	
	
	Route::post('admin/ajax/getinvestor_repayment', 'AdminDisburseLoanController@ajaxGetInvestorRepaySchedAction');	
	Route::post('admin/ajaxBidCloseDate/checkvalaidation', 'AdminLoanApprovalController@checkBiCloseDateValidationction'); 
	
	//****************************Manage Loans, Approvals Ends ***************************************************************
	
	//**************************** Manage Banking Transactions for Borrowers Starts*******************************************
    
    Route::get('admin/borrowersrepaylist',
									[	
										'as' 			=> 	'admin.borrowersrepaylist', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'listview.admin.borrowerrepayment',
										'uses' 			=>	'AdminBorrowersRepaymentListingController@indexAction'
									]
			);

    		
	Route::get('admin/borrowersrepaylist/approve/{repay_schde_id}', 
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.borrowerrepayment',
										'redirect_back'	=>	'admin.borrowersrepaylist',
										'action_type'	=>	'Approve Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentListingController@approveRepaymentAction'
									]
			);
	
	Route::post('admin/borrowersrepaylist/bulkapprove', 
								[	
									'middleware' 	=> 	'permission',
									'permission'	=>	'approve.admin.borrowerrepayment',
									'redirect_back'	=>	'admin.borrowersrepaylist',
									'action_type'	=>	'Approve Repayment for bulk action',
									'uses' 			=>	'AdminBorrowersRepaymentListingController@bulkApproveRepaymentAction'
								]
	
			);
			
     Route::get('admin/borrowersrepayview/{type}/{installment_id}/{loan_id}', 
									[	
										'as'			=>	'admin.borrowersrepayview',
										'middleware' 	=> 	'permission',
										'permission'	=>	'detailview.admin.borrowerrepayment',
										'redirect_back'	=>	'admin.borrowersrepaylist',
										'action_type'	=>	'View Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@indexAction'
									]
			);
	Route::post('admin/borrowersrepayview/save','AdminBorrowersRepaymentViewController@saveAction');
	
    Route::post('admin/borrowersrepayview/approve',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.borrowerrepayment',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'Approve Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@approveAction'
									]
			);
    Route::post('admin/borrowersrepayview/unapprove',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'unapprove.admin.borrowerrepayment',
										'redirect_back'	=>	'admin.borrowersrepayview',
										'action_type'	=>	'UnApprove Repayment',
										'uses' 			=>	'AdminBorrowersRepaymentViewController@unapproveAction'
									]
			);
	
	//ajax call action
    Route::post('admin/ajax/recalculatePenality','AdminBorrowersRepaymentViewController@recalculatePenalityAction');
    
    //**************************** Manage Banking Transactions for Borrowers Ends********************************************
    
    //**************************** Manage Banking Transactions for Investors  Starts*****************************************
  
	//-----------------------Investor Deposit Listing page actions Starts------------------------------------
    Route::get('admin/investordepositlist',
								[	
										'as' 			=> 	'admin.investordepositlist', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'listview.admin.investorsdeposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@indexAction'
								]
			);
    
    Route::post('admin/investordepositlist/bulkapprove', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'approve investor deposit bulk in action',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkApproveDepositAction'
								]
				);
    Route::post('admin/investordepositlist/bulkunapprove', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'unapprove.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'unpprove investor deposit bulk in action',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkUnApproveDepositAction'
								]
				);
    Route::post('admin/investordepositlist/bulkdelete', 
								[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'delete.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'delete investor deposit bulk in action',
										'uses' 			=>	'AdminInvestorsDepositListingController@bulkDeleteDeposit'
								]
				);
  //------------------------Investor Deposit Listing page actions Ends------------------------------------
  
  //------------------------Investor Deposit View page actions Starts-------------------------------------
  
   
   Route::get('admin/investordepositview/add/{payment_id}/{investor_id}', 
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'add.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'Add Investor Deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@addDepositAction'
									]
			);
   Route::get('admin/investordepositview/edit/{payment_id}/{investor_id}', 
									[	
										'as'			=>	'admin.investordepositedit',
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'Edit Investor Deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@editDepositAction'
									]
			);
   Route::get('admin/investordepositview/view/{payment_id}/{investor_id}', 
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'detailview.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'View Investor Deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@viewDepositAction'
									]
			);
		
    Route::post('admin/investordepositview/save',	'AdminInvestorsDepositListingController@saveDepositAction');
    
    Route::post('admin/investordepositview/approve',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'approve deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@approveDepositAction'
									]
			);
    Route::post('admin/investordepositview/unapprove',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'unapprove.admin.investorsdeposit',
										'redirect_back'	=>	'admin.investordepositlist',
										'action_type'	=>	'unapprove deposit',
										'uses' 			=>	'AdminInvestorsDepositListingController@unapproveDepositAction'
									]
			);
    //------------------------Investor Deposit View page actions Ends-------------------------------------
   
    //-----------------------Investor Withdrawals Listing page actions Starts------------------------------------
    Route::get('admin/investorwithdrawallist',
								[	
										'as' 			=> 	'admin.investorwithdrawallist', 
										'middleware' 	=> 	'permission',
										'permission'	=>	'listview.admin.investorswithdrawal',
										'uses' 			=>	'AdminInvestorsWithdrawalsListingController@indexAction'
								]
			);
    
    Route::post('admin/investorwithdrawallist/bulkapprove', 
							[	
									'middleware' 	=> 	'permission',
									'permission'	=>	'approve.admin.investorswithdrawal',
									'redirect_back'	=>	'admin.investorwithdrawallist',
									'action_type'	=>	'approve investor withdrawal in bulk action',
									'uses' 			=>	'AdminInvestorsWithdrawalsListingController@bulkApproveWithdrawalAction'
							]
				);
    Route::post('admin/investorwithdrawallist/bulkunapprove', 
						[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'unapprove.admin.investorswithdrawal',
								'redirect_back'	=>	'admin.investorwithdrawallist',
								'action_type'	=>	'unpprove investor withdrawal in bulk action',
								'uses' 			=>	'AdminInvestorsWithdrawalsListingController@bulkUnApproveWithdrawalAction'
						]
				);
    Route::post('admin/investorwithdrawallist/bulkdelete', 
							[	
									'middleware' 	=> 	'permission',
									'permission'	=>	'delete.admin.investorswithdrawal',
									'redirect_back'	=>	'admin.investorwithdrawallist',
									'action_type'	=>	'delete investor withdrawal in bulk action',
									'uses' 			=>	'AdminInvestorsWithdrawalsListingController@bulkDeleteWithdrawalAction'
							]
				);
  //------------------------Investor Withdrawals Listing page actions Ends------------------------------------
  
  //------------------------Investor Withdrawals View page actions Starts-------------------------------------
  
   Route::get('admin/investorwithdrawalview/add/{payment_id}/{investor_id}', 
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'add.admin.investorswithdrawal',
										'redirect_back'	=>	'admin.investorwithdrawallist',
										'action_type'	=>	'Add withdrawal',
										'uses' 			=>	'AdminInvestorsWithdrawalsListingController@addWithdrawalAction'
									]
			);
			
   Route::get('admin/investorwithdrawalview/edit/{payment_id}/{investor_id}', 
									[	
										'as'			=>	'admin.investorwithdrawaledit',
										'middleware' 	=> 	'permission',
										'permission'	=>	'edit.admin.investorswithdrawal',
										'redirect_back'	=>	'admin.investorwithdrawallist',
										'action_type'	=>	'Edit withdrawal',
										'uses' 			=>	'AdminInvestorsWithdrawalsListingController@editWithdrawalAction'
									]
			);
   Route::get('admin/investorwithdrawalview/view/{payment_id}/{investor_id}', 
									[	
										
										'middleware' 	=> 	'permission',
										'permission'	=>	'detailview.admin.investorswithdrawal',
										'redirect_back'	=>	'admin.investorwithdrawallist',
										'action_type'	=>	'View withdrawal',
										'uses' 			=>	'AdminInvestorsWithdrawalsListingController@viewWithdrawalAction'
									]
			);
		
    
    Route::post('admin/investorwithdrawalview/save','AdminInvestorsWithdrawalsListingController@saveWithdrawalAction');
    Route::post('admin/investorwithdrawalview/approve',
									[	
										'middleware' 	=> 	'permission',
										'permission'	=>	'approve.admin.investorswithdrawal',
										'redirect_back'	=>	'admin.investorwithdrawallist',
										'action_type'	=>	'approve withdrawal',
										'uses' 			=>	'AdminInvestorsWithdrawalsListingController@approveWithdrawalAction'
									]
			);
    Route::post('admin/investorwithdrawalview/unapprove',
								[	
									'middleware' 	=> 	'permission',
									'permission'	=>	'approve.admin.investorswithdrawal',
									'redirect_back'	=>	'admin.investorwithdrawallist',
									'action_type'	=>	'unapprove withdrawal',
									'uses' 			=>	'AdminInvestorsWithdrawalsListingController@unapproveWithdrawalAction'
								]
			);
    //------------------------Investor Withdrawals View page actions Ends-------------------------------------
    
     //**************************** Manage Banking Transactions for Investors Ends*****************************************
     
    // **************************** Admin Users Creating, Editing,Roles assigning******************************************
    
	Route::get('admin/user',[	
								'as'			=>	'admin.user',
								'middleware' 	=> 	'permission',
								'permission'	=>	'view.admin.manageusers',
								'action_type'	=>	'View Manage Users',
								'uses' 			=>	'UserController@index'
							]
			);
	
	Route::get('admin/roles',[	
								'as'			=>	'admin.roles',
								'middleware' 	=> 	'permission',
								'permission'	=>	'view.admin.manageroles',
								'action_type'	=>	'View Manage Roles',
								'uses' 			=>	'AdminRolesController@indexAction'
							]
				);
				
	Route::get('admin/roles/delete/{role_id}',[	
								
								'middleware' 	=> 	'permission',
								'permission'	=>	'deleterole.admin.manageroles',
								'action_type'	=>	'Delete Roles',
								'uses' 			=>	'AdminRolesController@deleteAction'
							]
				);
	
	Route::get('admin/role-users/{role_id}', 
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewroleuser.admin.manageroles',
								'redirect_back'	=>	'admin.roles',
								'action_type'	=>	'View Role Users',
								'uses' 			=>	'AdminRolesController@roleUsersAction'
							]
				);
	Route::get('admin/role-permission/add/{role_id}', 
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'addrolepermission.admin.manageroles',
								'redirect_back'	=>	'admin.roles',
								'action_type'	=>	'Add New Role Permissions',
								'uses' 			=>	'AdminRolesController@addRolePermissionsAction'
							]
				);
	Route::get('admin/role-permission/edit/{role_id}', 
							[	
								'as'			=>	'admin.rolepermission.edit',
								'middleware' 	=> 	'permission',
								'permission'	=>	'editrolepermission.admin.manageroles',
								'redirect_back'	=>	'admin.roles',
								'action_type'	=>	'Edit Role Permissions',
								'uses' 			=>	'AdminRolesController@editRolePermissionsAction'
							]
				);
	Route::post('admin/role-permission/save', 'AdminRolesController@saveRolePermissionsAction');
		
	 Route::get('admin/assign-roles/{user_id}',
							[	
								'as'			=>	'admin.assignroles',
								'middleware' 	=> 	'permission',
								'permission'	=>	'assignrole.admin.manageroles',
								'redirect_back'	=>	'admin.roles',
								'action_type'	=>	'Assign Roles',
								'uses' 			=>	'AdminAssignRolesController@indexAction'
							]
				);
	 Route::post('admin/assign-roles','AdminAssignRolesController@saveUserRolesAction');
	 
	 //-------------------------------------------------ajax call actions-----------------------------------
		Route::get('admin/ajax/user_master', 'UserController@view_user');
		Route::post('admin/ajax/user_master', 'UserController@view_user');
		Route::post('admin/ajax/CheckRoleNameavailability', 'AdminRolesController@CheckRoleNameavailability');
		
		Route::post('admin/ajax/systemmessagetable',  'AdminSettingsController@ajaxAction');
		
		Route::post('admin/ajax/editmessage',  'AdminSettingsController@ajaxEditAction');
		Route::post('admin/ajax/editmailcontent',  'AdminSettingsController@ajaxEmailEditAction');
		
		Route::get('admin/ajax/adminborrower', 'AdminManageBorrowersController@ajaxBorrowerList');
		Route::post('admin/ajax/adminborrower', 'AdminManageBorrowersController@ajaxBorrowerList');
		
		Route::get('admin/ajax/admininvestor', 'AdminManageInvestorsController@ajaxInvestorList');
		Route::post('admin/ajax/admininvestor', 'AdminManageInvestorsController@ajaxInvestorList');
		
		Route::get('admin/ajax/adminloanlisting', 'AdminLoanListingController@ajaxLoanList');
		Route::post('admin/ajax/adminloanlisting', 'AdminLoanListingController@ajaxLoanList');
		
		Route::get('admin/ajax/adminloandisplay', 'AdminLoanDisplayController@ajaxEditLoanDisplayOrderList');
		Route::post('admin/ajax/adminloandisplay', 'AdminLoanDisplayController@ajaxEditLoanDisplayOrderList');
		
		Route::get('admin/ajax/adminrepaylist', 'AdminBorrowersRepaymentListingController@ajaxRepayList');
		Route::post('admin/ajax/adminrepaylist', 'AdminBorrowersRepaymentListingController@ajaxRepayList');
		
		Route::get('admin/ajax/admininvdepositlist', 'AdminInvestorsDepositListingController@ajaxInvDepositList');
		Route::post('admin/ajax/admininvdepositlist', 'AdminInvestorsDepositListingController@ajaxInvDepositList');
		
		Route::get('admin/ajax/admininvwithdrawlist', 'AdminInvestorsWithdrawalsListingController@ajaxInvWithdrawList');
		Route::post('admin/ajax/admininvwithdrawlist', 'AdminInvestorsWithdrawalsListingController@ajaxInvWithdrawList');
		
		Route::get('admin/ajax/adminchangebank', 'AdminChangeofBankController@ajaxChangeBank');
		Route::post('admin/ajax/adminchangebank', 'AdminChangeofBankController@ajaxChangeBank');		
		

	 // **************************** Admin Users Creating, Editing,Roles assigning******************************************
	 
	 Route::get('admin/mypage', [
								'uses' => 'HomeController@mypageAction', 
								'as' => 'mypage'
								]
				);
	 Route::get('admin/changepassword/{user_id}', 	
								[
									'uses' => 'AdminChangePasswordController@indexAction', 
									'as' => 'admin.changepassword'
								]
				);
	 Route::post('admin/changepassword/save', 'AdminChangePasswordController@saveChangePasswordAction');
	 
	  // **************************** Admin Report******************************************
	  		
	 Route::get('admin/investoractivity/report',
							[	
								'middleware' 		=> 	'permission',
								'permission'		=>	'viewinvestor.admin.reportactivity',
								'action_type'		=>	'Investor Activity Report',
								'uses' 				=>	'AdminInvestorActivityReportController@indexAction'
							]
				);
	 Route::post('admin/investoractivity/report',
							[	
								
								'uses' 			=>	'AdminInvestorActivityReportController@indexPostAction'
							]
				);
	 Route::post('admin/investor-activity-report/download','AdminInvestorActivityReportController@DownloadInvestorAction'
							
				);
	 
	 Route::get('admin/borroweractivity/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewborrower.admin.reportactivity',
								'action_type'	=>	'Borrower Activity',
								'uses' 			=>	'AdminBorrowerActivityReportController@indexAction'
							]
				);
	 Route::post('admin/borroweractivity/report',
							[	
								
								'uses' 			=>	'AdminBorrowerActivityReportController@indexPostAction'
							]
				);
	 
	 Route::post('admin/borrower-activity-report/download',
											'AdminBorrowerActivityReportController@DownloadBorrowerAction'
							
				);
	 
	 Route::get('admin/bankactivity/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewbank.admin.reportactivity',
								'action_type'	=>	'Bank Activity Report',
								'uses' 			=>	'AdminBankActivityReportController@indexAction'
							]
				);
	 Route::post('admin/bankactivity/report',
							[	
								
								'uses' 			=>	'AdminBankActivityReportController@indexPostAction'
							]
				);
	Route::post('admin/bank-activity-report/download',
											'AdminBankActivityReportController@DownloadBankAction'
							
				);
	//****************************Loan listing report starts ********************************************************
	 Route::get('admin/loan-listing/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewloan.admin.reportlisting',
								'action_type'	=>	'Loan Listing Report',
								'uses' 			=>	'AdminLoanListingReportController@indexAction'
							]
				);
	 Route::post('admin/loan-listing/report',
							[	
								
								'uses' 			=>	'AdminLoanListingReportController@indexPostAction'
							]
				);
	Route::post('admin/loan-listing-report/download',
											'AdminLoanListingReportController@DownloadLoanListingAction'
							
				);
	 //****************************Loan listing report ends********************************************************
	 
	//****************************Investors Profile report starts ******************************************************
	 Route::get('admin/investor-profiles/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewinvestor.admin.reportprofile',
								'action_type'	=>	'Investor Profile  Report',
								'uses' 			=>	'AdminInvestorsProfileReportController@indexAction'
							]
				);
	 Route::post('admin/investor-profiles/report',
							[	
								
								'uses' 			=>	'AdminInvestorsProfileReportController@indexPostAction'
							]
				);
	Route::post('admin/investor-profiles-report/download',
											'AdminInvestorsProfileReportController@DownloadInvestorProfileAction'
							
				);
	 //****************************Investors Profile report ends********************************************************
	 
	//****************************Borrowers Profile report starts ********************************************************
	 Route::get('admin/borrower-profiles/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewborrower.admin.reportprofile',
								'action_type'	=>	'Borrower Profile Report',
								'uses' 			=>	'AdminBorrowersProfileReportController@indexAction'
							]
				);
	 Route::post('admin/borrower-profiles/report',
							[	
								
								'uses' 			=>	'AdminBorrowersProfileReportController@indexPostAction'
							]
				);
	Route::post('admin/borrower-profiles-report/download',
											'AdminBorrowersProfileReportController@DownloadBorrowerProfileAction'
							
				);
	 //****************************Borrowers Profile report ends********************************************************
	 
	 //****************************Loan Performance report starts ********************************************************
	 Route::get('admin/loan-perform/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewloan.admin.reportperformance',
								'action_type'	=>	'Loan Performance Report',
								'uses' 			=>	'AdminLoanPerformanceReportController@indexAction'
							]
				);
	 Route::post('admin/loan-perform/report',
							[	
								
								'uses' 			=>	'AdminLoanPerformanceReportController@indexPostAction'
							]
				);
	Route::post('admin/loan-perform-report/download',
											//~ 'AdminLoanPerformanceReportController@DownloadLoanPerformanceTestAction'
											'AdminLoanPerformanceReportController@DownloadLoanPerformanceAction'
							
				);
	 //****************************Loan Performance report ends********************************************************
	 
	 //****************************commission Fee ledger report starts *************************************************
	 Route::get('admin/commission-fees-ledger/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewcommfees.admin.reportledger',
								'action_type'	=>	'Commission Fees Ledger Report',
								'uses' 			=>	'AdminCommFeeLedgerReportController@indexAction'
							]
				);
	 Route::post('admin/commission-fees-ledger/report',
							[	
								
								'uses' 			=>	'AdminCommFeeLedgerReportController@indexPostAction'
							]
				);
	Route::post('admin/commission-fees-ledger-report/download',
											'AdminCommFeeLedgerReportController@DownloadCommissionFeesLedgerAction'
							
				);
	 //****************************commission Fee ledger report ends********************************************************
	 
	 //****************************Penalties Levies Ledger report starts *************************************************
	 Route::get('admin/penalties-levies/report',
							[	
								'middleware' 	=> 	'permission',
								'permission'	=>	'viewpenlev.admin.reportledger',
								'action_type'	=>	'Penalty levies Ledger Report',
								'uses' 			=>	'AdminPenaltiesLeviesReportController@indexAction'
							]
				);
	 Route::post('admin/penalties-levies/report',
							[	
								
								'uses' 			=>	'AdminPenaltiesLeviesReportController@indexPostAction'
							]
				);
	Route::post('admin/penalties-levies-report/download',
											'AdminPenaltiesLeviesReportController@DownloadPenaltyLeviesAction'
							
				);
	 //****************************Penalties Levies ledger report ends********************************************************
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
	Route::get('borrower/makepayment/{repayment_id}/{loan_id}', 
									[	'as'	=>	'borrower.makepayment',
										'uses'	=>	'BorrowerRepayLoansController@paymentAction'
									]
			);
	Route::post('borrower/borrowersrepayview/save','BorrowerRepayLoansController@saveAction');
	Route::post('borrower/ajax/recalculatePenality','BorrowerRepayLoansController@recalculatePenalityAction');
});

// The routes (or pages that are applicable for investor users only
Route::group(['middleware' => 'App\Http\Middleware\InvestorMiddleWare'], function()
{
	// Investor Dashboard
    Route::get('investor/dashboard', 'InvestorDashboardController@indexAction');
    
    // Investor Profile
   
    Route::post('investor/profile', 'InvestorProfileController@indexAction');
    Route::post('investor/checkFieldExists', 'InvestorProfileController@ajaxCheckFieldExistsAction');
	Route::get('investor/loanslist', 'LoanListingController@indexAction');
	
	// Loans 
    Route::get('investor/myloaninfo', 'InvestorMyLoanInfoController@indexAction');
    Route::match(['get', 'post'],'investor/myloans/{loan_id}', 'LoanDetailsController@indexAction');  
    
    // Transaction History
    Route::get('investor/transhistory', 'InvestorTransHistoryController@indexAction'); 
    
    // Banking
    Route::get('investor/depositlist', 'InvestorsDepositListingController@indexAction');
    Route::get('investor/deposit/{type}/{payment_id}', 
								[	
									'as'			=>	'investor.investordepositedit',
									'uses' 			=>	'InvestorsDepositListingController@viewDepositAction'
								]
			);
    Route::post('investor/investordepositview/save',	'AdminInvestorsDepositListingController@saveDepositAction');
    
    Route::get('investor/withdrawallist', 'InvestorsWithdrawalsListingController@indexAction');
    Route::get('investor/withdrawal/{type}/{payment_id}', 
																[	
									'as'			=>	'investor.investorwithdrawaledit',
									'uses' 			=>	'InvestorsWithdrawalsListingController@viewWithDrawAction'
								]
				);
	Route::post('investor/investorwithdrawalview/save','AdminInvestorsWithdrawalsListingController@saveWithdrawalAction');
    Route::match(['get', 'post'],'investor/bankdetails', 'BankProcessController@indexAction');   
    
    Route::post('ajax/investor/send_comment', 'LoanDetailsController@ajaxSubmitCommentAction');	
    Route::post('ajax/investor/send_reply', 'LoanDetailsController@ajaxSubmitReplyAction');	   	
    Route::post('investor/ajax/availableBalance', 'LoanDetailsController@ajaxAvailableBalanceAction');	   	
});
 Route:get('investor/profile', ['as'=>'investor.profile','uses'=>'InvestorProfileController@indexAction']);
 
// Common Modules
Route::get('customRedirectPath', 'HomeController@customRedirectPath');
Route::get('getActiveLoans', 'LoanListingAllController@getActiveLoansAction');

Route::post('ajax/CheckEmailavailability', 'RegistrationController@checkEmailavailability');
Route::post('ajax/CheckUserNameavailability', 'RegistrationController@CheckUserNameavailability');
Route::post('submit_registration', 'RegistrationController@submitAction');
Route::get('register', 'RegistrationController@indexAction');
Route::get('activation/{activation}', 'RegistrationController@activationAction'); 
Route::get('verification', 'RegistrationController@verificationAction'); 

Route::get('download/borrower/profile/attachment/{profile_id}/{fieldno}', 'BorrowerProfileController@downloadAction');
Route::get('download/borrower/director/attachment/{profile_id}/{dir_id}/{type}',
																		'BorrowerProfileController@downloadDirAction');
Route::get('download/borrower/bank/attachment/{profile_id}/{bank_id}',
																		'BorrowerProfileController@downloadBankAction');
Route::get('download/investor/bank/attachment/{profile_id}/{bank_id}',
																		'InvestorProfileController@downloadBankAction');
Route::post('update/show_welcome/popup','UserController@uploadShowWelcomeMessageStatus');
/*
Route::get('verification', function() {
	echo "<h3>Registration successful, please activate email.</h3>";
});*/

//broadcast notification routes
Route::get('admin/broadcast/notifications','AdminNotificationsController@createNotifications'); 
Route::post('admin/broadcast/notifications','AdminNotificationsController@createNotifications'); 
Route::post('admin/broadcast-receipients','AdminNotificationsController@getReceipients');
Route::get('admin/broadcast/notificationsList','AdminNotificationsController@notificationsList'); 
//Notification list & row action
Route::get('admin/ajax/getNotifications','AdminNotificationsController@getNotifications'); 
Route::post('admin/notifications/action/viewReceipients/{Id}','AdminNotificationsController@getNotificationRecipients'); 
Route::get('admin/notifications/action/edit/{Id}','AdminNotificationsController@editNotification');
Route::post('admin/notifications/action/edit/{Id}','AdminNotificationsController@createNotifications'); 
Route::get('admin/notifications/action/delete/{Id}','AdminNotificationsController@deleteNotification'); 
Route::get('admin/notifications/action/process/{Id}','AdminNotificationsController@processNotification'); 

//send mail routes
Route::get('admin/bulkMailer/mailList','AdminBulkMailersController@mailerList');  
Route::get('admin/bulkMailer/mailer','AdminBulkMailersController@createBulkMails'); 
Route::post('admin/bulkMailer/mailer','AdminBulkMailersController@createBulkMails'); 
//Notification list & row action
Route::get('admin/ajax/getMailers','AdminBulkMailersController@getAjaxMailersList');  
Route::post('admin/mailer/action/viewReceipients/{Id}','AdminBulkMailersController@getMailerRecipients'); 
Route::get('admin/mailer/action/copy/{Id}','AdminBulkMailersController@copyRecords');
Route::get('admin/mailer/action/edit/{Id}','AdminBulkMailersController@editMailer');
Route::post('admin/mailer/action/edit/{Id}','AdminBulkMailersController@createBulkMails'); 
Route::get('admin/mailer/action/delete/{Id}','AdminBulkMailersController@deleteMailer'); 
Route::get('admin/mailer/action/process/{Id}','AdminBulkMailersController@processMailer'); 
//Get user notifications
Route::post('admin/user/notifications','AdminNotificationsController@getUserNotifications'); 
 
