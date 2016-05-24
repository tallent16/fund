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
                    minlength: 4,                 
                },
                'ConfirmPassword': {
                    required: true,
                    equalTo: '#password',
                    //minlength: 5
                },     
                             
            },
            messages: {              
                'EmailAddress': {
                    required: 'Please enter an email',
                    email: 'Email is not valid',         
                    remote: 'Enter Registered email'                            
                },                
                'password': {
                    required: 'Please provide a password with atleast 8 characters,alphanumeric',                  
                },
                'ConfirmPassword': {
                    required: 'Please enter the password again',
                    equalTo: 'Confirm password does not match password',
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
