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
		var	email		=	$("#email").val();
		var	username	=	$("#displayname").val();
		checkDisplayName(username);
		checkEmail(email);
		if ($("#form-profile").has('div.has-error').length > 0)
			e.preventDefault();
		
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
