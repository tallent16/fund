<?php namespace App\models;
class InvestorBankModel extends TranWrapper {
	
	public $depositwithdrawdate			;
	public $transamount				= 0.00;
	public $transReference			= "";
	public $remarks					= "";	
	public $available_bal			= "";
	public $current_inverstor_id 	= "";
	
	public function getprocessdeposit() {
	
		$this->current_inverstor_id	=	 $this->getCurrentInvestorID();
		$depositdatesql				= 	"SELECT CURDATE()";
		$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);
		$this->available_bal		= 	$this->getInvestorAvailableBalanceById($this->current_inverstor_id);		
		return;
	}

	public function newdeposit($postArray) {
		
		// Values expected from the request		
		$this->transamount			=	$this->makeFloat($postArray["deposit_amount"]);
		$this->transReference		=	$postArray["deposit_trans_refer"];
		$this->remarks				=	$postArray["deposit_remarks"];		
		$this->investid				=	$postArray["current_investor_id"];
		$status						=	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED; 
		$depositdatesql				= 	"SELECT CURDATE()";
		$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);
	
		// For the Payments Table	
		$currency					=	'SGD'; 
		//	currency: SGD (hardcode)
		$depositpaymentInsert_data	=	array(
										'trans_datetime' =>$this->depositwithdrawdate,
										'trans_type' => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,						
										'trans_amount' => $this->transamount,
										'currency' => $currency,
										'trans_reference_number' => $this->transReference,
										'status' => PAYMENT_STATUS_UNVERIFIED,
										'remarks' => $this->remarks);
		$paymentId 					=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);

		$depositInsert_data			=	array(								
										'investor_id' => $this->investid,
										'trans_type' => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,	 			
										'trans_date' => $this->depositwithdrawdate,
										'trans_amount' => $this->transamount,
										'trans_currency' => $currency,
										'payment_id' => $paymentId ,
										'status' => $status);			
		
		$this->dbInsert("investor_bank_transactions", $depositInsert_data, 0);		
	}
	
	public function newwithdraw($postArray)	{
		
		// Values expected from the request	
		$this->transamount			=	$this->makeFloat($postArray["withdraw_amount"]);	
		$this->transReference		=	$postArray["withdraw_trans_refer"];
		$this->remarks				=	$postArray["withdraw_remarks"];		
		$this->investid				=	$postArray["current_investor_id"];
		$status						=	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED; // Hardcoded to signify approved 
		$depositdatesql				= 	"SELECT CURDATE()";
		$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);
	
		// For the Payments Table	
		$currency					=	'SGD'; 
		//	currency: SGD (hardcode)	

		$withdrawpaymentInsert_data	=	array(
										'trans_datetime' =>$this->depositwithdrawdate,
										'trans_type' => PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL,
										'trans_amount' => $this->transamount,
										'currency' => $currency,
										'trans_reference_number' => $this->transReference,
										'status' => PAYMENT_STATUS_UNVERIFIED,
										'remarks' => $this->remarks);
		$paymentId 					=	$this->dbInsert("payments", $withdrawpaymentInsert_data, 1);
		
		$withdrawInsert_data		=	array(								
										'investor_id' => $this->investid,									
										'trans_type' => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
										'trans_date' => $this->depositwithdrawdate,
										'trans_amount' => $this->transamount,
										'trans_currency' => $currency,
										'payment_id' => $paymentId ,
										'status' => $status);			
		
		$this->dbInsert("investor_bank_transactions", $withdrawInsert_data, 0);			
	}
}
?>
