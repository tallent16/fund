<?php namespace App\models;
class AdminIndustriesModel extends TranWrapper {
	
	public $industry_list	= array();
	
	public function getIndustryList(){
		
		$industry_sql			= 	"SELECT	codelist_id,
											codelist_code,
											codelist_value,
											expression
									FROM	codelist_details
									WHERE	codelist_id = 15 
									ORDER BY abs(codelist_code)";
							
		$result					=	$this->dbFetchAll($industry_sql);
		
		$this->industry_list	= 	$result;
	}
	public function updateIndustries($postArray){
		
		if (isset($postArray["industry"])) {
			$newRows = $postArray["industry"];			
			$numRows = count($newRows['industry_list']);
		}else {
			$newRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$industryIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {			
		
			$id			= $newRows['id'][$rowIndex];
			
			if ($id == 0) {							
				$update = false;				
			} else {
				$update = true;				
			}
			$codecode		= $rowIndex+1;
			$industry		= $newRows['industry_list'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	'codelist_id'		=> 15,
								'codelist_value'	=> $industry,
								'codelist_code' 	=> $codecode
								);				
			//echo "<pre>",print_r($dataArray),"</pre>"; 
			/*update/insert*/						
			if ($update) {				
				$whereArray	=	[ 'codelist_id'	  => 15 ,
								  'codelist_code' => $id];
				$this->dbUpdate('codelist_details', $dataArray, $whereArray);
				$industryIds[]	=	$id;	
			} else {
				$id	 =  $this->dbInsert('codelist_details', $dataArray, true);
				$industryIds[]	=	$id;	
			}			
		}
		//	die;	
		/*Check before delete*/	
		/*$idArray_sql	=	"SELECT user_id from borrowers";
		
		$count_id		=	$this->dbFetchAll($idArray_sql);
		
		foreach($count_id as $row){
			$this->listids[]=$row->user_id;
		}
		
		$whereId		=	implode(",", $this->listids);		
	
		$sql			=	"SELECT COUNT(*) 
							FROM	borrowers
							WHERE	codelist_value in ({$whereId}) ";	
						
		$count			=	$this->dbFetchOne($sql);
				
		if ($count > 0) {
			$this->errorText	=	"Challenge question marked for deletion is already in use. Cannot delete";
			return -1;
		}else{	*/
		/** Questions will be deleted**/		
			$where	=	[ 'codelist_id' => 15 ,
						"whereNotIn" 	=>	["column" => 'codelist_code',
											 "valArr" =>$industryIds]];		
			$this->dbDelete('codelist_details', $where);
		//}
		return 1;		
	}
}
