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
    });
	$("#returnback_loanapply_button").click(function(){
		
		$("#admin_process").val("return_borrower");
		$("#form-profile").attr("action",baseUrl+"/admin/loanapproval/return_borrower");
		if(($('#commentBoxContainer .commentClass:checked').length)
			|| ($('#commentBoxContainer .commentClass').length == 0) ){
			errMessage	=	"There is no open comments to return back to borrower";
			showDialog("",errMessage);
			$('.nav-tabs a[href="#comments"]').tab('show');
			formLoanValid	=	false;
		}else{
			formLoanValid	=	true;
		}
		$("#form-profile").submit();
    });
	$("#approve_loanapply_button").click(function(){
	
		$("#admin_process").val("approve");
		$("#form-profile").attr("action",baseUrl+"/admin/loanapproval/approve");
		if($('#commentBoxContainer .commentClass').not(':checked').length){
			errMessage	=	"Please close all comments before approve";
			showDialog("",errMessage);
			
			$('.nav-tabs a[href="#comments"]').tab('show');
			formLoanValid	=	true;
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
		$("#form-profile").attr("action",baseUrl+"/admin/loanapproval/cancel");
		$("#form-profile").submit();
    });
	$("#save_loanapply_button").on("click",function(){
		$("#isSaveButton").val("yes");
		$("#form-profile").attr("action",baseUrl+"/admin/loanapproval/save");
		$("#form-profile").submit();
	});
	$("#save_comment_button").click(function(){
		
		$("#form-profile").attr("action",baseUrl+"/admin/loanapproval/save_comments");
		$("#form-profile").submit();
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
		if($("#bid_close_date").length) {
			checkAjaxValidation();
			if ($("#loan_details").has('.has-error').length > 0) {
				event.preventDefault();
			}
		}
		$partial_sub		=	$("input[name=partial_sub_allowed]:checked").val();
		$partial_sub_amt	=	numeral($("#min_for_partial_sub").val()).value();
		if($partial_sub	==	1) {
			if($partial_sub_amt	==	"") {
				var $parentTag = $("#min_for_partial_sub_parent");
				$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
				event.preventDefault();	
			}	
			if($partial_sub_amt	==	0	) {
				var $parentTag = $("#min_for_partial_sub_parent");
				$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
				event.preventDefault();	
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
});

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
	
			var bidcloseDate		=	$("#bid_close_date").val();
			
			var data = {	
						bidcloseDate:bidcloseDate,
						};
				// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : baseUrl+'/admin/ajaxBidCloseDate/checkvalaidation', // the url where we want to POST
				data        : data,
				async : false,
				cache:false,
				dataType    : 'json'
			})
				// using the done promise callback
				.done(function(data) {
					if(data.status	==	"error"){
					
						if(data.row.bidcloseDateErr	!="")
							$("#bid_close_date_parent").addClass('has-error').
													append('<span class="control-label error">'+data.row.bidcloseDateErr+'</span>');
							$('.nav-tabs a[href="#loan_details"]').tab('show');
					}
			});
}
