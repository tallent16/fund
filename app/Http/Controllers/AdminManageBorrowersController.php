<?php 
namespace App\Http\Controllers;
use	\App\models\AdminManageBorrowersModel;
class AdminManageBorrowersController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminborModel	=	new AdminManageBorrowersModel;
	}
	
	public function indexAction(){
	$withArry	=	array(	"adminbormodel"=>$this->adminborModel,
								"classname"=>"fa fa-reply fa-fw user-icon"
							);	
							
	return view('admin.admin-manageborrowers')
			->with($withArry);
	
	}

	
}
