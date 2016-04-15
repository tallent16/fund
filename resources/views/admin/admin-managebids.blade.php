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
				
				<div class="col-sm-12" id="managebids"><!--col-sm-12-->	
									
					<div class="row"><!--row--1-->
						
						<div class="table-responsive">
							<table class="table table-bordered .tab-fontsize text-left" id="loandetails">		
								<tbody>
									<tr>
										<td class="tab-left-head col-sm-3">Purpose of Loan</td>
										<td class="col-sm-3">{{$bidsModel->purpose_singleline}}</td>
										<td class="tab-left-head col-sm-3">Bid Close Date</td>
										<td class="col-sm-3">{{$bidsModel->bid_close_date}}
										</td>																				  
									</tr>
									
									<tr>
										<td class="tab-left-head">Loan Amount</td>
										<td>{{number_format($bidsModel->apply_amount, 2, ".", ",")}}
										<input type="hidden" id="loan_apply_amount" value="{{$bidsModel->apply_amount}}"/>
										</td>
										<td class="tab-left-head">Accept Partial Subscription</td>								
										<td>{{($bidsModel->partial_sub_allowed == 1)?
											Lang::get('Yes'):Lang::get('No')}}
											<input type="hidden" id="partial_sub_allowed" 
											value="{{$bidsModel->partial_sub_allowed}}"/>
										</td>
									</tr>
									<tr>
										<td class="tab-left-head">Tenure of Loan</td></td>	
										<td>{{$bidsModel->loan_tenure}}</td>
										<td class="tab-left-head">Minimum Limit For Partial Subscription</td>								
										<td>{{number_format($bidsModel->min_for_partial_sub, 2, ".", ",")}}
										<input type="hidden" id="min_for_partial_sub" 
										value="{{$bidsModel->min_for_partial_sub}}"/>
										</td>					
									</tr>
									<tr>
										<td class="tab-left-head">Target Interest%</td>	
										<td>{{number_format($bidsModel->target_interest, 2, ".", ",")}}</td>
										<td class="tab-left-head">Payment Type</td>								
										<td>{{Lang::get($bidsModel->repayment_type)}}</td>						
									</tr>
									<tr>
										<td class="tab-left-head">Loan Reference Number</td>	
										<td>{{$bidsModel->loan_reference_number}}</td>
										<td class="tab-left-head">Status</td>								
										<td>{{Lang::get($bidsModel->loan_status_text)}}
										<input type="hidden" id="loan_status" value="{{$bidsModel->loan_status}}"/>
										</td>					
									</tr>	
									<tr>
										<td class="tab-left-head">Bid Type</td>								
										<td class="col-sm-3">{{Lang::get($bidsModel->bid_type)}}</td>												
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
									$rownum = 1;
									?>
									@foreach($bidsModel->loanBids as $loanbidRow)
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
														value="{{$loanbidRow->bid_interest_rate}}" />
											</td>										
											<td>
												<input 	name="accepted_amount[{{$loanbidRow->investor_id}}]" 
														id="accepted_amount_{{$rownum}}"
														rownum="{{$rownum}}"
														value=
														"{{number_format($loanbidRow->accepted_amount, 2, '.',',')}}"
														type="text" 
														onchange="accepted_amount_changed()"
														class="form-control text-right accepted_amount" 
														{{($bidsModel->loan_status==LOAN_STATUS_CLOSED_FOR_BIDS)?
															'':'disabled'}}
												/>
											</td>	
										</tr>
									@endforeach
										<tr>
											<td class="col-sm-6 text-right" colspan=3>
												{{Lang::get("Total")}}
											</td>
											
											<td class="col-sm-2 text-right">
												<input type="text"
														class="form-control text-right"
														id="wt_avg_int"/>
											</td>
											
											<td class="col-sm-2 text-right">
												<input type="text"
														class="form-control text-right"
														id="total_accepted_amount"/>
											</td>
												
										
										</tr>
								</tbody>
							</table>
						</div>
					</div><!-----row-2 end--->	
					
					<div class="row"><!---row--3-->
						<div class="col-sm-12 space-around"> 
							<div class="">
								<button type="submit" formaction="/admin/bidclose" 
										class="btn verification-button"
										onclick="bidCloseClicked()"
										{{($bidsModel->loan_status==LOAN_STATUS_APPROVED)?
											'':'disabled'}}>
									Close Bid</button>
								<button type="submit" formaction="/admin/bidaccept" 
										class="btn verification-button"
										onclick="acceptBidClicked()"
										{{($bidsModel->loan_status==LOAN_STATUS_CLOSED_FOR_BIDS)?
											'':'disabled'}}>
									Accept Bid</button>
								<button type="submit" formaction="/admin/loancancel" 
										class="btn verification-button"
										id = "cancelbutton"
										onclick="cancelLoanClicked()">
									Cancel Loan</button>
								<button type="submit" formaction="/admin/loandisburse" 
										class="btn verification-button"
										
										onclick="disburseLoanClicked()"
										{{($bidsModel->loan_status==LOAN_STATUS_BIDS_ACCEPTED)?
											'':'disabled'}}>
									Disburse Loan</button>
							</div>
						</div>
					</div><!-----row-3 end--->	
				</div><!--end col-sm-12-->
			</div><!--end panel body-->		
			</form>
		
	</div><!--end panel container-->
