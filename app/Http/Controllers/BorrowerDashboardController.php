<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerDashboardModel;
use Storage;

class BorrowerDashboardController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//Additional initiate model
	public function littleMoreInit() {
		$this->borrowerDashboardModel	=	new BorrowerDashboardModel;
	}
	
	//render the borrower Dashboard page
	public function indexAction() {
		 //~ $disk	=	Storage::disk('s3');
		 //~ $disk->put('uploads/test.txt','Its working fine now from the money match');
		 //~ $filename	=	"uploads/".basename("http://52.77.34.254/uploads/borrower/1/profile/image/company.jpeg");
		 //~ $disk->put($filename
				//~ ,file_get_contents("http://52.77.34.254/uploads/borrower/1/profile/image/company.jpeg"));
		 //~ $disk->setVisibility($filename, 'public');
		 //~ // $files = Storage::allFiles($directory);
		//~ $url = $disk->getDriver()->getAdapter()->getClient()->getObjectUrl("moneymatch",
													//~ "uploads/borrower/1/loan25documents/function_getBusesInfo.sql");
		//~ $files = $disk->allFiles("uploads");
		//~ echo $url;
		//~ $files = Storage::allFiles("uploads");
		//~ foreach($files as $object)
		 //~ {
			//~ Storage::disk('s3')->put($object,file_get_contents(url($object)))  ;
			//~ Storage::disk('s3')->setVisibility($object, 'public');
		 //~ }
		//~ echo "<pre>",print_r($files),"</pre>";
		//~ die;
		$this->borrowerDashboardModel->getBorrowerDashboardDetails();
		return view('borrower.borrower-dashboard')
					->with("BorDashMod",$this->borrowerDashboardModel)
					->with("classname","fa fa-gear fa-fw user-icon"); 
	}

}
