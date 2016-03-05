<?php 
namespace App\models;
use Mail;
use Auth;

class TranWrapper extends MoneyMatchModel {

	public function CheckUserName($userName)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	username = '".$userName."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckExistingUserName($userName,$id)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	username = '".$userName."' 
					AND 	user_id <>".$id;
				
		$cnt 	= 	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckUserEmail($userEmail) {
			
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	email = '".$userEmail."'";
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckExistingUserEmail($userEmail,$id) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	email = '".$userEmail."' 
					AND 	user_id <>".$id;
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function sendMail($postArray) {
		
			$email		=	$postArray['email'];
			$subject	=	$postArray['subject'];
			
			\Mail::send('emails.confirmation', $postArray, function($message) use ($email,$subject) {
				
				$message->to($email)->subject($subject);
			});
	}
	
	public function checkActivationCode($code) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	activation = '".$code."'";
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function checkCodeStatus($code) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	activation = '".$code."' 
					AND 	(status = 0 OR status is NULL)";
				
		$cnt 	= 	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function updateCodeStatus($code) {
	
		$whereArry	=	array("activation" =>"{$code}");
		$this->dbUpdate('users', array('status' => 1), $whereArry);
	}
	
	public function getCurrentuserID() {
		
		return	Auth::user()->user_id;
	}
	
	public function getCurrentBorrowerID() {
		
		$user_id	=	Auth::user()->user_id;
		
		$sql= "	SELECT 	borrower_id
				FROM 	borrowers 
				WHERE 	user_id = '".$user_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$borrower_id = $result[0]->borrower_id;
		}else{
			$borrower_id = 0;
		}
		return $borrower_id;
	}
	
	
	function getBusinessOrganisationList() {
		
		$bus_orgArry	=	array();	
		$busorg_sql 	= "SELECT	bo_id,
									bo_name,
									bo_borrowing_allowed
							FROM	business_organisations  ";
		
		
		$busorg_rs		=	$this->dbFetchAll($busorg_sql);
		$i				=	0;	
		foreach($busorg_rs as $busorgOpt){
			$bus_orgArry[$i]['bo_id']					=	$busorgOpt->bo_id;
			$bus_orgArry[$i]['bo_name']					=	$busorgOpt->bo_name;
			$bus_orgArry[$i]['bo_borrowing_allowed']	=	$busorgOpt->bo_borrowing_allowed;
			$i++;
		}
		return $bus_orgArry;
	}
	
}
