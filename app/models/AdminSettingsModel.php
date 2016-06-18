<?php namespace App\models;
class AdminSettingsModel extends TranWrapper {
	
	public $settingsList		=	array();
	public $moduleList			=	array();	
	public $module				=	array();	
	public $email				=	array();	
	public $event_val				=	array();	
	public $defaultmoduleval	=	"all";
	
	
	public function getGeneralSettings(){
		
		$settings_sql = "SELECT 
								application_name,
								admin_email,
								admin_email_label,
								backend_email,
								backend_email_label,
								mail_cc_to,
								send_live_mails,
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
								penalty_interest 
							FROM
								system_settings";
							
		$result			=	$this->dbFetchAll($settings_sql);
			
		$this->settingsList = 	$result;						
		
	}	
	
	public function getModuleDropdown(){
		
		$module_sql			=	 "SELECT DISTINCT module FROM system_messages";
							
		$result_module		=	$this->dbFetchAll($module_sql);
			
		$moduleListing		= 	$result_module;		
		
		$this->moduleList['all'] 	=	'All';
		
		foreach($moduleListing as $module_row) {
			$this->moduleList[] = $module_row->module;		
		}		
	}
	
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
								
		$module_rs		= 	$this->dbFetchAll($module_sql);
		return	$module_rs;
	}
	
	public function getEditModuleTable($slug){
		
		$editmodule_sql			= "	SELECT 
										module,
										event_action,
										slug_name,
										message_text,
										send_email										 
									FROM system_messages 
									WHERE slug_name = '{$slug}' ";
								
		$editmodule_rs		= 	$this->dbFetchRow($editmodule_sql);
		
		if ($editmodule_rs) {
			$this->module	=	$editmodule_rs;
		}		
		return	$this->module;		
	}	
	
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
		//echo "<pre>",print_r($newarray),"</pre>"; die;
		if ($editemail_rs) {
			$this->email	=	$editemail_rs;
		}		
		return	$this->email;		
	}		
	
	public function updateEmailMessage($email_subject,$email_content,$slug){
		
		$dataArray 	   = array( 'email_subject'	=> $email_subject,'email_content' =>$email_content);		
		$whereArry	   = array('slug_name' =>"{$slug}");
		$result 	   = $this->dbUpdate('email_notifications', $dataArray, $whereArry );
		//echo "<pre>",print_r($result),"</pre>"; die;
		if($result){
			return 1;
		}else { 
			return -1;
		}
	}
	
	public function updateModuleMessage($event_action,$slug){
			
		$dataArray 	   = array( 'message_text'	=> $event_action);
		$whereArry	   = array('slug_name' =>"{$slug}");
		$result 	   = $this->dbUpdate('system_messages', $dataArray, $whereArry );
		if($result){
			return 1;
		}else { 
			return -1;
		}
	}
	
	public function updateGeneralSettings($postArray){
		
	//	echo "<pre>",print_r($postArray),"</pre>"; die;
		if(isset($postArray)){
			/*First Tab*/
			$application_Name 		= $postArray['application_name'];
			$mailFromAddress		= $postArray['mail_from_address'];
			$mailFromName			= $postArray['mail_from_name'];
			$backendTeamEmailAdd	= $postArray['backend_team_mailaddress'];
			$backendTeamEmailName	= $postArray['backend_team_mailname'];
			$mailCC					= $postArray['mail_cc'];
			$sendLiveMail			= isset($postArray['livemails'])?$postArray['livemails']:0;
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
		}
		// Construct the data array
		$dataArray = array(	'application_name'				=> $application_Name,								
							'admin_email' 					=> $mailFromAddress,
							'admin_email_label'				=> $mailFromName,
							'backend_email'					=> $backendTeamEmailAdd,
							'backend_email_label'			=> $backendTeamEmailName,
							'mail_cc_to'					=> $mailCC,
							'send_live_mails'				=> $sendLiveMail,
							
							'mail_driver'					=> $mailDriver,
							'mail_host'						=> $mailHost,
							'mail_port'						=> $mailPort,
							'mail_encryption'				=> $mailEncrypt,
							'mail_username'					=> $mailUsername,
							'mail_password'					=> $mailPassword,
														
							'monthly_pay_by_date'			=> $loanMonthly,
							'loan_fixed_fees'				=> $processFixedFees,
							'loan_fees_percent'				=> $processFeePercent,
							'loan_fees_minimum_applicable'	=> $processFeeMinimum,
							'penalty_fee_minimum'			=> $penaltyProcessFee,
							'penalty_fee_percent'			=> $penaltyProcessPercent,
							'penalty_interest'				=> $penaltyInterest							
						);			
		//echo "<pre>",print_r($dataArray),"</pre>"; die;				
		$whereArray	=	[ "application_name"	=> $application_Name];
		$id = $this->dbUpdate('system_settings', $dataArray, $whereArray);
		if($id)		{		 
			return 	1;
		}else{
			return 	-1;
		}
	}	
}
