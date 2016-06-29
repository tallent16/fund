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
		$usertype	= $postArray['usertype'];	
		
		if($usertype == "Borrower"){
			$id		= $postArray['bor_id'];	
			$bankid	= $postArray['bor_bankid'];	
		}else{
			$id		= $postArray['inv_id'];	
			$bankid	= $postArray['inv_bankid'];				
		}
		
		$result 	= $this->adminChangeBankModel->updateborrowerinvestorbankapprove($postArray);
		if($result) {			
			
			if($usertype == "Borrower"){
				$successTxt	=	$this->adminChangeBankModel->successTxt;	
				return redirect()->route('admin.approve', array(		'usertype'=>base64_encode($usertype),
																		'borrower_id'=>base64_encode($id),
																		'borrower_bankid'=>base64_encode($bankid)
																	)
											)
									->with('success',$successTxt);
			}else{
				$successTxt	=	$this->adminChangeBankModel->successTxt;	
				return redirect()->route('admin.approve', array(		'usertype'=>base64_encode($usertype),
																		'investor_id'=>base64_encode($id),
																		'investor_bankid'=>base64_encode($bankid)
																	)
											)
									->with('success',$successTxt);				
				
				}
				
		}else{
			
			$successTxt =	"Something went wrong";			
			if($usertype == "Borrower"){
				return redirect()->route('admin.approve', array(		'usertype'=>base64_encode($usertype),
																		'borrower_id'=>base64_encode($id),
																		'borrower_bankid'=>base64_encode($bankid)
																	)
											)
									->with('success',$successTxt);
			}else{
				return redirect()->route('admin.approve', array(		'usertype'=>base64_encode($usertype),
																		'investor_id'=>base64_encode($id),
																		'investor_bankid'=>base64_encode($bankid)
																	)
											)
									->with('success',$successTxt);				
				
				}			
						
		}
	}
	public function rejectBankAction(){
		$postArray		=	Request::all();						
		$result 		= $this->adminChangeBankModel->deleteborrowerinvestorbankrecord($postArray);
			
		if($result) {
			$successTxt	=	$this->adminChangeBankModel->successTxt;
			return redirect()->route('admin.changeofbank')
								->with('success',$successTxt);	
		}else{						
			$successTxt =	"Something went wrong";	
			return redirect()->route('admin.changeofbank')
								->with('failure',$successTxt);		
						
		}
	}	
}
