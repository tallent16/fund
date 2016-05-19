<?php 
namespace App\Http\Controllers;
use	\App\models\AdminRolesModel;
use Request;
class AdminRolesController extends MoneyMatchController {
	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminRolesModel = new AdminRolesModel();
	}
		
	public function indexAction(){
		
		$this->adminRolesModel->getRoleList();
		$withArry	=	array(	"adminRolesModel" => $this->adminRolesModel, 
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-roles')
				->with($withArry); 
	
	}
		
	public function roleUsersAction($role_id){
		
		$this->adminRolesModel->getRoleUsers($role_id);
		$withArry	=	array(	"adminRolesModel" => $this->adminRolesModel, 
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-role-users')
				->with($withArry); 
	
	}
		
	public function rolePermissionsAction($trantype,$role_id){
		
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$this->adminRolesModel->processPermission($postArray);
			if($trantype	==	"add")
				return redirect()->to('admin/roles');
		}
		
		$this->adminRolesModel->getRolePermissionDetails($role_id);
		$withArry	=	array(	"adminRolesModel" 	=>	$this->adminRolesModel, 
								"trantype"			=>	$trantype,
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-role-permissions')
				->with($withArry); 
	
	}
	
	//checks the Role Name exists or not
	public function CheckRoleNameavailability(Request $request) {
		
		$role_name	=	Request::input('role_name');
	
		if($this->adminRolesModel->CheckRoleName($role_name))
			echo "2" ;
		else
			echo "1";
	}
}
