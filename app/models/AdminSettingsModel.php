<?php namespace App\models;
class AdminSettingsModel extends TranWrapper {
	
	public $settingsList		=	array();
	public $moduleList			=	array();	
	public $module				=	array();	
	public $email				=	array();	
	public $event_val			=	array();	
	public $defaultmoduleval	=	"all";
	public $successTxt			=	"";
	/**Fetching the Records to display in frontend**/
	public function getGeneralSettings(){
		
		$settings_sql 		= "SELECT 
									application_name,
									admin_email,
									admin_email_label,
									backend_email,
									backend_email_label,
									mail_cc_to,
									send_live_mails,
									auto_bids_close,
									auto_bids_close_cronjob_time,
									send_reminder_mails_to_borrower,
									reminder_mails_days_before_due_date,
									mail_driver,
									mail_host,
									mail_port,
									mail_encryption,
									mail_username,
									mail_password,
									monthly_pay_by_date,
									loan_fixed_fees,
									loan_fees_percent,
									loan_fees_minimum_applicable,
									penalty_fee_minimum,
									penalty_fee_percent,
									penalty_interest,
									toc_investor,
									toc_borrower,
									firsttime_borrower_popup,
									firsttime_investor_popup
								FROM
									system_settings";
							
		$result				=	$this->dbFetchAll($settings_sql);
		
		$this->settingsList = 	$result;						
		 
	}	
	/**Dropdown Module**/
	public function getModuleDropdown(){
		
		$module_sql			=	 "SELECT 
									DISTINCT module 
									FROM system_messages";
							
		$result_module		=	$this->dbFetchAll($module_sql);
			
		$moduleListing		= 	$result_module;		
		
		$this->moduleList['all'] 	=	'All';
		
		foreach($moduleListing as $module_row) {
			$this->moduleList[] = $module_row->module;		
		}		
	}
	/**Dropdown Module Filter Table**/
	public function getModuleTable($defaultmodule){
		
		$moduleWhere		= ($defaultmodule == "All")? 
										"module":	"'{$defaultmodule}'";
								
		$module_sql			= "	SELECT 
									module,
									event_action,
									slug_name,
									message_text,
									send_email,
										CASE send_email
										   when 1  then 'Yes'
										   when 0  then 'No'										  
										END as send_email_text 
								FROM system_messages 
								WHERE module = {$moduleWhere} ";
								
		$module_rs			= 	$this->dbFetchAll($module_sql);
		return	$module_rs;
	}
	/**Display System Messages**/
	public function getEditModuleTable($slug){
		
		$editmodule_sql			= "	SELECT 
										module,
										event_action,
										slug_name,
										message_text,
										(SELECT slug_name 
										FROM email_notifications 
										WHERE slug_name='{$slug}') as email_slug,
										send_email										 
									FROM system_messages 
									WHERE slug_name = '{$slug}' ";
								
		$editmodule_rs			= 	$this->dbFetchRow($editmodule_sql);
		
		if ($editmodule_rs) {
			$this->module		=	$editmodule_rs;
		}		
		return	$this->module;		
	}	
	/**Display Email Contents**/
	public function getEditEmailContent($slug){
		$selectemail_sql	=	"SELECT 
									slug_name,
									(SELECT event_action 
										FROM system_messages 
										WHERE slug_name='{$slug}') as event,
									email_subject,
									email_content
								FROM email_notifications 
								WHERE slug_name = '{$slug}' ";
								
		$editemail_rs		= 	$this->dbFetchRow($selectemail_sql);		
		
		if ($editemail_rs) {
			$this->email	=	$editemail_rs;
		}		
		return	$this->email;		
	}		
	/**Save Email Contents**/
	public function updateEmailMessage($email_subject,$email_content,$slug){
		
		$dataArray 	   = array( 'email_subject'	=> $email_subject,
								'email_content' =>$email_content);		
		$whereArry	   = array('slug_name' =>"{$slug}");
		$result_email  = $this->dbUpdate('email_notifications', $dataArray, $whereArry );
		$this->successTxt	=	$this->getSystemMessageBySlug("update_email_message");
		if($result_email){
			return 1;
		}
	}
	/**Save System Messages**/
	public function updateModuleMessage($event_action,$slug,$emailslug,$sendmail){
		
		/*Delete or Insert row based on email notification has slug*/
			
		if($sendmail){
			is_null($emailslug);
			$dataArray	= array( 'slug_name' => $slug ,
								'email_subject' => 'Default' ,
								'email_content' => 'Default');
			
			 $this->dbInsert('email_notifications', $dataArray, true);		
		}else{
			if($emailslug){
				$where		= array('slug_name' =>"{$emailslug}");
				$this->dbDelete('email_notifications', $where);
			}		
		}
		
		/**Update the Event Messages**/	
		$dataArray 	   = array( 'message_text'	=> $event_action);
		$whereArry	   = array('slug_name' =>"{$slug}");
		$result 	   = $this->dbUpdate('system_messages', $dataArray, $whereArry );		
		$this->successTxt	=	$this->getSystemMessageBySlug("update_module_message");
		if($result){
			return 1;
		}
	}
	