</div>

@endsection

@section('bottomscripts')

	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>

	<script>
	var formValid = false;
	
	$(document).ready(function() {
		accepted_amount_changed();
		
	})
	
	$("form").submit(function(event) {
		if (!formValid) 
			event.preventDefault();

	})


	function bidCloseClicked() {
		var bid_amount = 0;
		$(".bid_amount").each (function() {
			bid_amount = bid_amount + Number($(this).val().valueOf());
		})
		
		if (Number($("#loan_apply_amount").val()) > bid_amount) {
			if (Number($("#partial_sub_allowed").val()) == 1) {
				if (Number($("#min_for_partial_sub").val()) > bid_amount) {
					showDialog("", "{{Lang::get('Loan has not been sufficiently subscribed. Cannot close bids')}}");
					formValid = false;
				} else {
					formValid = true;
				}
			} else {
				showDialog("", "{{Lang::get('Loan has not been sufficiently subscribed. Cannot close bids')}}");
				formValid = false;
			}
		} else {
			formValid = true;
		}
	}

	function acceptBidClicked() {
		var accepted_amount = 0;
		$(".accepted_amount").each (function() {
			accepted_amount = accepted_amount + Number($(this).val().valueOf());
		})
		
		if (Number($("#loan_apply_amount").val()) > accepted_amount) {
			if (Number($("#partial_sub_allowed").val()) == 1) {
				if (Number($("#min_for_partial_sub").val()) > accepted_amount) {
					showDialog("", "{{Lang::get('Loan has not been sufficiently subscribed .Cannot close bids')}}");
					formValid = false;
				} else {
					formValid = true;
				}
			} else {
				showDialog("", "{{Lang::get('Loan has not been sufficiently subscribed. Cannot close bids')}}");
				formValid = false;
			}
		} else {
			formValid = true;
		}

	}
	
	function cancelLoanClicked() {
		
		if (formValid) {
			return;
		} 
		
		retval = showDialogWithOkCancel("", "{{Lang::get('Warning!! Once cancelled you cannot undo this action. Do you want to proceed with the cancellation')}}", "cancelLoanFeedback");
		
	}
	
	function cancelLoanFeedback(retval) {
		if (retval == 1) {
			formValid = true;
			$("#cancelbutton").click()
		} else {
			formValid = false;
		}
	}
	
	function disburseLoanClicked() {
		formValid = true;
	}
	

	function accepted_amount_changed() {
		

		
		var accepted_amount 	= 0;
		var	apply_amount 		= Number($("#loan_apply_amount").val());
		var partial_sub_allowed = Number($("#partial_sub_allowed").val());
		var partial_limit		= Number($("#min_for_partial_sub").val());
		var	wtAvgInterest		= 0;
		
		$(".accepted_amount").each (function() {
			bid_accepted_amount	= Number($(this).val().valueOf());
			
		})

		$(".accepted_amount").each (function() {
			accepted_amount = accepted_amount + bid_accepted_amount;
			rownum			= $(this).attr("rownum");
			bid_interest	= Number($("bid_interest_"+rownum).val());
			wtAvgInterest	= wtAvgInterest + 
								(accepted_amount / bid_accepted_amount) * bid_interest;
			
		})

		$("#total_accepted_amount").val(numeral(accepted_amount).format("0,000.00"));
		$("#wt_avg_int").val(numeral(wtAvgInterest).format("0,000.00"));
		
		
	}
	</script>
@endsection  
@stop
