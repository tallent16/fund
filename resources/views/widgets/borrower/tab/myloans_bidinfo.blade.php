	@var	$bidInfo		=	$LoanDetMod->bidInfo;
	@var	$bidInfoCnt		=	count($bidInfo);
	<div class="panel panel-primary panel-container">
		<div class="panel-body">
					
				<div class="row">
					<div class="col-md-12">
						<div class="pull-right">
							<i class="fa fa-exclamation-circle"></i>
						</div>
					</div>
				</div>
			
			
				<div class="row">
					<div class="col-md-12">
						
						<div class="table-responsive"><!---table start-->
							<table class="table table-bidinfo">		
								<tbody>
									<tr>
										<th>{{ Lang::get('borrower-myloans.bidder_name') }}</th>
										<th>{{ Lang::get('borrower-myloans.interest_rate') }}</th>	
										<th>{{ Lang::get('borrower-myloans.bid_amount') }}</th>				
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
													<td class="tab-bid-label">{{ Lang::get('borrower-myloans.bidder') }} #{{$i}}</td>
													<td class="{{$tdRowClass}}">{{$bidRow['bid_interest_rate']}}%</td>	
													<td class="{{$tdRowClass}}">{{$bidRow['bid_amount']}}</td>		
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
			
		</div><!---panel body--->
	</div><!----panel container-->
