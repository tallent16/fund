<?php
namespace MoneyMatch\Helpers;
use DB;
use Auth;
class BorrowerHelper {
	
	public static function checkProfileStatus() {
		
		$userID			=	Auth::user()->user_id;
		$pdoDB 			=	DB::connection()->getPdo();
		$sqlStatement	=	"	SELECT 	COUNT(*) cnt
								FROM 	borrowers 
								WHERE 	user_id = '".$userID."'";
		
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$cnt = $query->fetchColumn();
		if($cnt	>	0) {
			$sqlStatement1	=	"	SELECT 	status
									FROM 	borrowers
									WHERE	user_id	=	{$userID}";
	
			$query = $pdoDB->prepare($sqlStatement1);
			$query->execute();
			$profileStatus = $query->fetchColumn();
			return $profileStatus;
		}else{
			return 0;	
		}
		
	}
	public static function getBorrowerLoanAllowingStatus() {
		
		$userID			=	Auth::user()->user_id;
		$pdoDB 			=	DB::connection()->getPdo();
		$sqlStatement	=	"	SELECT 	borrower_id
								FROM 	borrowers 
								WHERE 	user_id = '".$userID."'";
		
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$borrower_id = $query->fetchColumn();
		if($borrower_id	>	0) {
			$sqlStatement1	=	"	SELECT 	business_organisations.bo_borrowing_allowed
									FROM 	business_organisations
									WHERE	business_organisations.bo_id	=
											(
												SELECT 	bo_id
												FROM 	borrowers
												WHERE	borrower_id	=	{$borrower_id}
											)";
	
			$query = $pdoDB->prepare($sqlStatement1);
			$query->execute();
			$borrowing_allowed = $query->fetchColumn();
			return $borrowing_allowed;
		}else{
			return 0;	
		}
		
	}
}
?>
