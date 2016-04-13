@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<div class="col-sm-12 space-around">	
	<div class="panel-primary panel-container"><!--panel container-->
			
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{Lang::get('LOAN BID MANAGEMENT')}}</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->						
			<div class="panel-body applyloan"><!--panel body-->					
				
				<div class="col-sm-12" id="managebids"><!--col-sm-12-->	
									
					<div class="row"><!--row--1-->
						<div class="panel-primary panel-container"><!--panel container-->
							<div class="panel-heading panel-headsection"><!--panel head-->
								<div class="row">
									<div class="col-sm-12">
										<span class="pull-left">{{Lang::get('LOAN DETAILS')}}</span> 														
									</div>																
								</div>					
							</div><!--panel head end-->
						</div><!--panel container end-->
						
							
						<div class="table-responsive">
							<table class="table table-bordered .tab-fontsize text-left" id="loandetails">		
								<tbody>
									<tr>
										<td class="tab-left-head col-sm-3">Purpose of Loan</td>
										<td class="col-sm-3">To increase loan car fleet</td>
										<td class="tab-left-head col-sm-3">Bid Close Date</td>								
										<td class="col-sm-3">2016-04-21</td>																				
									</tr>
									<tr>
										<td class="tab-left-head">Loan Amount</td>
										<td>$60,000</td>
										<td class="tab-left-head">Accept Partial Subscription</td>								
										<td>Yes</td>						
									</tr>
									<tr>
										<td class="tab-left-head">Tenure of Loan</td></td>	
										<td>12</td>
										<td class="tab-left-head">Minimum Limit For Partial Subscription</td>								
										<td>$50,000</td>					
									</tr>
									<tr>
										<td class="tab-left-head">Target Interest%</td>	
										<td>10%</td>
										<td class="tab-left-head">Payment Type</td>								
										<td>one time</td>						
									</tr>
									<tr>
										<td class="tab-left-head">Loan Reference Number</td>	
										<td>L-201604-28</td>
										<td class="tab-left-head">Status</td>								
										<td>Bid Closed</td>					
									</tr>	
									<tr>
										<td class="tab-left-head">Bid Type</td>								
										<td class="col-sm-3">Open Bidding</td>												
									</tr>				
								</tbody>
							</table>
						</div>	
					</div><!-----row-1 end--->
					
					<div class="row"><!--row--2-->
						<div class="panel-primary panel-container">
							<div class="panel-heading panel-headsection"><!--panel head-->
								<div class="row">
									<div class="col-sm-12">
										<span class="pull-left">BIDS SUMMARY</span> 														
									</div>																
								</div>					
							</div><!--panel head end-->
						</div><!--panel-->
						
						<div class="table-responsive">
							<table class="table table-bordered .tab-fontsize" id="bidsummary">		
								<tbody>
									<tr>
										<th class="tab-head col-sm-2">Investor</th>
										<th class="tab-head col-sm-2">Bid Date</th>
										<th class="tab-head col-sm-2 text-right">Bid Amount</th>								
										<th class="tab-head col-sm-2 text-right">Bid Interest</th>										
										<th class="tab-head col-sm-2 text-right">Accepted Amount</th>	
										<th class="tab-head col-sm-2"></th>										
									</tr>
									<tr>
										<td>Investor1</td>
										<td>25/11/2016</td>
										<td class="text-right">40,000</td>								
										<td class="text-right">18%</td>										
										<td>
											<input name="acceptamount" value=""
													type="text" class="form-control text-right" disabled />
										</td>	
										<td></td>
									</tr>
									<tr>
										<td>Investor2</td>
										<td>25/11/2016</td>
										<td class="text-right">40,000</td>								
										<td class="text-right">18%</td>										
										<td>
											<input name="acceptamount" value=""
													type="text" class="form-control text-right" disabled />
										</td>
										<td></td>
									</tr>
									<tr>
										<td>Investor3</td>
										<td>25/11/2016</td>
										<td class="text-right">40,000</td>								
										<td class="text-right">18%</td>										
										<td>
											<input name="acceptamount" value=""
													type="text" class="form-control text-right" disabled />
										</td>	
										<td></td>
									</tr>
									<tr>
										<td>Investor4</td>
										<td>25/11/2016</td>
										<td class="text-right">40,000</td>								
										<td class="text-right">18%</td>										
										<td>
											<input name="acceptamount" value=""
													type="text" class="form-control text-right" disabled />
										</td>	
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>							
										<td class="text-right">Total</td>										
										<td class="text-right">12,0000</td>	
										<td></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>	
										<td class="text-right">Total Weighted Average</td>							
										<td class="text-right">12.5%</td>							
										<td></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div><!-----row-2 end--->	
					
					<div class="row"><!---row--3-->
						<div class="col-sm-12 space-around"> 
							<div class="">
								<button type="button" class="btn verification-button">
									Close Bid</button>
								<button type="button" class="btn verification-button">						
									Accept Bid</button>
								<button type="button" class="btn verification-button">						
									Cancel Loan</button>
								<button type="button" class="btn verification-button">						
									Disburse Loan</button>
							</div>
						</div>
					</div><!-----row-3 end--->	

				</div><!--end col-sm-12-->
			</div><!--end panel body-->		
		
	</div><!--end panel container-->
</div>
	@endsection  
@stop
