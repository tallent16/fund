var	formValid	=	false
var	showPopup	=	true
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
			
		if (!formValid) 
			event.preventDefault();
	});

	$("#submit_bid").on('click',function(event){
		validateForm();
	});

	$("#varify_bid").on('click',function(event){
	var	aval_bal	=	numeral($("#available_balance").val()).value();
	var	bid_amount			=	numeral($("#bid_amount").val()).value();
	var	prev_bid_amount		=	numeral($("#prev_bid_amount").val()).value();
	var after_bid_aval_bal	=	(parseFloat(aval_bal) +	parseFloat(prev_bid_amount)) -	parseFloat(bid_amount);
	//~ $("#modal_aval_bal_after").html(numeral(after_bid_aval_bal).format("0,00.00"));
	$("#confirmation_button").attr("disabled",true);
	$("#confirmation_button").prop("disabled",true);
	
	$("#modal_confirm_bid").attr("checked",false);
	$("#modal_confirm_bid").prop("checked",false);
	$('#warning_token_popup').modal('show');
	});

$("#restricted_bid").on('click',function(event){
	var	aval_bal	=	numeral($("#available_balance").val()).value();
	var	bid_amount			=	numeral($("#bid_amount").val()).value();
	var	prev_bid_amount		=	numeral($("#prev_bid_amount").val()).value();
	var after_bid_aval_bal	=	(parseFloat(aval_bal) +	parseFloat(prev_bid_amount)) -	parseFloat(bid_amount);
	//~ $("#modal_aval_bal_after").html(numeral(after_bid_aval_bal).format("0,00.00"));
	$("#confirmation_button").attr("disabled",true);
	$("#confirmation_button").prop("disabled",true);
	
	$("#modal_confirm_bid").attr("checked",false);
	$("#modal_confirm_bid").prop("checked",false);

	$('#warning_token_popup1').modal('show');
	});

$("#buttonid1").click(function(){
$('#warning_token_popup1').modal('hide');
	})


	$("#buttonid").click(function(){
$('#warning_token_popup').modal('hide');
	})

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
	$('#bid_information').find("#confirmation_button").click(function (e) {
		showPopup	=	false;
		$("#bid_information").modal('hide');
		$("#form-bid").submit();
	});
	$("#modal_confirm_bid").click(function(){
		if($(this).is(":checked")) {
			$("#confirmation_button").removeAttr("disabled");
		}else{
			$("#confirmation_button").attr("disabled",true);
			$("#confirmation_button").prop("disabled",true);
		}
	});
	
	getAvailableBalance();
	
});


function cancelLoanBidClicked() {
	// The dialog box utility of jQuery is asynchronous. The execution of the Javascript code will not wait
	// for the user input. Therefore we have a callback function to re-trigger the submission if the 
	// user confirms cancellation
	//~ showPopup	=	false;
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
		//~ alert(data);
		$("#available_balance").val(data);
		
	});
}
function callBidInformationPopup(){
	
	var	aval_bal			=	numeral($("#available_balance").val()).value();
	
	var	bid_amount			=	numeral($("#bid_amount").val()).value();
	var	prev_bid_amount		=	numeral($("#prev_bid_amount").val()).value();
	var after_bid_aval_bal	=	(parseFloat(aval_bal) +	parseFloat(prev_bid_amount)) -	parseFloat(bid_amount);
	//~ $("#modal_aval_bal_after").html(numeral(after_bid_aval_bal).format("0,00.00"));
	
	$("#confirmation_button").attr("disabled",true);
	$("#confirmation_button").prop("disabled",true);
	
	$("#modal_confirm_bid").attr("checked",false);
	$("#modal_confirm_bid").prop("checked",false);
	
	$('#bid_information').modal('show');
  }
function validateForm() {
	
	var	available_balance	=	$("#available_balance").val();
	var	bid_amount			=	numeral($("#bid_amount").val()).value();
	var	bid_interest_rate	=	numeral($("#bid_interest_rate").val()).value();
	var	minimum_bid_amount	=	numeral($("#minimum_bid_amount").val()).value();
	var	total_bid_amount	=	numeral($("#total_bid").val()).value();
	var	prev_bid_amount		=	numeral($("#prev_bid_amount").val()).value();
	var	apply_amount		=	numeral($("#apply_amount").val()).value();
	var amountshouldbid		= 	(parseFloat(total_bid_amount) -	parseFloat(prev_bid_amount));
	var amountshouldbid		= 	(parseFloat(apply_amount) -	parseFloat(amountshouldbid));
	var	errorMesage			=	"";
	
	//~ getAvailableBalance();
	
	AvailableBalance		=	$("#available_balance").val()
		
	if(bid_amount > amountshouldbid){		
		showDialog("","Total funded amount should not be greater than goal amount, You can fund amount maximum : "+amountshouldbid+" (ETH)");
		formValid	= false;
		return;
	}
		
	if(	AvailableBalance	==	0) {
		showDialog("",getBidSystemMessageBySlug("insufficient_available_balance"));
		formValid	= false;
		return;
	}else{
		if(bid_amount	<=	0) {			
			errorMesage			=	getBidSystemMessageBySlug("bid_amount_greater_zero");
		}
	}
				
		//~ if(bid_interest_rate	<=	0) {
			//~ if(errorMesage	==	""	) {
				//~ errorMesage			=	getBidSystemMessageBySlug("bid_interest_greater_zero");
			//~ }
		//~ }
		if(errorMesage	!=	""	) {
			showDialog("",errorMesage);
			formValid	= false;
			return;
		}
		//~ alert("bid_amount:"+bid_amount+" AvailableBalance:"+AvailableBalance);
		if(bid_amount	>	AvailableBalance) {
				showDialog("",getBidSystemMessageBySlug("bid_amount_greater_availbal")	);
				formValid	= false;
				return;
		}
		
		//~ if(bid_amount	<	minimum_bid_amount) {
			//~ showDialog("","The Minimum Bid amount is SGD "+minimum_bid_amount);
			//~ formValid	= false;
			//~ return;
		//~ }
	//~ }
	callBidInformationPopup();
	formValid	= true;
	
}

function getBidSystemMessageBySlug(slugName) {
	var messageTxt	=	"";
	$.each(jsonBidMessage, function(index, value){
		if(slugName	==	jsonBidMessage[index].slug_name)
			messageTxt	=	jsonBidMessage[index].message_text
		
	});
	return messageTxt;
}
