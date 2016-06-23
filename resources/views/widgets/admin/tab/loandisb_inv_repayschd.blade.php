<div id="inv_repay_schd" class="tab-pane fade">  	
	<div class="panel panel-default inv_repay_schd"> 						
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered .tab-fontsize" id="bidsummary">		
					<tbody>
						<tr>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Investor')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Bid Date')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Bid Amount')}}</th>								
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Bid Interest')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Accepted Amount')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Total Repaid')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Action')}}</th>
						</tr>
						@foreach($bidsModel->loanInvestors as $loanbidRow)
						<tr>
							<td class="col-sm-2 text-left">
								{{$loanbidRow->username}}
							</td>
							<td class="col-sm-2 text-left">
								{{$loanbidRow->bid_datetime}}
							</td>
							<td class="text-right">
								{{number_format($loanbidRow->bid_amount, 2, ".", ",")}}
							</td>								
							<td class="text-right">
								{{number_format($loanbidRow->bid_interest_rate, 2, ".", ",")}}
							</td>										
							<td class="text-right">
								{{number_format($loanbidRow->accepted_amount, 2, '.',',')}}											
							</td>	
							<td class="text-right">
								{{number_format($loanbidRow->totalrepaid, 2, '.',',')}}											
							</td>	
							<td>
								<button type="button" 
										class="btn verification-button repayment_schedule" 
										data-investor-id="{{$loanbidRow->investor_id}}"
										data-loan-id="{{$bidsModel->loan_id}}"
										>
									{{ Lang::get('Show Repayments')}}
								</button>
							</td>	
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>			
		</div>
	</div>
</div>
