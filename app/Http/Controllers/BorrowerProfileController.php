<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerProfileModel;
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
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->borrowerProfileModel->processProfile($postArray);
			$submitted	=	true;
		}
		
		$this->borrowerProfileModel->getBorrowerDetails();
		
		$borrList				=	array('submitted');
		return view('borrower.borrower-profile')
					->with(compact($borrList))
					->with("modelBorPrf",$this->borrowerProfileModel);
	}

}
