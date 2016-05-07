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
		
		$("#form-profile").submit();
    });
	$("#approve_loanapply_button").click(function(){
	
		$("#admin_process").val("approve");
		
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
		
		$("#form-profile").submit();
    });
	
	$(".borrower_doc_download").on("click",function(){
		var	loan_doc_url	=	$(this).attr("data-download-url");
			loan_doc_url	=	loan_doc_url+"_"+ new Date().getTime();
			window.location	=	loan_doc_url;
	});
	
	$('#bid_close_date').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'

	}); 
	
	$("#form-profile").submit(function( event ) {
		
		$('span.error').remove();
		$('.has-error').removeClass("has-error");
		
		checkAjaxValidation();
		if ($("#loan_details").has('.has-error').length > 0) {
			event.preventDefault();
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
