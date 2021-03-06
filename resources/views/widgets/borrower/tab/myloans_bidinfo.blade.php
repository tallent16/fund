	@var	$bidInfo		=	$LoanDetMod->bidInfo;
	@var	$bidInfoCnt		=	count($bidInfo);
	<div class="panel panel-primary panel-container">
		<div class="panel-body">
							
				<div class="row">
					<div class="col-md-12">
						
						<div class="table-responsive"><!---table start-->
							<table class="table table-bidinfo">		
								<tbody>
									<tr>
										<th class="text-center">{{ Lang::get('borrower-myloans.bidder_name') }}</th>
										<th>{{ Lang::get('borrower-myloans.date_backing') }}</th>	
										<th class="text-right">{{ Lang::get('borrower-myloans.bid_amount') }}</th>				
									</tr>
										@if($bidInfoCnt	>	0)
											@var	$i	=	1;
											@foreach($bidInfo as $bidRow)
												@if($bidInfoCnt	==	$i)
													@var	$tdRowClass	=	"tab-head"
												@else
													@var	$tdRowClass	=	"tab-row-orange"
												@endif
												<tr>
													<td class="tab-bid-label text-center">{{ Lang::get('borrower-myloans.bidder') }} #{{$i}}</td>
													<td class="{{$tdRowClass}}">{{$bidRow['bid_date']}}</td>	
													<td class="{{$tdRowClass}} text-right">{{number_format($bidRow['bid_amount'],2,'.',',')}}</td>		
												</tr>	
												@var	$i++;
											@endforeach
										@else
												<tr><td colspan="3">{{ Lang::get('borrower-myloans.no_bidder_found') }}</td></tr>
										@endif
								</tbody>
							</table>	
						</div>					
						
					</div>
				</div>
				@if(($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_CLOSED_FOR_BIDS)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED) )
						<!-- <div class="row">
							<div class="col-md-12 text-right">
								<button type="button"
									data-action="{{url('borrower/managebids')."/".$LoanDetMod->loan_id}}"	 
									class="btn verification-button"	
									id="manage_bids_button" >
									<i class="fa pull-right"></i>
									{{ Lang::get('Manage Bids')}}
								</button>
							</div>
						</div>
					-->
				@endif
			
		</div><!---panel body--->
	</div><!----panel container-->
