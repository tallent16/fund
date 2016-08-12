@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		//~ $(document).ready(function(){   
			//~ var newHeight = $(".loan-list-table tr:nth-child(2) td").innerHeight();
			//~ $(".myloan-table-left-label tr:nth-child(2) td").css("height", newHeight+"px");  //Borrower's Name label height updated based on right side data
		//~ });
	</script>
	<script src="{{ asset("js/investor-myloaninfo.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('My Loans') )
@section('section')    
@var	$investortAllLoan	=	$InvModMyLoanInfo->allLoanInfo

<div class="col-sm-12"> 			
	<div class="row">			
			
			<div class="col-sm-12 space-around"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						{{ Lang::get('LOAN INFO')}}
					</div>
					
					<div class="col-sm-12 loan-info-wrapper">
						<div id="filter_area">
							<form >
								<div class="row">	
									<div class="col-sm-12 col-lg-3"> 														
										<div class="form-group"><br>	
											<strong>{{ Lang::get('Loan Status') }}</strong>							
											{{ 
												Form::select('loanstatus_filter', 
																$InvModMyLoanInfo->filterloanStatusList, 
																$InvModMyLoanInfo->filterloanStatusValue,
																["class" => "selectpicker",
																"filter_field" => "Yes"]) 
											}} 
										</div>
									</div>
									<div class="col-sm-12 col-lg-3"> 														
										<div class="form-group"><br><br>			
											<button type="submit" class="btn verification-button">
												{{ Lang::get('borrower-loanlisting.apply_filter') }}			
											</button>
										</div>	
									</div>	
<!--
									<div class="col-sm-12 col-lg-6 text-right"> 
										<ul class="pagination">
											<li>
												<a href="javascript:void(0)" id="prev">
													<i class="fa fa-chevron-circle-left"></i>
												</a>
											</li>
											<li>
												<a href="javascript:void(0)" id="next">
													<i class="fa fa-chevron-circle-right"></i>
												</a>
											</li>	
										</ul>
									</div>
-->
								</div>
							</form>
						</div>
						<div class="row"> 
							@if(count($investortAllLoan) > 0)
								<div class="col-sm-5 col-lg-2">		
									<a class="btn btn-lg loan-detail-button" style="visibility:hidden;">Hidden Field														
									</a>								
									<div class="table-responsive"><!---table start-->
										<table class="table text-left myloan-table-left-label">		
											<tbody>																								
												<tr>
													<td>{{ Lang::get('Loan Reference')}}</td>														
												</tr>
												<tr>
													<td>{{ Lang::get('Borrower\'s Name')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Grade')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Target Interest')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Applied')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Offered')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Accepted')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Interest % bid')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Status')}}</td>												
												</tr>	
												<tr>
													<td>
														
													</td>
												</tr>									
											</tbody>
										</table>	
									</div>							
								</div> <!----col--2--->
							<div class="divs text-right">
<!--
								
								<a class="prev"><i class="fa fa-chevron-circle-left"></i></a> <a class="next"><i class="fa fa-chevron-circle-right"></i></a>
-->

								<div class="col-sm-7 col-lg-10 loan-details pagination">
									
									@foreach($investortAllLoan as $loanRow)
										@var	$loan_url	=	'investor/myloans/'.base64_encode($loanRow->loan_id)
										<div class="col-sm-12 col-lg-3 text-center">									
												<a 	href="{{ url ($loan_url) }}"
													class="btn btn-lg loan-detail-button">
													{{$loanRow->viewStatus}}
												</a>				
																		
											<div class="table-responsive"><!---table start-->
												<table class="table applyloan loan-list-table">		
													<tbody>												
														<tr>
															<td>
																@if($loanRow->loan_reference_number	!=""	)
																	{{$loanRow->loan_reference_number}}
																@else
																	--
																@endif
															</td>				
														</tr>
														<tr>
															<td>
																@if($loanRow->borrower_name	!=""	)
																	{{$loanRow->borrower_name}}
																@else
																	--
																@endif
															</td>														
														</tr>
														<tr>
															<td>
																@if($loanRow->borrower_risk_grade	!=""	)
																	{{$loanRow->borrower_risk_grade}}
																@else
																	--
																@endif
															</td>														
														</tr>
														<tr>
															<td>
																@if($loanRow->target_interest	!=""	)
																	{{$loanRow->target_interest}}
																@else
																	--
																@endif																
															</td>												
														</tr>
														<tr>
															<td>
																@if($loanRow->amount_applied	!=""	)
																	{{$loanRow->amount_applied}}
																@else
																	--
																@endif
															</td>												
														</tr>
														<tr>
															<td>
																@if($loanRow->amount_offered	!=""	)
																	{{$loanRow->amount_offered}}
																@else
																	--
																@endif
															</td>												
														</tr>
														<tr>
															<td>
																@if($loanRow->amount_accepted	!=""	)
																	{{$loanRow->amount_accepted}}
																@else
																	--
																@endif
															</td>													
														</tr>
														<tr>
															<td>
																@if($loanRow->insterest_bid	!=""	)
																	{{$loanRow->insterest_bid}}%
																@else
																	--
																@endif
															</td>											
														</tr>
														<tr>
															<td>
																@if($loanRow->status	!=""	)
																	{{$loanRow->status}}
																@else
																	--
																@endif
															</td>											
														</tr>	
														<tr>
															<td>
																
															</td>
														</tr>											
													</tbody>
												</table>	
											</div>
											
										</div><!--col-3---->
									@endforeach
								</div><!---col--10-->
									<a class="prev"><i class="fa fa-chevron-circle-left"></i></a> <a class="next"><i class="fa fa-chevron-circle-right"></i></a>
							</div>	
							</div><!---row--->
						@else
							<p style="padding:10px">
								{{ Lang::get('No Loans Found') }}
							</p>
						@endif
						
					</div>	<!---col 12--->
									
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!---col 12--->

 
@endsection  
@stop
