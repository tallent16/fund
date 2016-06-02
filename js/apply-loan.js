$(document).ready(function(){	
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});	
	
	$(".borrower_doc_download").on("click",function(){
		var	loan_doc_url	=	$(this).attr("data-download-url");
			loan_doc_url	=	loan_doc_url+"_"+ new Date().getTime();
			window.location	=	loan_doc_url;
	});
	$("#save_button").on("click",function(){
		$("#isSaveButton").val("yes");
	});
	$("#form-applyloan").submit(function( event ) {

		var	isSaveButtonClicked		=	$("#isSaveButton").val();
		if(isSaveButtonClicked	!=	"yes") {
			
			if(callTabValidateFunc())
				event.preventDefault();
			if(validateTab("documents_submitted"))
				event.preventDefault();
			if($("#hidden_loan_statusText").val()	==	"corrections_required") {
				if(checkAdminAllCommentsClosed()){
					showDialog("","Please close the corrections and submit again for approval");
					event.preventDefault();
					$("#submit_button").show();
					return;
				}
			}
			checkAjaxValidation();
			if ($("#loans_info").has('.has-error').length > 0) {
				event.preventDefault();
				
			}
		}
		
		
	});
	
	$("#next_button").click(function(){
		
		callTabValidateFunc();
	});
	$(".amount-align").on("focus", function() {
		onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	});
	
	$("input[name=partial_sub_allowed]:radio").change(function () {
		if ($(this).val() == '1') {
			
			$("#min_for_partial_sub").attr("disabled",false);
		}
		else if ($(this).val() == '2') {
			$("#min_for_partial_sub").attr("disabled",true);
			$("#min_for_partial_sub").val("");
			var $parentTag = $("#min_for_partial_sub_parent");
			$parentTag.removeClass("has-error");
			$parentTag.find("span.error").remove();
		}
	});
	 $(".nav-tabs > li").click(function(){
		$("#next_button").show();
		$("#submit_button").hide();
		if($(this).hasClass("disabled"))
			return false;
		if($(this).find("a").attr("href")	==	"#documents_submitted") {
			if($("#hidden_loan_statusText").val()	==	"") {
				$("#next_button").hide();
				$("#submit_button").show();
			}
		}
		if($(this).find("a").attr("href")	==	"#comments") {
			$("#next_button").hide();
			$("#submit_button").show();
		}
	});
	
	//$("input[name=partial_sub_allowed]:radio").trigger("change");
	callcheckAllTabFilledFunc();
});		
function callTabValidateFunc() {
	
	$('span.error').remove();
	$('.has-error').removeClass("has-error");
	var active = $("ul.nav-tabs li.active a");
	var	cur_tab		=	active.attr("href");
	cur_tab			=	cur_tab.replace("#","");
	$("#next_button").show();
	$("#submit_button").hide();
	if(validateTab('loans_info')) {
		$('.nav-tabs a[href="#loans_info"]').tab('show');
		return true;
	}
	if(cur_tab	==	"loans_info") {
		$('.nav-tabs a[href="#documents_submitted"]').tab('show');
		$('a[href="#documents_submitted"]').parent().removeClass("disabled");	
		if($("#hidden_loan_status").val()	==	""){
			$("#next_button").hide();
			$("#submit_button").show();
		}	
	}
	
	if(cur_tab	==	"documents_submitted") {
		$('.nav-tabs a[href="#comments"]').tab('show');
		$("#next_button").hide();
		$("#submit_button").show();
	}
	return false;
}
function validateTab(cur_tab) {
	
	$("#"+cur_tab+" :input.required").each(function(){
		
		var	input_id	=	$(this).attr("id");
		var inputVal 	= 	$(this).val();
		
		var $parentTag = $("#"+input_id+"_parent");
		if(inputVal == ''){
			if($(this).hasClass("jfilestyle")) {
				if($("#"+input_id+"_hidden").val() == ''){
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
				}
			}else{
				$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
			}
		}
	});
	$partial_sub		=	$("input[name=partial_sub_allowed]:checked").val();
	$partial_sub_amt	=	$("#min_for_partial_sub").val();
	if($partial_sub	==	1) {
		if($partial_sub_amt	==	"") {
			var $parentTag = $("#min_for_partial_sub_parent");
			$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
			$('.nav-tabs a[href="#loans_info"]').tab('show');
			
		}	
	}
	if ($("#"+cur_tab).has('.has-error').length > 0)
		return true;
	else
		return false;
}
function callcheckAllTabFilledFunc() {
	var	completeLoanDetails	=	$("#completeLoanDetails").val();	
	if(completeLoanDetails){//check Company Info Filled
		$('.nav-tabs a[href="#documents_submitted"]').parent().removeClass("disabled");
		//Enable the Director Info Tab
	}
}
function checkTabFilled(cur_tab) {
	var	cnt	=	0;
	$("#"+cur_tab+" :input.required").each(function(){
		var inputVal 	= 	$(this).val();
		var	input_id	=	$(this).attr("id");
		if(inputVal == ''){
					cnt++;
		}
	});
	if (cnt == 0)
		return true;
	else
		return false;
}

function checkAjaxValidation() {
	
			var loan_amount			=	numeral($("#loan_amount").val()).value();
			//~ var bidcloseDate		=	$("#date-picker-2").val();
			var targetInterest		=	$("#target_interest").val();
			var partialSubAllowed	=	$("input[name=partial_sub_allowed]:radio:checked").val();
			var partialSubAmount	=	numeral($("#min_for_partial_sub").val()).value();
			
			var data = {	
						loan_amount:loan_amount,
						//~ bidcloseDate:bidcloseDate,
						targetInterest:targetInterest,
						partialSubAllowed:partialSubAllowed,
						partialSubAmount:partialSubAmount
						};
				// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : baseUrl+'/borrower/ajaxApplyLoan/checkvalaidation', // the url where we want to POST
				data        : data,
				async : false,
				cache:false,
				dataType    : 'json'
			})
				// using the done promise callback
				.done(function(data) {
					if(data.status	==	"error"){
						if(data.row.loan_amountErr	!="") {
							if(loan_amount!="") {
								$("#loan_amount_parent").addClass('has-error').
														append('<span class="control-label error">'+data.row.loan_amountErr+'</span>');
							}	
						}
						//~ if(data.row.bidcloseDateErr	!="")
							//~ $("#date-picker-2_parent").addClass('has-error').
													//~ append('<span class="control-label error">'+data.row.bidcloseDateErr+'</span>');
						if(data.row.target_interestErr	!="")
							$("#target_interest_parent").addClass('has-error').
													append('<span class="control-label error">'+data.row.target_interestErr+'</span>');
						if(data.row.partialSubAmountErr	!="")
							$("#min_for_partial_sub_parent").addClass('has-error').
													append('<span class="control-label error">'+data.row.partialSubAmountErr+'</span>');
						$('.nav-tabs a[href="#loans_info"]').tab('show');
						$("#next_button").show();
						$("#submit_button").hide();
					}
				});
}
