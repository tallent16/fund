<?php 
namespace App\Http\Controllers;
use	\App\models\AdminCommFeeLedgerReportModel;
use Response;
use Request;
use Excel;

class AdminCommFeeLedgerReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		
		$this->adminCommFeeLedRepMod = new AdminCommFeeLedgerReportModel();
	}

	public function indexAction() { 
		
		
		$withArry	=	array(	"adminCommFeeLedRepMod" => $this->adminCommFeeLedRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-commFeeLedgerReport')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["fromdate"])) 
			$filterFromDate	= 	$_REQUEST["fromdate"];

		if (isset($_REQUEST["todate"])) 
			$filterToDate 	= 	$_REQUEST["todate"];
		
		if(	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminCommFeeLedRepMod->getCommFeeLedgerReportInfo( $filterFromDate, $filterToDate);
		}
	
		$withArry	=	array(	"adminCommFeeLedRepMod" => $this->adminCommFeeLedRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-commFeeLedgerReport')
			->with($withArry); 
					
	}
	
	public function DownloadCommissionFeesLedgerAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		//~ $this->adminInvProRepMod->prnt($jsonObj);
		$headers	=	[
							0=> [	'Loan Ref No','Organisation Name','Borrower Grade','Loan Disbursal Date',
									'Loan Disbursal Amount','Processing Fixed Fees','Processing Commission'
								]
						];
		$headStart	=	1;
		$startRow	=	2;
		$breakColumn=	"Date";			
		$colKeyNameArry		=	array(	0=>'A',1=>'B',2=>'c',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',
								9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',	
								18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',
								27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',
								36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',42=>'AQ',43=>'AR',44=>'AS'	
							);
		Excel::create('CommissionFeesLedgerReport', function($excel) 
			use ($jsonObj,$headers,$headStart,$startRow,$breakColumn,$colKeyNameArry)
		 {
				$excel->sheet('Commissions', function($sheet)
					use ($headers,$headStart,$startRow,$breakColumn,$jsonObj,$colKeyNameArry)
				 {
						$sheet->getStyle('E')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$sheet->getStyle('F')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$sheet->getStyle('G')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$headerRow = $headStart;
						foreach ($headers as $headerInfo) {
							if(is_array($headerInfo)) {
								$colkey	=	0;
								foreach($headerInfo as $bodyRow) {
									$curColKeyName	=	$colKeyNameArry[$colkey].$headerRow;
									$curColKeyvalue	=	$bodyRow;
									$sheet->setCellValue($curColKeyName, $curColKeyvalue);	
									$colkey++;
								}
							}else{
								$sheet->setCellValue('A'.$headerRow,$headerInfo);
							}
							$headerRow ++;
						}
						$currExcelRow = $startRow;
						foreach ($jsonObj as $jsonCol => $jsonVal) {
								
							$colkey	=	0;
							foreach($jsonVal as $bodyRow) {
								$curColKeyName	=	$colKeyNameArry[$colkey].$currExcelRow;
								$curColKeyvalue	=	$bodyRow;
								$sheet->setCellValue($curColKeyName, $curColKeyvalue);	
								$colkey++;
							}
							$currExcelRow++;
						}					
					});
							
		})->download('xls');
		
	}	
}
