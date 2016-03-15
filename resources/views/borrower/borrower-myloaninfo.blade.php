@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var baseUrl	=	"{{url('')}}"
	</script>
	<script src="{{ asset("js/borrower-myloaninfo.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','My Loans') )
@section('section')    
@var	$borrowerAllList	=	$BorModMyLoanInfo->allloan_details

<div class="col-sm-12"> 			
	<div class="row">			
			
			<div class="col-sm-12 space-around"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						LOAN INFO
					</div>
					
					<div class="col-sm-12 loan-info-wrapper">
						@if(count($borrowerAllList) > 0)
						<div class="row"> 
							<!----col--2--->
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
							<!---col--10-->
							<div class="col-sm-12 col-lg-10 loan-details">
									@foreach($borrowerAllList as $loanRow)
									
									<div class="col-sm-12 col-lg-3 text-center">		
											@if(($loanRow->status	==	BORROWER_STATUS_NEW) || 
															($loanRow->status	==	BORROWER_STATUS_COMMENTS_ON_ADMIN))
												@var	$loan_url	=	'borrower/applyloan/'.base64_encode($loanRow->loan_id)
												@var	$bid_url	=	'borrower/myloans/'
												@var	$bid_url	=	$bid_url.base64_encode($loanRow->loan_id."_bids")
											@else
												@var	$loan_url	=	'borrower/myloans/'.base64_encode($loanRow->loan_id)
												@var	$bid_url	=	'borrower/myloans/'
												@var	$bid_url	=	$bid_url.base64_encode($loanRow->loan_id."_bids")
											@endif
											<a href="{{ url ($loan_url) }}"
												class="btn btn-lg loan-detail-button">
												{{$loanRow->viewStatus}}
											</a>				
																	
										<div class="table-responsive"><!---table start-->
											<table class="table table-loan loan-list-table">		
												<tbody>												
													<tr>
														<td class="tab-head">
															{{$loanRow->loan_reference_number}}
														</td>																										
													</tr>
													<tr>
														<td>
															{{$loanRow->apply_date}}
														</td>														
													</tr>
													<tr>
														<td>
															{{$loanRow->statusText}}
														</td>															
													</tr>
													<tr>
														<td>
															@if($loanRow->repayment_type	!=	"")
																{{$loanRow->repayment_type}}
															@else
																--
															@endif
														</td>												
													</tr>
													<tr>
														<td>
															@if($loanRow->bid_type	!=	"")
																{{$loanRow->bid_type}}
															@else
																--
															@endif
															
														</td>												
													</tr>
													<tr>
														<td>
															@if($loanRow->target_interest	!=	"")
																{{$loanRow->target_interest}}
															@else
																--
															@endif															
														</td>													
													</tr>
													<tr>
														<td><a href="{{ url ($bid_url) }}"
																class="btn button-grey">
																View All Bids
															</a>														
														</td>												
													</tr>
													<tr>
														<td>
															@if($loanRow->amount_applied	!=	"")
																{{$loanRow->amount_applied}}
															@else
																--
															@endif
															
														</td>												
													</tr>
													<tr>
														<td>
															@if($loanRow->amount_realized	!=	"")
																{{$loanRow->amount_realized}}
															@else
																--
															@endif															
														</td>													
													</tr>
													<tr>
														<td>												
															<button type="button" 
																	class="btn button-grey repayment_schedule_btn"
																	data-loan-id="{{$loanRow->loan_id}}">
																	Repayment Schedule
															</button>												
														</td>											
													</tr>
													<tr>
														<td>
															{{$loanRow->outstanding}}
														</td>												
													</tr>
												</tbody>
											</table>	
										</div>
										
									</div><!--col-3---->
									
								@endforeach
							
							</div><!---col--10-->
							
						</div><!---row--->
						@else
							<p>
								No Loan Found For this Borrower
							</p>
						@endif
					</div>	<!---col 12--->
										
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!---col 12--->
<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
 @section ('popup-box_panel_title','All Repayment Schedule')
	@section ('popup-box_panel_body')
		
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'repayment_information',
												'aria_labelledby'=>'repayment_information',
												'as'=>'popup-box',
												'class'=>'',
											))
@endsection  
@stop
