<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class AdminManageBorrowersModel extends TranWrapper {
	
	public	$borrowerListInfo	=	array();
	
	public function getBorrowerDetails() {
		$this->getBorrowerListInfo();
	}
	
	public function getBorrowerListInfo() {
	
		$borlist_sql			= "	SELECT 	users.email, 
											borrowers.business_name, 
											borrowers.contact_person, 
											borrowers.industry, 
											(	SELECT 	COUNT(loans.loan_id)
												FROM 	loans 
												WHERE 	loans.status IN (:approved, :closed,:disbursed,:repaid)
												AND 	loans.borrower_id = lns.borrower_id
											) active_loan, 
											(	SELECT 	ROUND(sum(principal_component),2)
												FROM 	borrower_repayment_schedule 
												WHERE 	borrower_repayment_schedule.loan_id = lns.loan_id 
												AND		repayment_status != :repaidStatus 
												AND 	borrowers.borrower_id = borrower_repayment_schedule.borrower_id 
											) tot_bal_outstanding, 
											borrowers.status
									FROM 	borrowers, 
											loans lns, 
											users 
									WHERE 	borrowers.borrower_id = lns.borrower_id 
									AND 	borrowers.user_id = users.user_id 
									GROUP BY	borrowers.borrower_id";
		$argArray		=	[
							"approved" => LOAN_STATUS_APPROVED,
							"closed" => LOAN_STATUS_CLOSED_FOR_BIDS,
							"disbursed" => LOAN_STATUS_DISBURSED,
							"repaid" 	=> LOAN_STATUS_LOAN_REPAID,
							"repaidStatus" => BORROWER_REPAYMENT_STATUS_PAID
							];
							
		$borlist_rs		= 	$this->dbFetchWithParam($borlist_sql,$argArray);
		
		if ($borlist_rs) {
			foreach ($borlist_rs as $borRow) {
				$newrow = count($this->borrowerListInfo);
				$newrow ++;
				foreach ($borRow as $colname => $colvalue) {
					$this->borrowerListInfo[$newrow][$colname] = $colvalue;
				}
			}
		}
		return	$borlist_rs;
	}
}
