<?php namespace App\models;
use Hash;
class AdminChangePasswordModel extends TranWrapper {
	
	
	public	$user_id			=	0;
	public	$userType			=	0;
	public	$selected_user_name	=	"";
	public	$returnBackUrl		=	"";
	public	$returnRouteName	=	"";
	
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
		return $userId;
	}
}
