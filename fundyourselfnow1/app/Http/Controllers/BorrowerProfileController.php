<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerProfileModel;
use Auth;
use Session;
class BorrowerProfileController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//Additional initiate model
	public function littleMoreInit() {
		$this->borrowerProfileModel	=	new BorrowerProfileModel;
	}
	
	//render the borrower profiile page
	public function indexAction() {
	
		$submitted	=	false;
		$activeTab	=	"#company_info";
		Session::forget("success");
		if (Request::isMethod('post')) {
			if(Request::get("isSaveButton")	==	"financial_doc") {
				$this->updateFinancialDocAction();
				
			}else{
			$postArray		=	Request::all();
			$result			=	$this->borrowerProfileModel->processProfile($postArray);
			$activeTab		=	$postArray['active_tab'];	
			
			}
			Session::put("success",$this->borrowerProfileModel->successTxt);
		}
		
		$this->borrowerProfileModel->getBorrowerDetails(); 
		/*echo $activeTab;
	       echo '<pre>';print_r($this->borrowerProfileModel);die;*/
		
		$withArry		=	array(	"modelBorPrf"=>$this->borrowerProfileModel,
									"classname"=>"fa fa-user fa-fw",
									"submitted"=>$submitted ,
									"InvBorPrf"=>$this->borrowerProfileModel,
									"activeTab"=>$activeTab
								);
		return view('borrower.borrower-profile')
					->with($withArry);
	}
	
	public function updateFinancialDocAction(){
		
		$postArray	=	Request::all();
		$bor_id 	= 	$postArray['borrower_id'];
		$this->borrowerProfileModel->updateFinancialDoc($bor_id,$postArray);		
	}
	
	public function downloadAction($profile_id,$fieldno) {
	
		$sourceId 		=	explode("_",$profile_id);
		if( (Auth::user()->usertype	==	USER_TYPE_BORROWER) || (Auth::user()->usertype	==	USER_TYPE_INVESTOR)
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN)) {
			if( (Auth::user()->user_id	==	$this->borrowerProfileModel->getBorrowerIdByUserInfo($sourceId[0])->user_id)
				|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) || (Auth::user()->usertype	==	USER_TYPE_INVESTOR) ) { 
				$fieldArray	=	array(
										1=>"company_image",
										2=>"company_image_thumbnail",
										3=>"acra_profile_doc_url",
										4=>"moa_doc_url",
										5=>"financial_doc_url"
									);
					
				// download borrower profile ACRA and MAOA file
					$fieldName		=	$fieldArray[$fieldno];
					
					$bor_pro_rs		=	$this->borrowerProfileModel->getBorrowerProfileAllAttachments($sourceId[0]);
					//~ echo "<pre>",print_r($bor_pro_rs),"</pre>"; die;
					$attachUrl		=	$bor_pro_rs->$fieldName;
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
	
	public function downloadDirAction($profile_id,$dir_id,$type) {
	
		$sourceId 		=	explode("_",$profile_id);
		if( (Auth::user()->usertype	==	USER_TYPE_BORROWER) 
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN)) {
			if( (Auth::user()->user_id	==	$this->borrowerProfileModel->getBorrowerIdByUserInfo($sourceId[0])->user_id) 
				|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) )  {
					
					$bor_dir_rs		=	$this->borrowerProfileModel->getBorrowerDirAttachmentById($dir_id);
					$fieldName		=	"identity_card_".$type;
					$attachUrl		=	$bor_dir_rs->$fieldName;
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
	
	public function downloadBankAction($profile_id,$bank_id) {
	
		
		$sourceId 		=	explode("_",$profile_id);
		
		if( (Auth::user()->usertype	==	USER_TYPE_BORROWER) 
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) ) {
			
			if((Auth::user()->user_id	==	$this->borrowerProfileModel->getBorrowerIdByUserInfo($sourceId[0])->user_id)
				|| (Auth::user()->usertype	==	USER_TYPE_ADMIN) ) { 
					
					$fieldName		=	"bank_statement_url";
					$bor_dir_rs		=	$this->borrowerProfileModel->getBankAttachmentById("borrower_banks",
																				$fieldName," borrower_bankid = {$bank_id}");
					
					$attachUrl		=	$bor_dir_rs->$fieldName;
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
