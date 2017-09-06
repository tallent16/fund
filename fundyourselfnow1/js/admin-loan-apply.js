var formLoanValid	=	true;
$(document).ready(function (){  

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#_token').val()
		}
	});
	$("#add_loanapply_comment_button").click(function(){
		screenType	=	$(this).attr("data-screen-type");
		addNewLoanApplyCommentRow(screenType);	
		$(".hide-comments").css("display", "none"); 
    });
	$("#returnback_loanapply_button").click(function(){
		
		$("#admin_process").val("return_borrower");
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/return_borrower");
		if( ($('#commentBoxContainer .commentClass').length == 0)){
			errMessage	=	"There is no open comments to return back to creator";
			showDialog("",errMessage);
			$('.nav-tabs a[href="#comments"]').tab('show');
			formLoanValid	=	false;
		}else{
			var listUnCheck	=	$('#commentBoxContainer .commentClass').length;
			var listChecked	=	$('#commentBoxContainer .commentClass:checked').length;
			if(listUnCheck	==	listChecked) {
				errMessage	=	"There is no open comments to return back to creator";
				showDialog("",errMessage);
				$('.nav-tabs a[href="#comments"]').tab('show');
				formLoanValid	=	false;
				
			}else {
				formLoanValid	=	true;
				
			}
		}
		console.log(formLoanValid);
		$("#form-profile").submit();
    });
	$("#approve_loanapply_button").click(function(){
	
		$("#admin_process").val("approve");
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/approve");
		if($('#commentBoxContainer .commentClass').not(':checked').length){
			errMessage	=	"Please close all comments before approve";
			showDialog("",errMessage);
			
			$('.nav-tabs a[href="#comments"]').tab('show');
			formLoanValid	=	true;
			return;
		}
		
		$("#form-profile").submit();
    });
	$("#close_comment_button").click(function(){
		$(".commentClass").each(function() {
			var	id	=	$(this).attr("id").replace("comment_status_","");
			$(this).attr("checked",true);
			$(this).prop("checked",true);
			$("#comment_status_hidden_"+id).val(2);
		});
    });
	$("#cancel_loanapply_button").click(function(){
		
		$("#admin_process").val("cancel");
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/cancel");
		$("#form-profile").submit();
    });
	$("#save_loanapply_button").on("click",function(){
		$("#isSaveButton").val("yes");
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/save");
		$("#form-profile").submit();
	});
	$("#update_bidclosedate_button").on("click",function(){
		$("#admin_process").val("update_bidclosedate");
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/updateBidCloseDate");
		$("#form-profile").submit();
	});
	$("#save_comment_button").click(function(){
		
		$("#form-profile").attr("action",baseUrl+"/admin/projectapproval/save_comments");
	});
	
	$(".borrower_doc_download").on("click",function(){
		var	loan_doc_url	=	$(this).attr("data-download-url");
			loan_doc_url	=	loan_doc_url+"_"+ new Date().getTime();
			window.location	=	loan_doc_url;
	});
	
	$("#download_all_document").on("click",function(){
		$("#form-profile").attr("action",baseUrl+"/admin/downloadAllFiles");
		$("#form-profile").submit();
	});
	
	$('#bid_close_date').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'

	}); 
	
	$("#form-profile").submit(function( event ) {
		
		$('span.error').remove();
		$('.has-error').removeClass("has-error");
			$("#milestone_error_info").hide();
		/*if($("#admin_process").val()	==	"approve" || $("#admin_process").val()	==	"update_bidclosedate") {
			if($("#bid_close_date").length) {
				checkAjaxValidation();
				if ($("#loan_details").has('.has-error').length > 0) {
					event.preventDefault();
				}
			}
		}
		if($("#admin_process").val()	==	"approve") {
			
			$partial_sub		=	$("input[name=partial_sub_allowed]:checked").val();
			$partial_sub_amt	=	numeral($("#min_for_partial_sub").val()).value();
			
			if($("#grade").find("option:selected").val()	==	"") {
				
				$('.nav-tabs a[href="#loan_details"]').tab('show');
				$("#grade_parent").addClass('has-error').append('<span class="control-label error">Please select the grade</span>');
				event.preventDefault();	
				return;
			}
			
			if($partial_sub	==	1) {
				if($partial_sub_amt	==	"") {
					var $parentTag = $("#min_for_partial_sub_parent");
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					$('.nav-tabs a[href="#loan_details"]').tab('show');
					event.preventDefault();	
					return;
				}	
				if($partial_sub_amt	==	0	) {
					var $parentTag = $("#min_for_partial_sub_parent");
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					$('.nav-tabs a[href="#loan_details"]').tab('show');
					event.preventDefault();	
					return;
				}	
			}
			if(checkMilestoneDisbused()) {
				$("#milestone_error_info").show();
				$("#milestone_error_info").addClass("has-error");
				$("#milestone_error_info").addClass("alert-danger");
				
				return;	
			}
			
			
		}*/
		var	isSaveButtonClicked		=	$("#isSaveButton").val();
		if(isSaveButtonClicked	!=	"yes") {
		
			if($("#grade").find("option:selected").val()	==	"") {
				
				$('.nav-tabs a[href="#loans_info"]').tab('show');
				$("#grade_parent").addClass('has-error').append('<span class="control-label error">Please select the grade</span>');
				event.preventDefault();	
			}
			
			if(callTabValidateFunc())
				event.preventDefault();
			if(validateTab("documents_submitted"))
				event.preventDefault();
			
			checkAjaxValidation();
			if ($("#loans_info").has('.has-error').length > 0) {
				event.preventDefault();
				$('.nav-tabs a[href="#loans_info"]').tab('show');
				return;
			}
			
			if($("#reward_token_table tbody tr:not('.no_data_row')").length	==	0) {
				event.preventDefault();
				errMessage	=	"No Rewards Token entered";
				showDialog("",errMessage);
				$('.nav-tabs a[href="#documents_submitted"]').tab('show');
				return;
			}
		
		}
		
		if(!formLoanValid){
			event.preventDefault();	
		}
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

		
	$("#loan_amount").on("change", function() {
		calculateCostOfTokenFunc();
	});
	
    $("#no_of_tokens").on("change", function() {
		calculateCostOfTokenFunc();
	});
	
});

