<?php namespace App\models;
use Log;
use DB;

class AdminNotificationsModel extends TranWrapper { 
	
	public function getReceipients($userType='') {  
			$receipientSql	=	"SELECT user_id id,concat(firstname,' ',lastname) name FROM users"; 
			
			if(!empty($userType)){
				$receipientSql.= " WHERE usertype=".$userType;
			}
			$receipientSql.= " ORDER BY name";
			$result				= 	$this->dbFetchAll($receipientSql);	
			return $result;
	}
	
	public function addNotification($dataArray) {
			$id 			= 	DB::table('notifications')->insertGetId($dataArray);
			return $id;
	}
	 
	public function addNotificationUsers($dataArray) {
		return $this->dbInsert("notification_users",$dataArray,2); 
	}
	 
	
}
