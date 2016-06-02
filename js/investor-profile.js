var formValid	=	false;
$(document).ready(function (){ 

	 $("#mobile").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
	
	$("#save_button,#submit_button").on("click", function(e){
		$('span.error').remove();
		$('.has-error').removeClass("has-error");
		validTab();
	});
//This for admin screen only
	$("#admin_save_button").click(function(){
		$("#isSaveButton").val("yes");
		$("#form-profile").attr("action",baseUrl+"/admin/investor/profile/save");
		formValid	=	true;
		var	email		=	$("#email").val();
		var	username	=	$("#displayname").val();
		checkDisplayName(username);
		checkEmail(email);
    });
	 $("#approve_profile_button").click(function(){
			$('span.error').remove();
		$('.has-error').removeClass("has-error");
		formValid	=	true;
	
		var	email		=	$("#email").val();
		var	username	=	$("#displayname").val();
		checkDisplayName(username);
		checkEmail(email);
		
		validTab();
		$("#form-profile").attr("action",baseUrl+"/admin/investor/profile/approve");
		if($('.commentClass:not(#comment_status_XXX)').not(':checked').length){
			errMessage	=	"Please close all comments before approve";
			showDialog("",errMessage);
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			formValid	=	false;
		}
    });
//This for admin screen only
	$(".amount-align").on("focus", function() {
			onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	})
	
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
				e.preventDefault();
			if ($("#form-profile").has('div.has-error').length > 0)
				e.preventDefault();
		}
		$("#active_tab").val($(".nav-tabs li.active a").attr("href"));
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
    
   
    
	$("#returnback_button").click(function(){
		$("#form-profile").attr("action",baseUrl+"/admin/investor/profile/return_investor");
		formValid	=	true;
		if($('.commentClass:not(#comment_status_XXX)').length	>	0){
			if($('.commentClass:checked').length){
				errMessage	=	"There is no open comments to return back to investor";
				showDialog("",errMessage);
				formValid	=	false;
			}
		}else{
			errMessage	=	"There is no open comments to return back to investor";
			showDialog("",errMessage);
			formValid	=	false;
		}
    });
	
	$("#save_comment_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/investor/profile/save_comments");
    });
    
	$("#update_mobile_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/investor/profile/update");
      $("#form-profile").submit();
    });
    checkAllTabCompleteStatus();
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

function checkAllTabCompleteStatus() {
	var	active_tab				=	$("#active_tab").val();
	switch(active_tab){
		case "#inv_profile_info":
			$('.nav-tabs a[href="#inv_profile_info"]').tab('show');
			break;
		case "#comments_info":
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			$("#submit_button").show();
			$("#returnback_button").show();
			$("#approve_profile_button").show();
			break;
	}
	
	
}

function validTab() {
	$("input.required").each(function(){
		
			var	input_id	=	$(this).attr("id");
			var inputVal 	= 	$(this).val();
			
			var $parentTag = $("#"+input_id+"_parent");
			if(inputVal == ''){
				if(input_id	==	"identity_card_image_front" || 
					input_id	==	"identity_card_image_back"||
					input_id	==	"address_proof_image") {
					if($("#"+input_id+"_hidden").val() == ''){
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						$('.nav-tabs a[href="#inv_profile_info"]').tab('show');
					}
				}
				else{
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					$('.nav-tabs a[href="#inv_profile_info"]').tab('show');
				}
			}
		});
}
function writeReply(replyId) {
	$("#"+replyId).show();
	$("#"+replyId).focus();
}

