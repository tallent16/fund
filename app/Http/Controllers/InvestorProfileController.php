<?php 
namespace App\Http\Controllers;
use Request;
use Auth;
use	\App\models\InvestorProfileModel;
class InvestorProfileController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//Additional initiate model
	public function littleMoreInit() {
		$this->investorProfileModel	=	new InvestorProfileModel;
	}
	
	//render the borrower Dashboard page
	public function indexAction() {		
		
		$submitted	=	false;
		Session::forget("success");
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->investorProfileModel->processProfile($postArray);
			$submitted	=	true;
			Session::put("success",$this->borrowerProfileModel->successTxt);
		}
		$this->investorProfileModel->getInvestorDetails();

		$withArry		=	array(	"InvPrfMod"=>$this->investorProfileModel,
									"classname"=>"fa fa-user fa-fw",
									"submitted"=>$submitted	,
									"InvBorPrf"=>$this->investorProfileModel
									
								);
		return view('investor.investor-profile')					
					->with($withArry); 
	}
	//render the borrower Dashboard page
	public function ajaxCheckFieldExistsAction() {		
		
		$postArray	=	Request::all();
		$result		=	$this->investorProfileModel->CheckFieldExists($postArray);
		if($result) {
			echo "2";
			return;
		}else{
			echo "1";
			return;
		}
	}
	
	public function updateAction(){
		$postArray	=	Request::all();
		$inv_id = $postArray['investor_id'];
		\Session::put('success','mobile number updated successfully');
		$this->investorProfileModel->updateMobileNumber($inv_id,$postArray);		
		return redirect()->route('investor.profile')->with('success','mobile number updated successfully');
	}
	
	
	public function downloadBankAction($profile_id,$bank_id) {
	
		
		$sourceId 		=	explode("_",$profile_id);
		
		if( (Auth::user()->usertype	==	USER_TYPE_INVESTOR) 
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) ) {
			
			if((Auth::user()->user_id	==	$this->investorProfileModel->getInvestorIdByUserInfo($sourceId[0])->user_id)
				|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) ) { 
					
					$fieldName		=	"bank_statement_url";
					$inv_dir_rs		=	$this->investorProfileModel->getBankAttachmentById("investor_banks",
																				$fieldName," investor_bankid = {$bank_id}");
					
					$attachUrl		=	$inv_dir_rs->$fieldName;
					$attachName 	= 	basename($attachUrl);
					
					header('Content-Disposition: attachment; filename=' .$attachName);
					header('Content-Type: application/force-download');
					header('Content-Type: application/octet-stream');
					header('Content-Type: application/download');
					header('Content-Description: File Transfer');
					echo file_get_contents($attachUrl);
			}
		}
	}

}
