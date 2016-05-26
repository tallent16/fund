<?php
namespace MoneyMatch\Helpers;
use DB;
use Auth;
class InvestorHelper {
	
	public static function available_balance() {
		
		$userID			=	Auth::user()->user_id;
		$pdoDB 			=	DB::connection()->getPdo();
		$sqlStatement	=	"	SELECT 	count(*) cnt 
								FROM 	investors
								WHERE	user_id	=	{$userID}";
		
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$cnt = $query->fetchColumn();
		if($cnt	>	0) {
			$sqlStatement1	=	"	SELECT 	IFNULL(ROUND(available_balance,2),0) available_balance
									FROM 	investors
									WHERE	user_id	=	{$userID}";
	
			$query = $pdoDB->prepare($sqlStatement1);
			$query->execute();
			$available_balance = $query->fetchColumn();
			return $available_balance;
		}else{
			return 0;	
		}
		
	}
	
	public static function checkProfileStatus() {
		
		$userID			=	Auth::user()->user_id;
		$pdoDB 			=	DB::connection()->getPdo();
		$sqlStatement	=	"	SELECT 	COUNT(*) cnt
								FROM 	investors 
								WHERE 	user_id = '".$userID."'";
		
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$cnt = $query->fetchColumn();
		if($cnt	>	0) {
			$sqlStatement1	=	"	SELECT 	status
									FROM 	investors
									WHERE	user_id	=	{$userID}";
	
			$query = $pdoDB->prepare($sqlStatement1);
			$query->execute();
			$profileStatus = $query->fetchColumn();
			return $profileStatus;
		}else{
			return 0;	
		}
		
	}
}
?>
