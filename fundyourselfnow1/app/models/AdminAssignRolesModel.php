<?php namespace App\models;

use Config;
class AdminAssignRolesModel extends TranWrapper {
	
	public 	$roleList				=	array();
	public 	$usersList				=	array();
	public 	$filterUserValue		= 	"";
	
	public function getAssignRoleDetails($user_id) {
		$this->getUserRoleList($user_id);
		$this->processDropDowns();
	}
	
	public function getUserRoleList($user_id) {
		
		$this->filterUserValue			=	$user_id;
		$allrolelist_sql				=	"	SELECT	id,
														name,
														IF(assignedRoles.role_id	is null,'','checked') isChecked
												FROM	roles
												LEFT JOIN	(
																SELECT	role_id
																FROM	role_user
																WHERE	user_id	=	{$user_id}
															) assignedRoles
												ON	assignedRoles.role_id = roles.id
											order by id";
	
		
		$this->roleList		=	$this->dbFetchAll($allrolelist_sql);

	}
	
	public function processDropDowns() {
				
		$filterSql		=	"	SELECT	user_id,
										username
								FROM	users
								WHERE	usertype = :usertype_param";
							
		$filter_rs		= 	$this->dbFetchWithParam($filterSql,['usertype_param' => USER_TYPE_ADMIN]);
		if($filter_rs	==	"") {
			$cnt	=	0;
		}else {
			$cnt	=	count($filter_rs);
		}
		if($cnt	> 0) {
			foreach($filter_rs as $filter_row) {

				$id 						= 	$filter_row->user_id;
				$Value 						= 	$filter_row->username;
				$this->usersList[$id] 	=	$Value;
			}
		}
	} // End process_dropdown
	
	public function saveUserRoles($postArray) {
		
		$userID	=	$postArray['user_id'];
		
		foreach($postArray['role_ids'] as $permissionRow) {
			if(!isset($postArray['set_role_'.$permissionRow])) {
				
				$dataArray = array(	'role_id'		=>  $permissionRow,
									'user_id'		=> 	$userID,
									'created_at'	=> 	date("Y-m-d h:i:sa"),
									'updated_at' 	=> 	date("Y-m-d h:i:sa")
								);
								
				$roleUserID =  $this->dbInsert('role_user', $dataArray, true);
				if ($roleUserID < 0) {
					return -1;
				}
			}
		}
		$where	=	["user_id" => 	$userID,
						 "whereNotIn" =>	["column" => 'role_id',
											 "valArr" => $postArray['role_ids']]];
		$this->dbDelete('role_user',$where);
		return	$userID;
	}
	
}
