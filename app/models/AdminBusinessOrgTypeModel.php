<?php namespace App\models;
class AdminBusinessOrgTypeModel extends TranWrapper {
		
	public $businessorg_list	= array();
	public $listids 			= array();
	
	public function getBusinessOrgTypes(){
		
		$businessorg_sql			= 	"SELECT bo_id,bo_name,bo_borrowing_allowed 
											FROM business_organisations";
							
		$result						=	$this->dbFetchAll($businessorg_sql);
		
		$this->businessorg_list		= 	$result;		
	}	
	public function updateBusinessOrgTypes($postArray) {
		
	//	echo "<pre>",print_r($postArray),"</pre>";		
	//	die;
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
			//echo "<pre>",print_r($id),"</pre>"; 
			if ($id == 0) {		
				$update = false;				
			} else {
				$update = true;				
			}
			
			$boid			= $rowIndex+1;
		
			$busorgtype		= $newRows['business_org_type'][$rowIndex];
			$busborallowed	= $newRows['lending_allowed'][$rowIndex];
			//echo "<pre>",print_r($busborallowed),"</pre>"; die;
			/*if($busborallowed == ("Yes" || "yes")){
				$lending = 1;
			}
			if($busborallowed == ("No" || "no")){
				$lending = 0;
			}*/
			
			// Construct the data array
			$dataArray = array(	'bo_id'					=> $boid,
								'bo_name' 				=> $busorgtype,
								'bo_borrowing_allowed'	=> $busborallowed
								 );				
				
			/*update/insert*/						
			if ($update) {	
				$whereArray	=	[ "bo_id"	=> $id];
				$this->dbUpdate('business_organisations', $dataArray, $whereArray);
				//echo "<pre>",print_r($id),"</pre>";
				$boIds[]	=	$id;	
			} else {				
				$id	 =  $this->dbInsert('business_organisations', $dataArray, true);
				echo "<pre>",print_r($id),"</pre>"; die;	
				$boIds[]	=	$id;				
			}			
		}
			
		/*Check before delete*/	
		$idArray_sql	=	"SELECT user_id from borrowers";
		
		$count_id		=	$this->dbFetchAll($idArray_sql);
		//echo "<pre>",print_r($count_id),"</pre>";	
		foreach($count_id as $row){
			$this->listids[]=$row->user_id;
		}
		//echo "<pre>",print_r($this->listids),"</pre>";	
		$whereId		=	implode(",", $this->listids);		
	
		$sql			=	"SELECT COUNT(*) 
							FROM	borrowers
							WHERE	bo_id in ({$whereId}) ";	
						
		$count			=	$this->dbFetchOne($sql);
				
		if ($count > 0) {
			$this->errorText	=	"Business Organisation Type marked for deletion is already in use. Cannot delete";
			return -1;
		}else{	
		/** Business Organisations Type will be deleted**/		
			$where	=	[ "whereNotIn" 	=>	["column" => 'bo_id',
											 "valArr" =>$boIds]];		
			$this->dbDelete('business_organisations', $where);
		}
		return 1;		
	}	
}