function checkMilestoneDisbused() {
	
	var	totMilestoneDisbursed	=	0;
	$('#milestone-table > tbody  > tr').each(function() {
		id			=	$(this).attr('id');
		id			=	id.replace("milestone_row_","");
		name		=	$("#milstone_name_"+id).val();
		date		=	$("#milstone_date_"+id).val();
		disbursed	=	$("#milstone_disbursed_"+id).val();
		if(name!=""&& date!=""	&& disbursed!="" ) {
			totMilestoneDisbursed	=	totMilestoneDisbursed	+	parseInt(disbursed);
		}
	});
	//~ alert(totMilestoneDisbursed);
	if(totMilestoneDisbursed	>	0) {
		if(totMilestoneDisbursed	!=	100) {
			
			return	true;	
		}
	}
	return false;
}
function callTabValidateFunc() {
	
	var active = $("ul.nav-tabs li.active a");
	var	cur_tab		=	active.attr("href");
	cur_tab			=	cur_tab.replace("#","");
	$("#next_button").show();
	$("#submit_button").hide();
	if(validateTab('loans_info')) {
		$('.nav-tabs a[href="#loans_info"]').tab('show');
		return true;
	}
	
	if(checkMilestoneDisbused()) {
		$("#milestone_error_info").show();
		$("#milestone_error_info").addClass("has-error");
		$("#milestone_error_info").addClass("alert-danger");
		
		return true;	
	}
	
	return false;
}

function addNewLoanApplyCommentRow(screenType){
		
	screenMode		=	$("#screen_mode").val();
	htmlTemplate 	= 	$("#commentTemplate").html();
	counterint 		= 	parseInt($("#max_comment").val());

	counterint++;
	counterstr = counterint.toString();

	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
	$("#commentBoxContainer").append(htmlTemplate);
	
	$("#max_comment").val(counterstr);

	$(".commentClass").click(function(){
		var	commentId	=	$(this).attr("id");
		var	id			=	commentId.replace("comment_status_","");
		if($(this).is(":checked")) {
			$("#comment_status_hidden_"+id).val(2);
		}else{
			$("#comment_status_hidden_"+id).val(1);
		}
	});
}

function checkAjaxValidation() {
		
	var loan_amount			=	numeral($("#loan_amount").val()).value();
	//~ var bidcloseDate		=	$("#date-picker-2").val();
	var partialSubAllowed	=	$("input[name=partial_sub_allowed]:radio:checked").val();
	var partialSubAmount	=	numeral($("#min_for_partial_sub").val()).value();

	var data = {	
				loan_amount:loan_amount,
				//~ bidcloseDate:bidcloseDate,
				//~ targetInterest:targetInterest,
				partialSubAllowed:partialSubAllowed,
				partialSubAmount:partialSubAmount
				};
		// process the form
	$.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : baseUrl+'/admin/ajaxApplyLoan/checkvalaidation', // the url where we want to POST
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
				//~ if(data.row.target_interestErr	!="")
					//~ $("#target_interest_parent").addClass('has-error').
											//~ append('<span class="control-label error">'+data.row.target_interestErr+'</span>');
				if(data.row.partialSubAmountErr	!="")
					$("#min_for_partial_sub_parent").addClass('has-error').
											append('<span class="control-label error">'+data.row.partialSubAmountErr+'</span>');
				$('.nav-tabs a[href="#loans_info"]').tab('show');
			}
	});
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
	if ($("#"+cur_tab).has('.has-error').length > 0) {
		return true;
	}else{
		if(cur_tab	==	"loans_info") {
			if(checkMilestoneDisbused()) {
				$("#milestone_error_info").show();
				$("#milestone_error_info").addClass("has-error");
				$("#milestone_error_info").addClass("alert-danger");
				return	true;	
			}
		}
		return false;
	}
}



function calculateCostOfTokenFunc() {
	var	apply_amount	=	numeral($("#loan_amount").val()).value();
	var	no_of_token		=	numeral($("#no_of_tokens").val()).value();
	
	if(no_of_token	==	0) {
		$("#no_of_tokens").val(1);
		no_of_token	=	1;
	}
		
	costofTokens		=	apply_amount	/	no_of_token;
	$("#cost_per_token").val(numeral(costofTokens).format("(0,000.00)"));
}
