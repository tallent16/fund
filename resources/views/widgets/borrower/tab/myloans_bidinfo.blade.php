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
										<th>BIDDER NAME</th>
										<th>INTEREST RATE</th>	
										<th>BID AMOUNT</th>				
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
													<td class="tab-bid-label">Bidder #{{$i}}</td>
													<td class="{{$tdRowClass}}">{{$bidRow['bid_interest_rate']}}%</td>	
													<td class="{{$tdRowClass}}">{{$bidRow['bid_amount']}}</td>		
												</tr>	
												@var	$i++;
											@endforeach
										@else
												<tr><td colspan="3">No Bidder Information Found</td></tr>
										@endif
								</tbody>
							</table>	
						</div>					
						
					</div>
				</div>
			
		</div><!---panel body--->
	</div><!----panel container-->
