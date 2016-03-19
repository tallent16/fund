@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','My Loans') )
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
																["class" => "selectpicker"]) 
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
								</div>
							</form>
						</div>
						<div class="row"> 
							@if(count($investortAllLoan) > 0)
								<div class="col-sm-12 col-lg-2">										
									<div class="table-responsive"><!---table start-->
										<table class="table tab-label">		
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
													<td>{{ Lang::get('Target Interest Range')}}</td>												
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
													<td>{{ Lang::get('Interest %bid')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Status')}}</td>												
												</tr>										
											</tbody>
										</table>	
									</div>							
								</div> <!----col--2--->
							
								<div class="col-sm-12 col-lg-10 loan-details">
									@foreach($investortAllLoan as $loanRow)
										@var	$loan_url	=	'investor/myloans/'.base64_encode($loanRow->loan_id)
										<div class="col-sm-12 col-lg-3 text-center">									
												<a 	href="{{ url ($loan_url) }}"
													class="btn btn-lg loan-detail-button">
													{{$loanRow->viewStatus}}
												</a>				
																		
											<div class="table-responsive"><!---table start-->
												<table class="table table-loan loan-list-table">		
													<tbody>												
														<tr>
															<td class="tab-head">{{$loanRow->loan_reference_number}}</td>																										
														</tr>
														<tr>
															<td>{{$loanRow->borrower_name}}</td>														
														</tr>
														<tr>
															<td>{{$loanRow->borrower_risk_grade}}</td>														
														</tr>
														<tr>
															<td>{{$loanRow->target_interest}}%</td>												
														</tr>
														<tr>
															<td>{{$loanRow->amount_applied}}</td>												
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
													</tbody>
												</table>	
											</div>
											
										</div><!--col-3---->
									@endforeach
								</div><!---col--10-->
						@else
							<p style="padding:10px">
								{{ Lang::get('No Loan Founded') }}
							</p>
						@endif
						</div><!---row--->
					</div>	<!---col 12--->
										
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!---col 12--->

 
@endsection  
@stop
