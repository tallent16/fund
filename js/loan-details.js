var	formValid	=	false
$(document).ready(function (){  
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	$(".amount-align").on("focus", function() {
		onFocusNumberField(this);
	});

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	});

	/*List one record at a time*/	    
	$("#bid_now").click(function(){
		$(this).hide();
		$('#form-bid').show();
    });
    
	$("#form-bid").on('submit',function(event){
		
		var	available_balance	=	$("#available_balance").val();
		var	bid_amount			=	numeral($("#bid_amount").val()).value();
		var	bid_interest_rate	=	numeral($("#bid_interest_rate").val()).value();
		var	isCancelButton		=	$("#isCancelButton").val();
		var	minimum_bid_amount	=	numeral($("#minimum_bid_amount").val()).value();
		var	errorMesage			=	"";
		getAvailableBalance();
		AvailableBalance		=	$("#available_balance").val()
		if(isCancelButton	==	"no") {
			
			if(bid_amount	<=	0) {
				errorMesage			=	"Bid Amount Should be greater than zero <br>";
			}
					
			if(bid_interest_rate	<=	0) {
				errorMesage			=	"Bid Interest Rate Should be greater than zero <br>";
			}
			if(errorMesage	!=	""	) {
				showDialog("",errorMesage);
				event.preventDefault();
			}
			
			if(	AvailableBalance	==	0) {
				showDialog("","You have insufficient balance to bid");
				event.preventDefault();
			}
			
			if(bid_amount	>	AvailableBalance) {
				showDialog("","Bid Amount should not be greater than Available Balance");
				event.preventDefault();
			}
			
			if(bid_amount	<	minimum_bid_amount) {
				showDialog("","The Minimum Bid amount is SGD "+minimum_bid_amount);
				event.preventDefault();
			}
		}
		if (!formValid) 
			event.preventDefault();
		
	});

	 $("#newCommentBoxButton").on('click',function(){
		
		
		var loanID		=	$("#loanID-XXX").val();
		var userID		=	$("#commentUser-XXX").val();
		var commentTxt	=	$("#newCommentBoxInput").val();
		if(commentTxt	!=	"") {
			var data = {	
						loanID: loanID, 
						userID: userID,
						commentTxt: commentTxt
						};
		
			// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : baseUrl+'/ajax/investor/send_comment', // the url where we want to POST
				data        : data,
				dataType    : 'json'
			})
				// using the done promise callback
				.done(function(data) {
					if(data.status	==	"success"){
						
						$("#newCommentBoxInput").val("");
						commentHtmlTemplate		=	$("#commentTemplate").html();
						commentHtmlTemplate 	= 	commentHtmlTemplate.replace(/COMMENTTEXT/g, commentTxt);
						commentHtmlTemplate 	= 	commentHtmlTemplate.replace(/XXX/g, data.comment_id);
						$(".mainCommentDivBlock").prepend(commentHtmlTemplate);
						callSubmitReplyActionFunc();
					}
				});
		}
	});
	
});


function cancelLoanBidClicked() {
	// The dialog box utility of jQuery is asynchronous. The execution of the Javascript code will not wait
	// for the user input. Therefore we have a callback function to re-trigger the submission if the 
	// user confirms cancellation
	
	if (formValid) {
		return;
	} 
	
	retval = showDialogWithOkCancel("", "Do you want to proceed with the cancellation Bid", "cancelLoanBidFeedback");
	
}

function cancelLoanBidFeedback(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		formValid = true;
		$('#isCancelButton').val("yes");
		$("#cancel_bid").click()
	} else {
		formValid = false;
	}
}
function LoanBidClicked() {
	
	formValid = true;
	
}

function getAvailableBalance() {
	
	$.ajax({
	  type: "POST",
	  async : false,
	  cache:false,
	  url: baseUrl+"/investor/ajax/availableBalance",
	  
	}).done(function(data) {
		$("#available_balance").val(data);
	});
}
