<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
	  
class AdminDisburseLoanModel extends TranWrapper {
	public	$loan_reference_number = "";
	public	$loan_sanctioned_amount = 0;
	public	$loan_process_date = "";
	public  $fixed_fees_levied = 0;
	public	$fees_percent_levied = 0;
	public  $total_fees_levied = 0;
	public	$amount_disbursed = 0;
	public	$trans_reference_number = "";
	public	$remarks = "";
	
	public	$repayment_schedule = array();
	
	public function getDisburseDetails($loan_id) {
		
		$disbDetail_sql		=	"	SELECT	loan_id,
											loan_reference_number,
											date_format(now(), '%d-%m-%Y') loan_process_date,
											loan_sanctioned_amount,
											fees_type_applicable,
											loan_fees_percent,
											loan_fixed_fees,
											loan_fees_minimum_applicable
									FROM	loans,
											system_settings
									WHERE	loan_id = :loan_id ";
		
		$disbDetail_rs		=	$this->dbFetchWithParam($disbDetail_sql, ["loan_id" => $loan_id]);
		
		if ($disbDetail_rs) {
			foreach ($disbDetail_rs as $disbDetail_row) {
				foreach ($disbDetail_row as $colname => $value) {
					$this->{$colname} = $value;
				}
			}
		} else {
			return -1;
		}
		
	}
	
	public function processDropDowns() {
		
		
	}

}
