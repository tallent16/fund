<?php
namespace MoneyMatch\Helpers;
use DB;
use Auth;
class AdminHelper {
	
	public static function checkUserRoles() {
		
		$userID			=	Auth::user()->user_id;
		$pdoDB 			=	DB::connection()->getPdo();
		$sqlStatement	=	"	SELECT 	count(*) cnt 
								FROM 	role_user
								WHERE	user_id	=	{$userID}";
		
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$cnt = $query->fetchColumn();
		return	$cnt;
	}
}
?>
