<?php 
namespace App\Http\Controllers;
use	\App\models\AdminLoanPerformanceReportModel;
use Response;
use Request;
use Excel;

class AdminLoanPerformanceReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminLoanPerRepMod = new AdminLoanPerformanceReportModel();
	}

	public function indexAction() { 
		
		
		$withArry	=	array(	"adminLoanPerRepMod" => $this->adminLoanPerRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-loanPerformanceReport')
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
			//~ die("dsdsd");
			$this->adminLoanPerRepMod->getLoanPerformanceReportInfo( $filterFromDate, $filterToDate);
			$this->adminLoanPerRepMod->getBorrRepaySchd();
		}
		$withArry	=	array(	"adminLoanPerRepMod" => $this->adminLoanPerRepMod	,
						"classname"=>"fa fa-list-alt fa-fw"
					);
		return view('admin.admin-loanPerformanceReport')
			->with($withArry); 
	}
	
	public function DownloadLoanPerformanceAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		$this->adminLoanPerRepMod->getExcelBorrRepaySchd();
		$borRepShcd	=	$this->adminLoanPerRepMod->repayment_schedule;
		//~ $this->adminInvProRepMod->prnt($borRepShcd);
		$headers	=	[
							0=> [	'Loan Ref No','Organization Name','Borrower Grade','Bid Type','Repayment Type',
									'Tenure','Loan Applied Amount','Total Bids Received Number','Total Bids Received Amount',
									'Loan Sanctioned Amount','Total Prinicipal O/s','Total Interest OS',
									'Total Penalty Interest','Total Penalty Charges','Overdue Amount','Overdue since'
								]
						];
		$headersRepSch	=	 [	'Inst-No','Inst Due Date','Inst Act Pay Date','Schd Inst Amount','Principal',
								'Interest','Penalty','Status'
							];
						
		$headStart	=	1;
		$startRow	=	2;
				
		$colKeyNameArry		=	array(	0=>'A',1=>'B',2=>'c',3=>'D',4=>'E',5=>'F',6=>'G',7=>'H',8=>'I',
								9=>'J',10=>'K',11=>'L',12=>'M',13=>'N',14=>'O',15=>'P',16=>'Q',17=>'R',	
								18=>'S',19=>'T',20=>'U',21=>'V',22=>'W',23=>'X',24=>'Y',25=>'Z',26=>'AA',
								27=>'AB',28=>'AC',29=>'AD',30=>'AE',31=>'AF',32=>'AG',33=>'AH',34=>'AI',35=>'AJ',
								36=>'AK',37=>'AL',38=>'AM',39=>'AN',40=>'AO',41=>'AP',42=>'AQ',43=>'AR',44=>'AS'	
							);
		Excel::create('LoanPerformanceLedgerReport', function($excel) 
			use ($jsonObj,$headers,$headStart,$startRow,$colKeyNameArry,$headersRepSch,$borRepShcd)
		 {
				$excel->sheet('Loans', function($sheet)
					use ($headers,$headStart,$startRow,$jsonObj,$colKeyNameArry,$headersRepSch,$borRepShcd)
				 {
						$headerRow = $headStart;
						 $setRowBoldArry	=	array();
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
						$setRowBoldArry[]	=	$headStart;
						
						$currExcelRow = $startRow;
						foreach ($jsonObj as $jsonCol => $jsonVal) {
								
							$colkey	=	0;
							foreach($jsonVal as $bodykey=>$bodyRow) {
								$curColKeyName	=	$colKeyNameArry[$colkey].$currExcelRow;
								$curColKeyvalue	=	$bodyRow;
								if( $bodykey	!=	"Action" && $bodykey	!=	"LoanID" )
									$sheet->setCellValue($curColKeyName, $curColKeyvalue);	
								$colkey++;
								//if loan id column reached start rep shcd for the loan
								if($bodykey	==	"LoanID") {
									$currExcelRow++;
									if(isset($borRepShcd[$bodyRow])) {
										//print repayment shcedule header starts here
										$j	=	1;
										$setRowBoldArry[]	=	$currExcelRow;
										foreach($headersRepSch as $headersRepSchRow) {
											
											$cName	=	$colKeyNameArry[$j++].$currExcelRow;
											$cvalue	=	$headersRepSchRow;
											$sheet->setCellValue($cName, $cvalue);
										}
										$currExcelRow++;
										//print repayment shcedule header starts here
										foreach ($borRepShcd[$bodyRow] as $repKey => $repVal) {
											$colInnkey	=	1;
											foreach($repVal as $bodyInnkey=>$bodyInnRow) {
												$curInnColKeyName	=	$colKeyNameArry[$colInnkey].$currExcelRow;
												$curInnColKeyvalue	=	$bodyInnRow;
												$sheet->setCellValue($curInnColKeyName, $curInnColKeyvalue);	
												$colInnkey++;
											}
											$currExcelRow++;
										}
									}else{
										$currExcelRow++;
									}	
									
								}
								//if loan id column reached end rep shcd for the loan
							}
							
						}
						//set needed row to be bold
						foreach($setRowBoldArry	as $boldRow) {
							
							$sheet->row($boldRow, function ($row) {
								$row->setFontWeight('bold');
							});
						}				
					});
							
		})->download('xls');
		
	}	
	
	public function DownloadLoanPerformanceTestAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		
		foreach($jsonObj as $k=>$v) {
			foreach($v as $key=>$val) {
				if($key == 'Action' || $key == 'LoanID' ) {
					unset($jsonObj[$k][$key]);
				}
			}
		}
		Excel::create('LoanPerformanceLedgerReport', function($excel) 
			use ($jsonObj)
		 {
				$excel->sheet('Loans', function($sheet)
					use ($jsonObj)
				 {		
					 $sheet->fromArray($jsonObj);
					});
							
		})->download('xls');
		
	}	
	
}
