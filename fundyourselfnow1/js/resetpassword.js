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

	//~ $.validator.addMethod("alphanumeric", function(value, element) {
		//~ return this.optional(element) || /^(?=.*\d+)(?=.*[!@#$%^&*()_+])[a-zA-Z\d\!@#\$%&\*]{10,}$/.test(value);
	//~ }
	//~ , "Letters, numbers or underscores only please"); 
	
	 $.validator.addMethod("custompasswordstrength", function(value, element) {   
		return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,15}$/.test(value);
	}
	, "Letters, numbers ,special characters"); 
	
	 var errPattern	=	'Please enter min 10 and max 15 characters with atleast Upper case letter ';
		 errPattern	=	errPattern+'& 1 number & 1 specialcharacter((!@#$%^&*)';
		 
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
					custompasswordstrength:true,
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
                    required: 'Please provide a password',
                    custompasswordstrength: errPattern
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
