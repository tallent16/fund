	@var	$paymentInfo		=	$LoanDetMod->paymentScheduleInfo;
	@var	$paymentInfoCnt		=	count($paymentInfo);
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
							<table class="table table-loan">		
								<tbody>
									<tr>
										<th class="tab-head">{{ Lang::get('Date') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Amount') }}</th>	
										<th class="tab-head">{{ Lang::get('Status') }}</th>				
										<th class="tab-head">{{ Lang::get('Date Paid') }}</th>				
										<th class="tab-head text-right">{{ Lang::get('Penalty') }}</th>				
									</tr>									
										@if($paymentInfoCnt	>	0)										
											@var	$i	=	1;
											@foreach($paymentInfo as $paymentRow)
												<tr>
													<td>
														{{$paymentRow['schd_date']}}
													</td>
													<td class="text-right">
														{{$paymentRow['schd_amt']}}
													</td>
													<td>
														{{$paymentRow['status']}}
													</td>
													<td>
														{{$paymentRow['payment_date']}}
													</td>
													<td class="text-right">
														{{$paymentRow['penal_paid']}}
													</td>													
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
