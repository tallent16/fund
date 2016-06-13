<?php namespace App\models;
use DB;
class AdminIndustriesModel extends TranWrapper {
	
	public $industry_list	= array();
	public $listids			= array();
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
			//$codecode = '';	
			$codecode		= $rowIndex+1;
			$industry		= $newRows['industry_list'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	'codelist_id'		=> 15,
								'codelist_value'	=> $industry,
								'codelist_code' 	=> $codecode,
								'expression'		=> ''								
								);				
		
			/*update/insert*/						
			if ($update) {	
				$whereArray	=	[ 'codelist_id'	  => 15 ,
								  'codelist_code' => $id];
				$this->dbUpdate('codelist_details', $dataArray, $whereArray);
				$industryIds[]	=	$id;	
			} else {
				$id	 =  $this->dbInsert('codelist_details', $dataArray, true);		
				//$lastInsertedId = DB::getPdo()->lastInsertId();			
				$industryIds[]	=	$id;						
			}			
		}
	
		$no_of_rows_present 	= count($industryIds); 
		
		$sql		  		 	= "SELECT COUNT(*) FROM codelist_details where codelist_id = 15";	
		$no_of_rows_db			=	$this->dbFetchOne($sql);
		/** Industries will be deleted**/	
		if($no_of_rows_db > $no_of_rows_present){
			$where	=	[ "codelist_id" => 15 ,
						"whereNotIn" 	=>	["column" => 'codelist_code',
											 "valArr" =>$industryIds]];		
			$this->dbDelete('codelist_details', $where);
		}
	
		return 1;		
	}
	
}
