$(document).ready(function (){
 
	$("#password").passStrengthify(); 
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	
	$('#confirm-button').click(function (e) {		
		e.preventDefault();
		
		if ($('#resetpassword').valid()) {
			
			if($("#passwordtype").val()	==	"Change Password") {
				$('#resetpassword').attr("action",baseUrl+"/submit/changepassword");
			}else{
				$('#resetpassword').attr("action",baseUrl+"/submit/forgotpassword");
			}			
			$('#resetpassword').submit();
		}
	 }); 
	
	$.validator.addMethod( 'passwordMatch', function(value, element) {		
		// The two password inputs
		var oldpassword = $("#oldpassword").val();
		var newPassword = $("#password").val();

		// Check for notequal with the password inputs
		if (oldpassword == newPassword ) {			
			return false;
		} else {
			return true;
		}

	}, "Passwords should not match with old password");

	$.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^(?=.*\d)[a-zA-Z0-9]{10,}$/.test(value);
	}
	, "Letters, numbers or underscores only please"); 

	 $('#resetpassword').validate({
            errorClass: 'help-block animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function (error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function (e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function (e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {			
               
               'EmailAddress': {					
                    required: true,
                    email: true,  
                     remote: {
                        type: 'post',
                        url: 'ajax/checkEmailavailable',
                        data: {
                            'EmailAddress': function () { return $('#EmailAddress').val(); }
                        },
                        dataType: 'json'
                    }                  
                    //minlength: 3
                },            
                'password': {
                    required: true, 
					minlength: 10 ,
                    passwordMatch: true,
					alphanumeric: true  
                },
                'ConfirmPassword': {
                    required: true,
                    equalTo: '#password'
                    //minlength: 5
                },     
                             
            },
            messages: {              
                'EmailAddress': {
                    required: 'Please enter an email',
                    email: 'Email is not valid',         
                    remote: 'Only Registered email are allowed'                            
                },                
                'password': {
                    required: 'Please provide a password in alphanumeric with atleast 10 characters', 
                    passwordMatch: "Passwords should not match with old password" ,
                    alphanumeric: "Please enter 10 characters with atleast 1 letter & atleast 1 number or underscore" ,
                    minlength: "Password strength should be atleast Moderate"                
                },
                'ConfirmPassword': {
                    required: 'Please enter the password again',
                    equalTo: 'Confirm password does not match password'
                }
                
            }
        });
        $("#next_button").on('click',function() {
			
			var resetType	=	$('input[name=passwordtype]:checked').val();
			if(resetType	==	"Forgot Password") {
				$("#resetpassword").attr("action",baseUrl+"/forgotpassword");
			}else{
				$("#resetpassword").attr("action",baseUrl+"/changepassword");
			}
		});
});
