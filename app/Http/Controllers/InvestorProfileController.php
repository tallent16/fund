<?php 
namespace App\Http\Controllers;
use Request;
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
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->investorProfileModel->processProfile($postArray);
			$submitted	=	true;
		}
		
		$this->investorProfileModel->getInvestorDetails();

		$withArry		=	array(	"InvPrfMod"=>$this->investorProfileModel,
									"classname"=>"fa fa-usd fa-fw user-icon",
									"submitted"=>$submitted
								);
		return view('investor.investor-profile')					
					->with($withArry); 
	}

}
