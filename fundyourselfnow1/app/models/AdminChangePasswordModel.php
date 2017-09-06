<?php namespace App\models;
use Hash;
use Auth;
class AdminChangePasswordModel extends TranWrapper {
	
	
	public	$user_id			=	0;
	public	$userType			=	0;
	public	$selected_user_name	=	"";
	public	$returnBackUrl		=	"";
	public	$returnRouteName	=	"";
	public	$successTxt			=	"";
	
	public function setChangePasswordVariables($selected_user_id){
		
		$this->user_id				=	$selected_user_id;
		$this->userType				=	$this->getUserInfoByUserId($selected_user_id)->usertype;
		$this->selected_user_name	=	$this->getUserInfoByUserId($selected_user_id)->username;
		switch($this->userType) {
			case USER_TYPE_ADMIN:
				$this->returnBackUrl	=	url("admin/user");
				$this->returnRouteName	=	"admin.user";
				break;
			case USER_TYPE_INVESTOR:
				$this->returnBackUrl	=	url("admin/manageinvestors");
				$this->returnRouteName	=	"admin.manageinvestors";
				break;
			case USER_TYPE_BORROWER:
				$this->returnBackUrl	=	url("admin/manageborrowers");
				$this->returnRouteName	=	"admin.manageborrowers";
				break;
		}
	}
	
	public function updateChangePassword($postArray) {
		
		$userId			=	$postArray['selected_user_id'];		
		$password		=	$postArray['new_password'];		
		$whereArry		=	[	"user_id" =>"{$userId}"];
		$dataArray		= 	[	"password"=> Hash::make($password)];
		
		$this->dbUpdate('users', $dataArray, $whereArry);
		$this->userType	=	$this->getUserInfoByUserId($userId)->usertype;
		switch($this->userType) {
			case USER_TYPE_INVESTOR:
				$this->changePassword_sendMailToInvestor($userId,$password);
				$this->successTxt	=	$this->getSystemMessageBySlug("change_password_investor");
				break;
			case USER_TYPE_BORROWER:
				$this->changePassword_sendMailToBorrower($userId,$password);
				$this->successTxt	=	$this->getSystemMessageBySlug("change_password_borrower");
				break;
			case USER_TYPE_ADMIN:
				$this->changePassword_sendMailToSystemUser($userId,$password);
				$this->successTxt	=	$this->getSystemMessageBySlug("change_password_admin");
				break;
		}
		$this->changePassword_copyToAdmin($userId,$password);
		return $userId;
	}
	
	public function changePassword_sendMailToInvestor($userId,$password) {
	
		$invUserInfo		=	$this->getUserInfoByUserId($userId);
		
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$slug_name			=	"change_password_investor";
		$fields 			= array(
									'[investor_firstname]',
									'[investor_lastname]',
									'[application_name]');
		$replace_array 		= array();
		$replace_array 		= 	array( 
										$invUserInfo->firstname, 
										$invUserInfo->lastname, 
										$moneymatchSettings[0]->application_name);
										
		$this->sendMailByModule($slug_name,$invUserInfo->email,$fields,$replace_array);
	
	}
	
	public function changePassword_sendMailToBorrower($userId,$password) {
	
		$borUserInfo		=	$this->getUserInfoByUserId($userId);
		$borrInfo			=	$this->getBorrowerInfoByUserId($userId);
		if(isset($borrInfo) && is_object($borrInfo)) {
			$moneymatchSettings = 	$this->getMailSettingsDetail();
			$slug_name			=	"change_password_borrower";
		
			$fields 			= array(
											'[borrower_contact_person]',
											'[application_name]');
			$replace_array 		= array();
			$replace_array 		= 	array( 
											$borrInfo->contact_person,
											$moneymatchSettings[0]->application_name);
			$this->sendMailByModule($slug_name,$borUserInfo->email,$fields,$replace_array);
		}
	
	}
	
	public function changePassword_sendMailToSystemUser($userId,$password) {
	
		$userInfo		=	$this->getUserInfoByUserId($userId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$slug_name			=	"change_password_admin";
		$fields 			= array(
									'[username]',
									'[application_name]');
		$replace_array 		= array();
		$replace_array 		= 	array( 
										$userInfo->username, 
										$password,
										$moneymatchSettings[0]->application_name);
		$this->sendMailByModule($slug_name,$userInfo->email,$fields,$replace_array);
	
	}
	
	
	public function changePassword_copyToAdmin($userId,$password) {
	
		$userInfo		=	$this->getUserInfoByUserId($userId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$slug_name			=	"change_password_copy_admin";
		$fields 			= array(
									'[admin_email_label]',
									'[username]',
									'[application_name]');
		$replace_array 		= array();
		$replace_array 		= 	array( 
										$moneymatchSettings[0]->admin_email_label, 
										$userInfo->username, 
										$moneymatchSettings[0]->application_name);
		$this->sendMailByModule($slug_name,$moneymatchSettings[0]->admin_email,$fields,$replace_array);
	
	}
	
}