	public function updateGeneralSettings($postArray){		
	
		if(isset($postArray)){
			/*First Tab*/
			$application_Name 		= $postArray['application_name'];
			$mailFromAddress		= $postArray['mail_from_address'];
			$mailFromName			= $postArray['mail_from_name'];
			$backendTeamEmailAdd	= $postArray['backend_team_mailaddress'];
			$backendTeamEmailName	= $postArray['backend_team_mailname'];
			$mailCC					= $postArray['mail_cc'];
			$sendLiveMail			= isset($postArray['livemails'])?$postArray['livemails']:0;
			$autobidclose			= isset($postArray['autobidclose'])?$postArray['autobidclose']:0;
			$auto_bids_closetime	= isset($postArray['auto_close_time'])?$postArray['auto_close_time']:"00:00";
			$remindmail_borrower	= isset($postArray['remindmail_borrower'])?$postArray['remindmail_borrower']:0;
			$daysbefore_duedate		= $postArray['daysbefore_duedate'];
			/*Second Tab*/
			$mailDriver 			= $postArray['mail_driver'];	
			$mailHost				= $postArray['mail_host'];	
			$mailPort				= $postArray['mail_port'];	
			$mailEncrypt			= $postArray['mail_encryption'];	
			$mailUsername			= $postArray['mail_username'];	
			$mailPassword			= $postArray['mail_password'];	
			/*Fourth Tab*/
			$loanMonthly			= $postArray['loan_monthly'];	
			$processFixedFees		= $postArray['processing_fixed_fees'];	
			$processFeePercent		= $postArray['processing_fees_percent'];	
			$processFeeMinimum		= $postArray['processing_fee_minimum'];	
			$penaltyProcessFee		= $postArray['penalty_process_fee'];	
			$penaltyProcessPercent	= $postArray['penalty_process_percent'];	
			$penaltyInterest		= $postArray['penalty_interest'];	
			/*Fifth Tab*/	
			$borrower_terms			= $postArray['bor_terms'];	
			$investor_terms			= $postArray['inv_terms'];			
			/*Sixth Tab*/			
			$borrower_firstpopup	= $postArray['bor_popup'];	
			$investor_firstpopup	= $postArray['inv_popup'];	
		}
		// Construct the data array
		$dataArray = array(	'application_name'						=> $application_Name,								
							'admin_email' 							=> $mailFromAddress,
							'admin_email_label'						=> $mailFromName,
							'backend_email'							=> $backendTeamEmailAdd,
							'backend_email_label'					=> $backendTeamEmailName,
							'mail_cc_to'							=> $mailCC,
							'send_live_mails'						=> $sendLiveMail,
							'auto_bids_close'						=> $autobidclose,
							'auto_bids_close_cronjob_time'			=> $auto_bids_closetime,
							'send_reminder_mails_to_borrower'		=> $remindmail_borrower,
							'reminder_mails_days_before_due_date'	=> $daysbefore_duedate,
							
							'mail_driver'							=> $mailDriver,
							'mail_host'								=> $mailHost,
							'mail_port'								=> $mailPort,
							'mail_encryption'						=> $mailEncrypt,
							'mail_username'							=> $mailUsername,
							'mail_password'							=> $mailPassword,
														
							'monthly_pay_by_date'					=> $loanMonthly,
							'loan_fixed_fees'						=> $processFixedFees,
							'loan_fees_percent'						=> $processFeePercent,
							'loan_fees_minimum_applicable'			=> $processFeeMinimum,
							'penalty_fee_minimum'					=> $penaltyProcessFee,
							'penalty_fee_percent'					=> $penaltyProcessPercent,
							'penalty_interest'						=> $penaltyInterest,
							
							'toc_borrower'							=> $borrower_terms,						
							'toc_investor'							=> $investor_terms,					
							'firsttime_borrower_popup'				=> $borrower_firstpopup,					
							'firsttime_investor_popup'				=> $investor_firstpopup						
						);			
		
		$whereArray	=	[ "application_name"	=> $application_Name];
		$id = $this->dbUpdate('system_settings', $dataArray, $whereArray);		
		$this->successTxt	=	$this->getSystemMessageBySlug("update_system_settings");
		if($id)		{		 
			return 	1;
		}
	}	
}
