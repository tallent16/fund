<?php namespace App\models;
class AdminLoanDocumentsModel extends TranWrapper {
	
	public $loandoc				= array();
	public $listids				= array();
	public function getLoanDocuments(){
		$doc_sql				= 	"SELECT loan_doc_id,
											slno,
											doc_name,
											is_mandatory,
											is_active
									FROM loan_doc_master";
							
		$result					=	$this->dbFetchAll($doc_sql);
		
		$this->loandoc			= 	$result;	
	}
	public function updateLoanDocuments($postArray){
		
		if (isset($postArray["loandoc"])) {
			$newRows = $postArray["loandoc"];			
			$numRows = count($newRows['loandoc_list']);			
		}else {
			$newRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$docIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {			
		
			$id			= $newRows['id'][$rowIndex];
			
			if ($id == 0) {		
				$update = false;				
			} else {
				$update = true;				
			}
			
			$slno				= $rowIndex+1;
			
			$docid				= $newRows['id'][$rowIndex];
			$docname			= $newRows['loandoc_list'][$rowIndex];			
			$ismandatory		= $newRows['is_mandatory'][$rowIndex];
			$isactive			= $newRows['is_active'][$rowIndex];
						
			// Construct the data array
			$dataArray = array(	'slno'					=> $slno,								
								'doc_name' 				=> $docname,
								'is_mandatory'			=> $ismandatory,
								'is_active'				=> $isactive
								 );				
				
			/*update/insert*/						
			if ($update) {	
				$whereArray	=	[ "loan_doc_id"	=> $id];
				$this->dbUpdate('loan_doc_master', $dataArray, $whereArray);				
				$docIds[]	=	$id;							
			} else {				
				$id	 =  $this->dbInsert('loan_doc_master', $dataArray, true);				
				$docIds[]	=	$id;				
			}			
		}
	
		/*Check before delete*/	
		
		$idArray_sql	=	"SELECT loan_doc_id 
								FROM loan_docs_submitted ";
		
		$count_id		=	$this->dbFetchAll($idArray_sql);
		
		foreach($count_id as $row){
			$this->listids[]=$row->loan_doc_id;
		}
			
		$whereId		=	implode(",", $this->listids);		
	
		$sql			=	"SELECT COUNT(*) 
							FROM	loan_doc_master
							WHERENOTIN	loan_doc_id in ({$whereId}) ";	
							
		$count			=	$this->dbFetchOne($sql);
		//echo "<pre>",print_r($count),"</pre>"; die;		
		if ($count > 0) {
			$this->errorText	=	"Loan Documents marked for deletion is already in use. Cannot delete";
			return -1;
		}else{	
		/** Loan Documents will be deleted**/		
			$where	=	[ "whereNotIn" 	=>	["column" => 'loan_doc_id',
											 "valArr" =>$docIds]];		
			$id = $this->dbDelete('loan_doc_master', $where);			
		}
		return 1;		
	
	}
	
}