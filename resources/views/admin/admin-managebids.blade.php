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
														value="{{$loanbidRow->bid_interest_rate}}" />
											</td>										
											<td>
												<input 	name="accepted_amount[{{$loanbidRow->investor_id}}]" 
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
		// The Weighted average interest is not stored in DB till the loan is accepted
		// For simplicity, we are calculating the Wt Average Interest each time this page loads
		calcAvgInterest();
		
		$(".accepted_amount").on("focus", function() {
			onFocusNumberField(this);
		})
		
		$(".accepted_amount").on("blur", function() {
			onBlurNumberField(this)
		})
		
		$(".accepted_amount").on("change", function() {
			// When the accepted amount is changed, check whether the total accepted
			// amount is greater than the loan apply amount
			var this_accept_amt 	= numeral($(this).val()).value();
			var rownum 				= $(this).attr("rownum");
			var this_bid_amt		= numeral($("#bid_amount_"+rownum).val()).value()
			var	apply_amount 		= numeral($("#loan_apply_amount").val()).value();
			var loan_accept_amt 	= 0;
			
			if (this_accept_amt > this_bid_amt) {
				showDialog("", "{{Lang::get('Acccepted amount cannot be more than the Bid Amount')}}");
				$(this).val("0.00");
				return;
			}

			$(".accepted_amount").each (function() {
				bid_accepted_amount	= numeral($(this).val()).value();
				loan_accept_amt	+= bid_accepted_amount;
			})		

			if (loan_accept_amt > apply_amount) {
				showDialog("", "{{Lang::get('Total acccepted amount cannot be more than the Loan Applied Amount')}}");
				$(this).val("0.00");
				return;
			}
			$("#total_accepted_amount").val(numeral(loan_accept_amt).format("0,000.00"))
			calcAvgInterest();
		})
		
	})
	
	$("form").submit(function(event) {
		// This function is called when the form is submitted, after the button clicked event function
		// of each button is called. The button clicked event holds the validation for the respective
		// actions. The global variable formValid is updated in these functions
		if (!formValid) 
			event.preventDefault();

	})

	function bidCloseClicked() {
		var bid_amount = 0;
		$(".bid_amount").each (function() {
			bid_amount = bid_amount + numeral($(this).val()).value();
		})
		
		if (Number($("#loan_apply_amount").val()) > bid_amount) {
			if (numeral($("#partial_sub_allowed").val()).value() == 1) {
				if (numeral($("#min_for_partial_sub").val()).value() > bid_amount) {
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
			accepted_amount = accepted_amount + numeral($(this).val()).value();
		})
		
		if (numeral($("#loan_apply_amount").val()).value() > accepted_amount) {
			if (numeral($("#partial_sub_allowed").val()).value() == 1) {
				if (numeral($("#min_for_partial_sub").val()).value() > accepted_amount) {
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
		// The dialog box utility of jQuery is asynchronous. The execution of the Javascript code will not wait
		// for the user input. Therefore we have a callback function to re-trigger the submission if the 
		// user confirms cancellation
		
		if (formValid) {
			return;
		} 
		
		retval = showDialogWithOkCancel("", "{{Lang::get('Warning!! Once cancelled you cannot undo this action. Do you want to proceed with the cancellation')}}", "cancelLoanFeedback");
		
	}
	
	function cancelLoanFeedback(retval) {
		// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
		// OK or Cancel buttons.
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

	function calcAvgInterest() {
		var loan_accept_amt 	= numeral($("#total_accepted_amount").val()).value();
		var	apply_amount 		= numeral($("#loan_apply_amount").val()).value();
		var partial_sub_allowed = numeral($("#partial_sub_allowed").val()).value();
		var partial_limit		= numeral($("#min_for_partial_sub").val()).value();
		var	wtAvgInterest		= 0;

		if (loan_accept_amt > 0) {
			$(".accepted_amount").each (function() {
				rownum				= $(this).attr("rownum");
				bid_accepted_amount	= numeral($(this).val()).value();
				bid_interest		= numeral($("#bid_interest_"+rownum).val()).value();
				wtAvgInterest		= wtAvgInterest + 
									(bid_accepted_amount / loan_accept_amt) * bid_interest;

			})

		}
		wtAvgInterest 	=	Math.round10(wtAvgInterest, -2);
		$("#wt_avg_int").val(numeral(wtAvgInterest).format("0,000.00"));
		$("#final_interest_rate").text(numeral(wtAvgInterest).format("0,000.00"));
		
	}
	</script>
@endsection  
@stop
