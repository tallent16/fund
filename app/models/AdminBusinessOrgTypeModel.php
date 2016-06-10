<?php namespace App\models;
class AdminBusinessOrgTypeModel extends TranWrapper {
		
	public $businessorg_list	= array();
	public $listids 			= array();	
	
	public function getBusinessOrgTypes(){
		
		$businessorg_sql			= 	"SELECT slno,
											bo_id,
											bo_name,
											bo_borrowing_allowed 
											FROM business_organisations";
							
		$result						=	$this->dbFetchAll($businessorg_sql);
		
		$this->businessorg_list		= 	$result;		
	}	
	public function updateBusinessOrgTypes($postArray) {
		
		if (isset($postArray["business"])) {
			$newRows = $postArray["business"];			
			$numRows = count($newRows['business_org_type']);			
		}else {
			$newRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$boIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {			
		
			$id			= $newRows['id'][$rowIndex];
			
			if ($id == 0) {		
				$update = false;				
			} else {
				$update = true;				
			}
			
			$slno				= $rowIndex+1;
			
			$boid				= $newRows['id'][$rowIndex];
			$busorgtype			= $newRows['business_org_type'][$rowIndex];			
			$lending			= $newRows['lending_allowed'][$rowIndex];
						
			// Construct the data array
			$dataArray = array(	'slno'					=> $slno,								
								'bo_name' 				=> $busorgtype,
								'bo_borrowing_allowed'	=> 	$lending
								 );				
				
			/*update/insert*/						
			if ($update) {	
				$whereArray	=	[ "bo_id"	=> $id];
				$this->dbUpdate('business_organisations', $dataArray, $whereArray);				
				$boIds[]	=	$id;							
			} else {				
				$id	 =  $this->dbInsert('business_organisations', $dataArray, true);				
				$boIds[]	=	$id;				
			}			
		}
		
		
		/*Check before delete*/	
		
		$idArray_sql	=	"SELECT bo_id from borrowers";
		
		$count_id		=	$this->dbFetchAll($idArray_sql);
		
		foreach($count_id as $row){
			$this->listids[]=$row->bo_id;
		}
	
		$whereId		=	implode(",", $this->listids);		
	
		$sql			=	"SELECT COUNT(*) 
							FROM	business_organisations
							WHERE	bo_id in ({$whereId}) ";	
							
		/*$sql			=	"SELECT count(bo_id)
								FROM  business_organisations
								WHERE EXISTS (SELECT * 
								FROM   borrowers 
								WHERE  business_organisations.bo_id = borrowers.bo_id)";	*/				
						
		$count			=	$this->dbFetchOne($sql);
				
		if ($count > 0) {
			$this->errorText	=	"Business Organisation Type marked for deletion is already in use. Cannot delete";
			return -1;
		}else{	
		/** Business Organisations Type will be deleted**/		
			$where	=	[ "whereNotIn" 	=>	["column" => 'bo_id',
											 "valArr" =>$boIds]];		
			$id = $this->dbDelete('business_organisations', $where);			
		}
		return 1;		
	}	
}
