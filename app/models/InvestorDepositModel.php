<?php namespace App\models;
class InvestorDepositModel extends TranWrapper {
	
	public $depositDate				= "";
	public $transamount				= "";
	public $transReference			= "";
	public $remarks					= "";	
	public $invested_amount			= "";
	public $reserved_investment	 	= "";
	public $available_bal			= "";
	public $current_inverstor_id 	= "";
	
	public function getdepositdetails($postArray) {
	
	$current_inverstor_id		=	 $this->getCurrentInvestorID();
	
	$depositdatesql				= 	"SELECT CURDATE()";
	$this->depositDate			= 	$this->dbFetchOne($depositdatesql);
				
	$invested_amountsql 		= 	"select sum(principal_amount) 
									from 	investor_repayment_schedule
									where	status != 3 and investor_id = {$current_inverstor_id}";
	
	$this->invested_amount		=	$this->dbFetchOne($invested_amountsql);		
		
	$reserved_for_investmentsql = 	"select sum(bid_amount) from loan_bids 
											where bid_status = 1 ";
											
	$this->reserved_investment	= 	$this->dbFetchOne($reserved_for_investmentsql);	
	
	
/*	$available_balancesql 		= 	"select sum(if(status = 2, trans_amount, -1 * trans_amount) -
									{$this->invested_amount} - {$this->reserved_investment})
									from investor_bank_transactions 
									where investor_id = {$current_inverstor_id}";								
									
	$this->available_bal		= 	$this->dbFetchOne($available_balancesql);								
	print_r($available_balancesql);			*/
	
	// Values expected from the request		
	$this->depositDate 			= 	$this->getDbDateFormat($postArray["depositdate"]);
	$this->transamount			=	$postArray["deposit_amount"];		
	$this->transReference		=	$postArray["trans_reference"];
	$this->remarks				=	$postArray["remarks"];		
	$this->investid				=	"";
	$status			=	1; // Hardcoded to signify Unverified 
			
	// For the Payments Table	
	$currency				=	'SGD'; 
	//	currency: SGD (hardcode)		
	//  Status: 1 (approved --> Hardcode)

	$depositpaymentInsert_data	=	array(
								'trans_date' =>$this->depositDate,
								'trans_type' => 3,							
								'trans_amount' => $this->transamount,
								'currency' => $currency,
								'trans_reference_number' => $this->transReference,
								'status' => $status,
								'remarks' => $this->remarks);

	$paymentId 			=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);

	$depositInsert_data	=	array(								
								'investor_id' => $this->investid,									
								'trans_type' => 1,	 						
								'trans_date' => $this->depositDate,
								'trans_amount' => $this->transamount,
								'trans_currency' => $currency,
								'payment_id' => $paymentId ,
								'status' => $status);			
		
	$this->dbInsert("investor_bank_transactions", $depositInsert_data, 0);		
	}
	
}

?>
