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
				showDialog("", "Acccepted amount cannot be more than the Bid Amount");
				$(this).val("0.00");
				return;
			}

			$(".accepted_amount").each (function() {
				bid_accepted_amount	= numeral($(this).val()).value();
				loan_accept_amt	+= bid_accepted_amount;
			})		

			if (loan_accept_amt > apply_amount) {
				showDialog("", "Total acccepted amount cannot be more than the Loan Applied Amount");
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
					showDialog("", "Loan has not been sufficiently subscribed. Cannot close bids");
					formValid = false;
				} else {
					formValid = true;
				}
			} else {
				showDialog("", "Loan has not been sufficiently subscribed. Cannot close bids");
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
					showDialog("", "Loan has not been sufficiently subscribed .Cannot close bids");
					formValid = false;
				} else {
					formValid = true;
				}
			} else {
				showDialog("", "Loan has not been sufficiently subscribed. Cannot close bids");
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
		
		retval = showDialogWithOkCancel("", "Warning!! Once cancelled you cannot undo this action. Do you want to proceed with the cancellation", "cancelLoanFeedback");
		
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
	
