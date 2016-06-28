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
		
		$withArry		=	array(	"adminbanklistModel" => $this->adminChangeBankModel,
								"classname"=>"fa fa-user fa-fw");
		
		return view('admin.admin-changeofbank')
							->with($withArry);
	}
	
	public function editApproveAction($usertype,$borrower_id,$borbankid){
		
		$usertype 		= base64_decode($usertype);
		$borrower_id 	= base64_decode($borrower_id);
		$borbankid 		= base64_decode($borbankid);
		
		$this->adminChangeBankModel->getborrowerinvestorbankinfo($usertype,$borrower_id,$borbankid);
		
		$withArry		=	array(	"adminbankviewModel" => $this->adminChangeBankModel,
								"classname"=>"fa fa-user fa-fw");
							
		return view('admin.admin-approvechangeofbank')
									->with($withArry);
	}
	public function updateApproveBankAction(){
		$postArray	=	Request::all();
		$result 	= $this->adminChangeBankModel->updateborrowerinvestorbankapprove($postArray);
		if($result) {
			$successTxt =	"Approved Successfully";
			return redirect()->route('admin.approve')
							->with('success',$successTxt);
		}else{
			return redirect()->route('admin.approve')
						->with('failure','Something went wrong!');	
		}
	}
	public function rejectBankAction(){
		$postArray		=	Request::all();		
		$result_reject 	= $this->adminChangeBankModel->deleteborrowerinvestorbankrecord($postArray);		
		if($result_reject) {
			//echo 'right'; echo "<pre>",print_r($result_reject),"</pre>"; die;
			$successTxt =	"Record Deleted Successfully";
			return redirect()->route('admin.changeofbank')
							->with('success',$successTxt);
		}else{
			//echo "<pre>",print_r($result_reject),"</pre>"; die;
			return redirect()->route('admin.changeofbank')
						->with('failure','Something went wrong!');	
		}
	}	
}
