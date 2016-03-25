@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var baseUrl	=	"{{url('')}}"
	</script>
	<script src="{{ asset("js/borrower-myloaninfo.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('borrower-loaninfo.page_heading') )
@section('section')    
@var	$borrowerAllList	=	$BorModMyLoanInfo->allloan_details

<div class="col-sm-12 space-around"> 			
	<div class="row">			
			
			<div class="col-sm-12"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						{{ Lang::get('borrower-loaninfo.loaninfo') }}
					</div>
					
					<div class="col-sm-12 loan-info-wrapper">
						@if(count($borrowerAllList) > 0)
						<div class="row"> 
							<!----col--2--->
							<div class="col-sm-12 col-lg-2">
									<a class="btn btn-lg loan-detail-button" style="visibility:hidden;">Hidden Field														
									</a>											
								<div class="table-responsive"><!---table start-->
									<table class="table text-left">		
										<tbody>																								
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.loan_refer') }}</td>														
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.date_applied') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.status') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.loan_type') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.bid_type') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.target_interest') }} %</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.effective_interest') }} %</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.amount_applied') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.amount_realized') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.repayment_tilldate') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.principal_outstanding') }}</td>												
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
											<table class="table applyloan loan-list-table">		
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
																{{ Lang::get('borrower-loaninfo.view_all_bids') }}
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
																	{{ Lang::get('borrower-loaninfo.repayment_schedule') }}
															</button>												
														</td>											
													</tr>
													<tr>
														<td>
															@if($loanRow->outstanding	!=	"")
																{{$loanRow->outstanding}}
															@else
																--
															@endif	
														</td>												
													</tr>
													<tr>
														<td>
															@switch($loanRow->status)
																@case(LOAN_STATUS_NEW)
																@case(LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
																@case(LOAN_STATUS_APPROVED)
																@case(LOAN_STATUS_PENDING_COMMENTS)
																@case(LOAN_STATUS_CLOSED_FOR_BIDS)
																@var	$url	='borrower/cancelloan/'.base64_encode($loanRow->loan_id)
																	<a 	class="btn btn-lg loan-detail-button" 
																		href="{{url($url)}}">
																		{{Lang::get('Cancel Loan')}}
																	</a>
																@break
																@default
																	<a 	class="btn btn-lg loan-detail-button" style="visibility:hidden;">Hidden Field																	
																	</a>
																	@break
															@endswitch 
															
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
								{{ Lang::get('borrower-loaninfo.no_loan_found') }}
							</p>
						@endif
					</div>	<!---col 12--->
										
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!---col 12--->
<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
 @section ('popup-box_panel_title',Lang::get('borrower-loaninfo.all_repayment_schedule'))
	@section ('popup-box_panel_body')
		
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'repayment_information',
												'aria_labelledby'=>'repayment_information',
												'as'=>'popup-box',
												'class'=>'',
											))
@endsection  
@stop
