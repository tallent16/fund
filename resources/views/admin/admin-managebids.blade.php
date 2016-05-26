@extends('layouts.dashboard')
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<div class="col-sm-12 space-around">	
	<div class="panel-primary panel-container"><!--panel container-->
			
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{Lang::get('Manage Loan Bids')}}</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->		
							
			<form method="post">
			<input type="hidden" name="loan_id" value="{{$bidsModel->loan_id}}" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}" />
			<div class="panel-body applyloan"><!--panel body-->					
				<!-- Hidden Variables -->
				<input 	type="hidden" id="partial_sub_allowed" 
						value="{{$bidsModel->partial_sub_allowed}}"/>
				
				<input 	type="hidden" id="loan_apply_amount" 
						value="{{$bidsModel->apply_amount}}"/>

				<input type="hidden" id="min_for_partial_sub" 
						value="{{$bidsModel->min_for_partial_sub}}"/>
				
				<input type="hidden" id="loan_status" 
						value="{{$bidsModel->loan_status}}"/>

				<input type="hidden" name="final_interest_rate" id="wt_avg_int"/>

				<!-- End of Hidden Variables -->

				<div class="col-sm-12" id="managebids"><!--col-sm-12-->	
					<div class="row"><!--row--1-->
						<div class="table-responsive">
							<table class="table table-bordered .tab-fontsize text-left" id="loandetails">		
								<tbody>
									<tr>
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Loan Reference Number')}}
										</td>
										<td>
											{{$bidsModel->loan_reference_number}}
										</td>
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Loan Amount')}}
										</td>
										<td>
											{{number_format($bidsModel->apply_amount, 2, ".", ",")}}
										</td>
									</tr>
									
									<tr>
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Apply Date')}}
										</td>										
										<td class="col-sm-3">
											{{$bidsModel->apply_date}}
										</td>										
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Bid Close Date')}}
										</td>										
										<td class="col-sm-3">
											{{$bidsModel->bid_close_date}}
										</td>		  
									</tr>

									<tr>
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Purpose of Loan')}}
										</td>										
										<td class="col-sm-3">
											{{$bidsModel->purpose_singleline}}
										</td>
										<td class="tab-left-head col-sm-3">
											{{Lang::get('Tenure of Loan')}}
										</td>											
										<td class="col-sm-3">
											{{$bidsModel->loan_tenure}}
										</td>
									</tr>
									
									<tr>
										<td class="tab-left-head">
											{{Lang::get('Accept Partial Funding')}}
										</td>										
										<td>
											{{($bidsModel->partial_sub_allowed == 1)?
											Lang::get('Yes'):Lang::get('No')}}
										</td>										
										<td class="tab-left-head">
											{{Lang::get('Minimum Funding')}}
										</td>										
										<td>
											{{number_format($bidsModel->min_for_partial_sub, 2, ".", ",")}}
										</td>										
									</tr>
									
									<tr>
										<td class="tab-left-head">
											{{Lang::get('Target Interest %')}}
										</td>										
										<td>
											{{number_format($bidsModel->target_interest, 2, ".", ",")}}
										</td>										
										<td class="tab-left-head">
											{{Lang::get('Final Interest %')}}
										</td>										
										<td class="col-sm-3" id="final_interest_rate">
											{{number_format($bidsModel->final_interest_rate, 2, ".", ",")}}
										</td>
									</tr>
									
									<tr>
										<td class="tab-left-head">
											{{Lang::get('Payment Type')}}
										</td>
										<td>
											{{Lang::get($bidsModel->repayment_type)}}
										</td>
										<td class="tab-left-head">
											{{Lang::get('Bid Type')}}
										</td>
										<td class="col-sm-3">
											{{Lang::get($bidsModel->bid_type)}}
										</td>										
									</tr>
																		
									<tr>
										<td class="tab-left-head">
											{{Lang::get('Loan Status')}}
										</td>
										<td>
											{{Lang::get($bidsModel->loan_status_text)}}
										</td>												
									</tr>				
								</tbody>
							</table>
						</div>	
					</div><!-----row-1 end--->
					
					<div class="row"><!--row--2-->
						<div class="table-responsive">
							<table class="table table-bordered .tab-fontsize" id="bidsummary">		
								<tbody>
									<tr>
										<th class="tab-head col-sm-4 text-left">
											{{Lang::get('Investor')}}</th>
										<th class="tab-head col-sm-2 text-left">
											{{Lang::get('Bid Date')}}</th>
										<th class="tab-head col-sm-2 text-right">
											{{Lang::get('Bid Amount')}}</th>								
										<th class="tab-head col-sm-2 text-right">
											{{Lang::get('Bid Interest')}}</th>
										<th class="tab-head col-sm-2 text-right">
											{{Lang::get('Accepted Amount')}}</th>
									</tr>
									<?php $total_accepted_amount = 0;
									$rownum = 0;
									?>
									@foreach($bidsModel->loanBids as $loanbidRow)
										<?php 
											$total_accepted_amount = $total_accepted_amount + 
																		$loanbidRow->accepted_amount; 
											$rownum++;							
										?>
										<tr>
											<td class="col-sm-4 text-left">
												{{$loanbidRow->username}}
											</td>
											<td class="col-sm-2 text-left">
												{{$loanbidRow->bid_datetime}}
											</td>
											<td class="text-right">
												{{number_format($loanbidRow->bid_amount, 2, ".", ",")}}
												<input type="hidden" id="bid_amount_{{$rownum}}"
														class="bid_amount"
														rownum="{{$rownum}}"
														value="{{$loanbidRow->bid_amount}}" />
											</td>								
											<td class="text-right">
												{{number_format($loanbidRow->bid_interest_rate, 2, ".", ",")}}
												<input type="hidden" id="bid_interest_{{$rownum}}"
														class="bid_interest"
														rownum="{{$rownum}}"
														name="bid_interest[{{$loanbidRow->bid_id}}]" 
														value="{{$loanbidRow->bid_interest_rate}}" />
											</td>										
											<td>
												<input 	name="accepted_amount[{{$loanbidRow->bid_id}}]" 
														id="accepted_amount_{{$rownum}}"
														rownum="{{$rownum}}"
														decimal="2"
														value=
														"{{number_format($loanbidRow->accepted_amount, 2, '.',',')}}"
														
														type="text" 
														class="form-control text-right accepted_amount" 
														
														{{($bidsModel->loan_status==LOAN_STATUS_CLOSED_FOR_BIDS)?
															'':'disabled'}}/>												
											</td>	
										</tr>
									@endforeach
										<tr>
											<td class="col-sm-6 text-right" colspan=4>
												{{Lang::get("Total")}}
											</td>
											
											<td class="col-sm-2 text-right">
												<input type="text"
														class="form-control text-right"
														id="total_accepted_amount"
														value="{{number_format($total_accepted_amount, 2, '.', ',')}}"
														
														disabled
														/>
											</td>
												
										
										</tr>
								</tbody>
							</table>
						</div>
					</div><!-----row-2 end--->	
					@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
						@var	$userType	=	"admin"
					@else
						@var	$userType	=	"borrower"
					@endif
					<div class="row"><!---row--3-->	
							@permission('closebid.admin.manageloanbids')					
								<button type="submit" formaction="/{{$userType}}/bidclose" 
										class="btn verification-button"
										onclick="bidCloseClicked()"
										{{($bidsModel->loan_status==LOAN_STATUS_APPROVED)?
											'':'disabled'}}>
									Close Bid</button>
							@endpermission
							@permission('acceptbid.admin.manageloanbids')
								<button type="submit" formaction="/{{$userType}}/bidaccept" 
										class="btn verification-button"
										onclick="acceptBidClicked()"
										
										{{($bidsModel->loan_status==LOAN_STATUS_CLOSED_FOR_BIDS)?
											'':'disabled'}}>
									Accept Bid</button>
							@endpermission
							@permission('cancelbid.admin.manageloanbids')
								<button type="submit" formaction="/{{$userType}}/loancancel" 
										class="btn verification-button"
										id = "cancelbutton"
										onclick="cancelLoanClicked()">
									Cancel Loan</button>
							@endpermission
							@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
								@permission('loandisburse.admin.manageloanbids')
									<button type="submit" formaction="/admin/loandisburse" 
											class="btn verification-button"										
											onclick="disburseLoanClicked()"
											{{($bidsModel->loan_status==LOAN_STATUS_BIDS_ACCEPTED)?
												'':'disabled'}}>
										Disburse Loan</button>
								@endpermission
							@endif						
					</div><!-----row-3 end--->	
					
				</div><!--end col-sm-12-->
			</div><!--end panel body-->		
			</form>
		
	</div><!--end panel container-->
</div>
@endsection
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<!--<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>-->	
	<script src="{{ url('js/admin-managebids.js') }}" type="text/javascript"></script>
@endsection  
@stop
