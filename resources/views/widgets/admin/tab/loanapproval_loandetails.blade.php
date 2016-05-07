@if($adminLoanApprMod->adminLoanApprMod	==	1)
	@var	$par_sub_allowed		=	"yes"
@else
	@var	$par_sub_allowed		=	"No"
@endif
@var	$showBidCloseDatePicker	="no"  
@if($adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
	@if($adminLoanApprMod->comments_count	==	0)
		@var	$showBidCloseDatePicker	="yes"
	@endif
@endif
@var $loanDocuments = $adminLoanApprMod->document_details;
<div id="loan_details" class="tab-pane fade in active">
	<div class="table-responsive">
		<table class="table table-bordered .tab-fontsize text-left">		
			<tbody>
				<tr>
					<td class="tab-left-head col-sm-3">{{ Lang::get('Borrower\'s Name')}}</td>
					<td class="col-sm-3">{{$adminLoanApprMod->firstname}}</td>
					<td class="tab-left-head col-sm-3">{{ Lang::get('Loan Amount')}}</td>
					<td class="col-sm-3">{{number_format($adminLoanApprMod->apply_amount,2,'.',',')}}</td>
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Purpose of Loan')}}</td>					
					<td>{{$adminLoanApprMod->purpose_singleline}}</td>
					<td class="tab-left-head">{{ Lang::get('Bid Close Date')}}</td>								
					<td id="bid_close_date_parent">
						@if($showBidCloseDatePicker		==	"yes"	)
							<div class="controls">
								<div class="input-group">
									<input 	id="bid_close_date" 
											type="text" 
											class="date-picker form-control required" 
											name="bid_close_date"
											value="{{$adminLoanApprMod->bid_close_date}}"
											readonly />
									<label for="bid_close_date" class="input-group-addon btn">
										<span class="glyphicon glyphicon-calendar"></span>
									</label>
								</div>													
							</div>	
						@else
							{{$adminLoanApprMod->bid_close_date}}
						@endif
								
					</td>
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Tenure of Loan')}}</td></td>	
					<td>{{$adminLoanApprMod->loan_tenure}}</td>
					<td class="tab-left-head">{{ Lang::get('Accept Partial Subscription')}}</td>								
					<td>{{$par_sub_allowed}}</td>						
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Target Interest')}}%</td>	
					<td>{{$adminLoanApprMod->target_interest}}</td>
					<td class="tab-left-head">{{ Lang::get('Minimum Limit For Partial Subscription')}}</td>								
					<td>{{number_format($adminLoanApprMod->min_for_partial_sub,2,'.',',')}}</td>					
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Loan Reference Number')}}</td>	
					<td>{{$adminLoanApprMod->loan_reference_number}}</td>	
					<td class="tab-left-head">{{ Lang::get('Payment Type')}}</td>								
					<td>{{$adminLoanApprMod->repaymentText}}</td>	
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Bid Type')}}</td>								
					<td class="col-sm-3">{{ $adminLoanApprMod->bidTypeText}}</td>	
					<td class="tab-left-head">{{ Lang::get('Status')}}</td>								
					<td>{{ $adminLoanApprMod->statusText}}</td>					
				</tr>	
				<tr>
																
				</tr>				
			</tbody>
		</table>
	</div>	
		
	<div class="col-sm-12">
		@var	$i	=	1
		@foreach($loanDocuments as $documentRow)
			@var	$documentRowIndex	=	$documentRow['loan_doc_id']
				<div class="row">
					<div class="col-sm-9">
						{{ $i.". ".$documentRow['short_name']}}
						<a 	href="#" 
							data-toggle="tooltip" data-placement="top" 
							title="{{$documentRow['doc_name']}}">
							<i class="fa fa-question"></i></a>
					</div>
					<div class="col-sm-2 text-right" id="documents_parent">
						@var	$isDocumentAvailable	=	"no"					
						@if(isset($adminLoanApprMod->submitted_document_details[$documentRowIndex]))
							@var	$loan_url	=	$adminLoanApprMod->submitted_document_details[$documentRowIndex]
							@var	$loan_url	=	"admin/loandocdownload/".$loan_url
							<a 	href="javascript:void(0)"
								data-download-url="{{url($loan_url)}}"
								class="btn button-grey borrower_doc_download">{{ Lang::get('Show Docs') }}
							</a>
							@var	$isDocumentAvailable	=	"yes"
						@endif	
					</div>
					<div class="col-sm-1 text-right">		
						@if($isDocumentAvailable	==	"yes")		
							{{ Lang::get('Available') }}		
						@else
							{{ Lang::get('None') }}
						@endif									
					</div>
				</div>	
			@var	$i++;		
		@endforeach		
	</div>	
</div>
