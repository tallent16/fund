<?php namespace App\Http\Controllers;
use Request;
class BackerMarketPlaceController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		//~ $this->borrowerMyLoanInfoModel	=	new BorrowerMyLoanInfoModel;
	}
	
	public function indexAction() {
		
		$tokens			=	array();
		$tokens["MLN"]	=	[	"Melon, MLN","0.02134021","7.08 BTC","0.02231890",
								"0.01962229","-4.39%","0.02179553","0.02279553"];
		$tokens["TIME"]	=	[	"Time, TIME","0.00456517","27.76 BTC","0.00596000",
								"0.00454500","-17.17%","0.00458534","0.00454500"];
		$tokens["LTC"]	=	[	"Litecoin, LTC","0.00318517","26.71 BTC","0.00331032",
								"0.00315580","+0.79%","0.00319685","0.00319685"];
		$tokens["ETH"]	=	[	"Ethereum, ETH","0.01602764","31.36 BTC","0.01610000",
								"0.01450535","+9.94%","0.01607478","0.00317349"];

		$withArry	=	array(	"classname"=>"fa fa-file-text fa-fw",
								"tokens"=>$tokens
							);	
		return view('investor.investor-marketplace')
			->with($withArry);
	}
	
}
