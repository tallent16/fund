@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','My Loans') )
@section('section')    
<div class="col-sm-12"> 			
	<div class="row">			
			
			<div class="col-sm-12 space-around"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						LOAN INFO
					</div>
					
					<div class="col-sm-12 loan-info-wrapper">
						<div class="row"> 
							
							<div class="col-sm-12 col-lg-2">										
								<div class="table-responsive"><!---table start-->
									<table class="table tab-label">		
										<tbody>																								
											<tr>
												<td>Loan Reference</td>														
											</tr>
											<tr>
												<td>Date Applied</td>												
											</tr>
											<tr>
												<td>Status</td>												
											</tr>
											<tr>
												<td>Loan Type</td>												
											</tr>
											<tr>
												<td>Bid Type</td>												
											</tr>
											<tr>
												<td>Target Interest%</td>												
											</tr>
											<tr>
												<td>Effective Interest%</td>												
											</tr>
											<tr>
												<td>Amount Applied</td>												
											</tr>
											<tr>
												<td>Amount Realized</td>												
											</tr>
											<tr>
												<td>Repayments till date</td>												
											</tr>
											<tr>
												<td>Principal Outstanding</td>												
											</tr>
										</tbody>
									</table>	
								</div>							
							</div> <!----col--2--->
							
							<div class="col-sm-12 col-lg-10 loan-details">
							
								<div class="col-sm-12 col-lg-3 text-center">									
										<a href="{{ url ('investor/myloans') }}">
											<button type="submit" class="btn loan-detail-button">LOAN DETAILS 1</button>
										</a>				
																
									<div class="table-responsive"><!---table start-->
										<table class="table table-loan">		
											<tbody>												
												<tr>
													<td class="tab-head">LOAN 1</td>																										
												</tr>
												<tr>
													<td>1 JAN 2016</td>														
												</tr>
												<tr>
													<td>Approved</td>														
												</tr>
												<tr>
													<td>Monthly Repayment</td>												
												</tr>
												<tr>
													<td>Auction</td>												
												</tr>
												<tr>
													<td>10%</td>												
												</tr>
												<tr>
													<td>														
														<button type="submit" class="btn button-grey">View All Bids</button>												
													</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>													
														<button type="submit" class="btn button-grey">Repayment Schedule</button>												
													</td>											
												</tr>
												<tr>
													<td>-</td>												
												</tr>
											</tbody>
										</table>	
									</div>
									
								</div><!--col-3---->
								
										
							<div class="col-sm-12 col-lg-3 text-center">
										<a href="{{ url ('investor/myloans') }}">
										<button type="submit" class="btn loan-detail-button">LOAN DETAILS 2</button>							
										</a>		
									<div class="table-responsive"><!---table start-->
										<table class="table table-loan">		
											<tbody>
												
												<tr>
													<td class="tab-head">LOAN 1</td>																										
												</tr>
												<tr>
													<td>1 JAN 2016</td>														
												</tr>
												<tr>
													<td>Approved</td>														
												</tr>
												<tr>
													<td>Monthly Repayment</td>												
												</tr>
												<tr>
													<td>Auction</td>												
												</tr>
												<tr>
													<td>10%</td>												
												</tr>
												<tr>
													<td>														
														<button type="submit" class="btn button-grey">View All Bids</button>												
													</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>													
														<button type="submit" class="btn button-grey">Repayment Schedule</button>												
													</td>											
												</tr>
												<tr>
													<td>-</td>												
												</tr>
											</tbody>
										</table>	
									</div>
									
								</div><!---col--3-->
								
								
								
								
								<div class="col-sm-12 col-lg-3 text-center">
										<a href="{{ url ('investor/myloans') }}">
											<button type="submit" class="btn loan-detail-button">LOAN DETAILS 3</button>				
										</a>	
									<div class="table-responsive"><!---table start-->
										<table class="table table-loan">		
											<tbody>
												<tr>
													<td class="tab-head">LOAN 1</td>																										
												</tr>
												<tr>
													<td>1 JAN 2016</td>														
												</tr>
												<tr>
													<td>Approved</td>														
												</tr>
												<tr>
													<td>Monthly Repayment</td>												
												</tr>
												<tr>
													<td>Auction</td>												
												</tr>
												<tr>
													<td>10%</td>												
												</tr>
												<tr>
													<td>														
														<button type="submit" class="btn button-grey">View All Bids</button>												
													</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>													
														<button type="submit" class="btn button-grey">Repayment Schedule</button>												
													</td>											
												</tr>
												<tr>
													<td>-</td>												
												</tr>
											</tbody>
										</table>	
									</div>									
								</div><!---col--3-->
								
								<div class="col-sm-12 col-lg-3 text-center">
										<a href="{{ url ('investor/myloans') }}">
											<button type="submit" class="btn loan-detail-button">LOAN DETAILS 4</button>								
										</a>		
									<div class="table-responsive"><!---table start-->
										<table class="table table-loan">		
											<tbody>
												<tr>
													<td class="tab-head">LOAN 1</td>																										
												</tr>
												<tr>
													<td>1 JAN 2016</td>														
												</tr>
												<tr>
													<td>Approved</td>														
												</tr>
												<tr>
													<td>Monthly Repayment</td>												
												</tr>
												<tr>
													<td>Auction</td>												
												</tr>
												<tr>
													<td>10%</td>												
												</tr>
												<tr>
													<td>														
														<button type="submit" class="btn button-grey">View All Bids</button>												
													</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>$1,000.00</td>												
												</tr>
												<tr>
													<td>													
														<button type="submit" class="btn button-grey">Repayment Schedule</button>												
													</td>											
												</tr>
												<tr>
													<td>-</td>												
												</tr>
											</tbody>
										</table>	
									</div>
									
								</div><!---col--3-->							
							
							</div><!---col--10-->
							
						</div><!---row--->
					</div>	<!---col 12--->
										
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!---col 12--->

 
@endsection  
@stop
