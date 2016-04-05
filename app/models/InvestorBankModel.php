<?php namespace App\models;
class InvestorBankModel extends TranWrapper {
	
	public $depositwithdrawdate			;
	public $transamount				= "";
	public $transReference			= "";
	public $remarks					= "";	
	public $available_bal			= "";
	public $current_inverstor_id 	= "";
	
	public function getprocessdeposit() {
	
	$this->current_inverstor_id	=	 $this->getCurrentInvestorID();
	$depositdatesql				= 	"SELECT CURDATE()";
	$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);

	$available_balancesql 		= 	"select  sum(plus_or_minus * trans_amount)  
									from (
										select	1 plus_or_minus, 
												'repayments',
												payment_schedule_amount + ifnull(penalty_amount,0) trans_amount, 
												payment_date trans_date
										from 	investor_repayment_schedule
										where	status = 3 and investor_id = {$this->current_inverstor_id}
									union
									select 	-1 plus_or_minus,
											'bids',
											 bid_amount,
											 bid_datetime
										from 	loan_bids 
										where 	bid_status = 2 
									and	investor_id = {$this->current_inverstor_id}
									union
									select 	 if (trans_type = 1, 1, -1),
											 if (trans_type = 2, 'withdrawals', 'deposits'),
												trans_amount,
												trans_date
										from 	investor_bank_transactions 
										where 	investor_id = {$this->current_inverstor_id} ) inv_trans
									order by trans_date";		
										
	$this->available_bal		= 	$this->dbFetchOne($available_balancesql);		
	return;
	}

	public function newdeposit($postArray) {
		
	// Values expected from the request		
	//$this->depositdate 			= 	$this->getDbDateFormat($postArray["deposit_date"]);
	$this->transamount			=	$postArray["deposit_amount"];		
	$this->transReference		=	$postArray["deposit_trans_refer"];
	$this->remarks				=	$postArray["deposit_remarks"];		
	$this->investid				=	$postArray["current_investor_id"];
	$status						=	INVESTOR_BANK_TRANSCATION_STATUS; // Hardcoded to signify approved
	$depositdatesql				= 	"SELECT CURDATE()";
	$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);
	
	// For the Payments Table	
	$currency					=	'SGD'; 
	//	currency: SGD (hardcode)

	$depositpaymentInsert_data	=	array(
									'trans_date' =>$this->depositwithdrawdate,
									'trans_type' => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,							
									'trans_amount' => $this->transamount,
									'currency' => $currency,
									'trans_reference_number' => $this->transReference,
									'status' => PAYMENT_STATUS_UNVERIFIED,
									'remarks' => $this->remarks);

	$paymentId 					=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);

	$depositInsert_data			=	array(								
									'investor_id' => $this->investid,									
									'trans_type' => INVESTOR_BANK_TRANSCATION_DEPOSIT,	 						
									'trans_date' => $this->depositwithdrawdate,
									'trans_amount' => $this->transamount,
									'trans_currency' => $currency,
									'payment_id' => $paymentId ,
									'status' => $status);			
		
	$this->dbInsert("investor_bank_transactions", $depositInsert_data, 0);		
	}
	
	public function newwithdraw($postArray)	{
		
	// Values expected from the request	
	$this->transamount			=	$postArray["withdraw_amount"];	
	$this->transReference		=	$postArray["withdraw_trans_refer"];
	$this->remarks				=	$postArray["withdraw_remarks"];		
	$this->investid				=	$postArray["current_investor_id"];
	$status						=	INVESTOR_BANK_TRANSCATION_STATUS; // Hardcoded to signify approved 
	$depositdatesql				= 	"SELECT CURDATE()";
	$this->depositwithdrawdate	= 	$this->dbFetchOne($depositdatesql);
	
	// For the Payments Table	
	$currency					=	'SGD'; 
	//	currency: SGD (hardcode)	

	$withdrawpaymentInsert_data	=	array(
									'trans_date' =>$this->depositwithdrawdate,
									'trans_type' => PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL,							
									'trans_amount' => $this->transamount,
									'currency' => $currency,
									'trans_reference_number' => $this->transReference,
									'status' => PAYMENT_STATUS_UNVERIFIED,
									'remarks' => $this->remarks);

	$paymentId 					=	$this->dbInsert("payments", $withdrawpaymentInsert_data, 1);

	$withdrawInsert_data		=	array(								
									'investor_id' => $this->investid,									
									'trans_type' => INVESTOR_BANK_TRANSCATION_WITHDRAWAL,	 						
									'trans_date' => $this->depositwithdrawdate,
									'trans_amount' => $this->transamount,
									'trans_currency' => $currency,
									'payment_id' => $paymentId ,
									'status' => $status);			
		
	$this->dbInsert("investor_bank_transactions", $withdrawInsert_data, 0);			
	}
}
?>
