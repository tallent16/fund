<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
	
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('BORROWER NAME')}}</th>
				<th class="tab-head text-left">{{Lang::get('Approval Date')}}</th>
				<th class="tab-head text-left">{{Lang::get('Active Loans')}}</th>
			</tr>
		</thead>
		<tbody>
			@if( is_array($panelBody) && count($panelBody)	>	0	)
				@foreach($panelBody as $tableRow) 
					
					<tr>
						<td>
							{{$tableRow->borrower_name}}
						</td>
						<td>
							{{$tableRow->approve_date}}
						</td>
						<td>
							@if($tableRow->loan_list	!=	"")
								@var	$loanListArry	=	explode(",",$tableRow->loan_list)
								@if( is_array($loanListArry) && count($loanListArry)	>	0	)
									@var	$i				=	1;
									@var	$loanListArryLen=	count($loanListArry);
									
									@foreach($loanListArry as $loanListArryRow) 
										@var	$statusArry	=	explode("|",$loanListArryRow)
										<?php 
											//~ echo "<pre>",print_r($statusArry),"</pre>";
											//~ die;
										?>
										@var	$loanNo		=	$statusArry[0]
										@var	$loanID		=	$statusArry[1]
										@var	$loanStatus	=	$statusArry[2]
										
											@if( ($loanStatus	==	LOAN_STATUS_NEW) || 
												 ($loanStatus	==	LOAN_STATUS_PENDING_COMMENTS) ||
												 ($loanStatus	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL) )
												 @var	$actionUrl		=	url('admin/loanapproval')
												 @var	$actionUrl		=	$actionUrl."/".base64_encode($loanID)
											@endif
											
											@if( ($loanStatus	==	LOAN_STATUS_APPROVED) || 
												 ($loanStatus	==	LOAN_STATUS_CLOSED_FOR_BIDS) )
												 @var	$actionUrl		=	url('admin/managebids')
												 @var	$actionUrl		=	$actionUrl."/".$loanID
											@endif
											
											@if( ($loanStatus	==	LOAN_STATUS_BIDS_ACCEPTED) )
												 @var	$actionUrl		=	url('admin/disburseloan')
												 @var	$actionUrl		=	$actionUrl."/".base64_encode($loanID)
											@endif
											
											@if( ($loanStatus	==	LOAN_STATUS_DISBURSED) || 
												 ($loanStatus	==	LOAN_STATUS_LOAN_REPAID) )
												 @var	$actionUrl		=	url('admin/loanview')
												 @var	$actionUrl		=	$actionUrl."/".base64_encode($loanID)
											@endif
											<a href="{{$actionUrl}}">{{$loanNo}}</a>
											@if($loanListArryLen!=$i)
												,&nbsp;
											@endif
											@var	$i	=	$i+1
									@endforeach
									
								@endif
							@endif
							
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
