var formValid	=	false;
$(document).ready(function (){ 
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#_token').val()
		}
	});
	// date picker
	$('#date_of_birth').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	});   
	
	$("#form-profile").submit(function(e) {
		
		if($("#screen_mode").val()	==	"investor"){
			var	email		=	$("#email").val();
			var	username	=	$("#displayname").val();
			checkDisplayName(username);
			checkEmail(email);
			var	isSaveButtonClicked		=	$("#isSaveButton").val();
			
			if(isSaveButtonClicked	!=	"yes") {
				if($("#investor_status").val()	==	"corrections_required") {
					
					if(checkAdminAllCommentsClosed()){
						showDialog("","Please close the corrections and submit again for approval");
						event.preventDefault();
					}
				}
			}
			if ($("#form-profile").has('div.has-error').length > 0)
				e.preventDefault();
		}
		if($("#screen_mode").val()	==	"admin"){
			if(!formValid)
				event.preventDefault();
		}
	});
	$("#next_button").click(function(){
		
		$('.nav-tabs a[href="#comments_info"]').tab('show');
		$("#next_button").hide();
		$("#submit_button").show();
		$("#returnback_button").show();
	});
	$(".nav-tabs > li").click(function(){
		$("#next_button").show();
		$("#submit_button").hide();
		if($(this).find("a").attr("href")	==	"#comments_info") {
			$("#next_button").hide();
			$("#submit_button").show();
			$("#returnback_button").show();
		}
	});
	
	$("#save_button").click(function(){
      $("#isSaveButton").val("yes");
    });
    
    $("#approve_profile_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/investor/profile/approve");
      	if($('.commentClass:not(#comment_status_XXX)').not(':checked').length){
			errMessage	=	"Please close all comments before approve";
			showDialog("",errMessage);
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			formValid	=	false;
		}else{
			formValid	=	true;
		}
    });
    
	$("#returnback_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/investor/profile/return_investor");
		if($('.commentClass:checked').length){
			errMessage	=	"There is no open comments to return back to investor";
			showDialog("",errMessage);
			formValid	=	false;
		}else{
			formValid	=	true;
		}
    });
	
	$("#save_comment_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/investor/profile/save_comments");
    });
});
function checkDisplayName(value) {
	if((value!='')) {
		$.ajax({
		  type: "POST",
		  url: baseUrl+"/investor/checkFieldExists",
		  data: {	'user_id':$("#user_id").val(),
					'field_name':'username',
					'field_value':value,
					'type':'username'
				},
		  success: function (data) {
			  if(data=='1') {
				 $(".label_displayname_error").html("");
				 $(".label_displayname_error").hide();
				 $(".label_displayname_error").parent().removeClass("has-error");
				 return true;
			  } else if(data=='2') {
				 $(".label_displayname_error").html("Display name "+ value +" already exists");
				 $("#displayname").val("");
				 $(".label_displayname_error").show();
				 $(".label_displayname_error").parent().addClass("has-error");
			  }
		  }
		}); 
	}else{
		$(".label_displayname_error").html("Enter the Display name");
		$(".label_displayname_error").show();
		$(".label_displayname_error").parent().addClass("has-error");
	}
}
function checkEmail(value) {
	
	if((value!='')) {
		if(!validateEmail(value)) {
			$(".label_email_error").html("Invalid Email");
			$(".label_email_error").show();
			$(".label_email_error").parent().addClass("has-error");
		}else{
			
			$.ajax({
			  type: "POST",
			  url: baseUrl+"/investor/checkFieldExists",
			  data: {	'user_id':$("#user_id").val(),
						'field_name':'email',
						'field_value':value,
						'type':'email'
					},
			  success: function (data) {
				  if(data=='1') {
					 $(".label_email_error").html("");
					 $(".label_email_error").hide();
					 $(".label_email_error").parent().removeClass("has-error");
					 return true;
				  } else if(data=='2') {
					 $(".label_email_error").html("Email "+ value +" already exists");
					 $("#email").val("");
					 $(".label_email_error").show();
					 $(".label_email_error").parent().addClass("has-error");
				  }
			  }
			}); 
		}
	}else{
		$(".label_email_error").html("Enter the Email");
		$(".label_email_error").show();
		$(".label_email_error").parent().addClass("has-error");
	}
}
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}


