<?php namespace App\models;

use Config;
class AdminRolesModel extends TranWrapper {
	
	public 	$roleList				=	array();
	public 	$roleUsersList			=	array();
	public 	$allPermissionList		=	array();
	public 	$roleByPermissionList	=	array();
	public 	$roleName				=	"";
	public	$filterRoleList			=	array();
	public	$moduleList				=	array();
	public 	$filterRoleValue		= 	"";
	
	public function getRoleList() {
	
		
		$rolelist_sql		=	"	SELECT	name,
											id,
											system
									FROM	roles
									order by id";

		
		$this->roleList	=	$this->dbFetchAll($rolelist_sql);

	}
	
	public function getRoleUsers($role_id) {
		
		
		$this->roleName				=	$this->getRoleNameById($role_id);
		$roleUserslist_sql			=	"	SELECT	users.username,
													users.email,
													users.firstname,
													users.lastname
											FROM	role_user,
													users
											WHERE	role_user.role_id	=	{$role_id}
											AND		users.user_id	=	role_user.user_id";

		
		$this->roleUsersList	=	$this->dbFetchAll($roleUserslist_sql);

	}
	public function getRolePermissionDetails($role_id) {
		
		$this->processDropDowns();
		$this->getAllPermissions($role_id);
	}
	
	public function getAllPermissions($role_id) {
		
		$this->moduleList				=	array(	1=>"Dashboard",
													2=>"Manage Borrowers",
													3=>"Manage Investors",
													4=>"Manage Loans",
													5=>"Banking",
													6=>"Reports",
													7=>"Manage Users",
													8=>"Manage Roles"
												);
		
		$this->filterRoleValue			=	$role_id;
		$allpermissionlist_sql			=	"	SELECT	id,
														name,
														slug,
														model,
														module_id,
														IF(rolePermission.permission_id	is null,'','checked') isChecked
												FROM	permissions
												LEFT JOIN	(
																SELECT	permission_id,
																		role_id
																FROM	permission_role
																WHERE	role_id	=	{$role_id}
															) rolePermission
												ON	rolePermission.permission_id = permissions.id
											order by id";
	
		
		$this->allPermissionList		=	$this->dbFetchAll($allpermissionlist_sql);

	}
	
	public function processDropDowns() {
				
		$filterSql		=	"	SELECT	id,
										name
								FROM	roles";
							
		$filter_rs		= 	$this->dbFetchAll($filterSql);
		if($filter_rs	==	"") {
			$cnt	=	0;
		}else {
			$cnt	=	count($filter_rs);
		}
		if($cnt	> 0) {
			foreach($filter_rs as $filter_row) {

				$id 						= 	$filter_row->id;
				$Value 						= 	$filter_row->name;
				$this->filterRoleList[$id] 	=	$Value;
			}
		}
	} // End process_dropdown
	
	public function processPermission($postArray) {
		
		$transType	=	$postArray['trantype'];
		
		if($transType	==	"add") {
			return $this->insertRolePermissionInfo($postArray);
		}else{
			$roleID		=	$postArray['role_filter'];
			return $this->updatePermissionInfo($postArray,$roleID);
		}
	}
	
	public function insertRolePermissionInfo($postArray) {
		
			$role_id	=	$this->createNewRole($postArray);
			
			return $this->updatePermissionInfo($postArray,$role_id);
	}
	
	public function createNewRole($postArray) {
		
			$dataArray = array(	'name'			=>  $postArray['role_name'],
								'slug'			=> 	"system.".str_slug($postArray['role_name'],""),
								'created_at'	=> 	date("Y-m-d h:i:sa"),
								'updated_at' 	=> 	date("Y-m-d h:i:sa")
							);
							
			$roleID =  $this->dbInsert('roles', $dataArray, true);
			if ($roleID < 0) {
				return -1;
			}
			return	$roleID;
	}
	
	public function updatePermissionInfo($postArray,$roleID) {
		
		foreach($postArray['permission_ids'] as $permissionRow) {
			if(!isset($postArray['set_permission_'.$permissionRow])) {
				
				$dataArray = array(	'permission_id'	=>  $permissionRow,
									'role_id'		=> 	$roleID,
									'created_at'	=> 	date("Y-m-d h:i:sa"),
									'updated_at' 	=> 	date("Y-m-d h:i:sa")
								);
								
				$this->dbInsert('permission_role', $dataArray, true);
			}
		}
		\DB::table('permission_role')
				->where('role_id',$roleID)
				->whereNotIn('permission_id',$postArray['permission_ids'])->delete();
      
		return	$roleID;
	}
}
