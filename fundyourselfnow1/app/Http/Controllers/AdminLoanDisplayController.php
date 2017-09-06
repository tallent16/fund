<?php 
namespace App\Http\Controllers;
use	\App\models\AdminLoanListingModel;

class AdminLoanDisplayController extends MoneyMatchController {
	public $admindisplayorder;
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->admindisplayorder = new AdminLoanListingModel();
	}
		
	public function indexAction(){				 
			
		$withArry	=	array(	"admindisplayorder" => $this->admindisplayorder, 								
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-loandisplayorder')
				->with($withArry); 				
	
	}
	public function ajaxEditLoanDisplayOrderList(){			
		
		if(isset($_POST['action'])){		
			if($_POST['action'] == "edit") {	
							
				$row =  $this->admindisplayorder->EditLoanDisplayOrderList($_POST);
				return json_encode(array("row"=>$row));
			}
		}else{
				$rows = $this->admindisplayorder->viewLoanDisplayOrderList();				
				return json_encode(array("data"=>$rows));		
		}
	}
}
