<?php 
namespace App\Http\Controllers;
use	\App\models\AdminChangeofBankModel;
use Request;
class AdminChangeofBankController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminChangeBankModel = new AdminChangeofBankModel();
	}
		
	public function indexAction(){
		
		$this->adminChangeBankModel->getborrowerinvestorbanks();
		
		$withArry	=	array(	"adminbanklistModel" => $this->adminChangeBankModel,
								"classname"=>"fa fa-user fa-fw");
							
		
		return view('admin.admin-changeofbank')
							->with($withArry);
	}
}
