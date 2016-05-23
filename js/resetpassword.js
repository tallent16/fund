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
                    //minlength: 3
                },            
                'password': {
                    required: true,
                    minlength: 4
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
                    regx: 'Not a valid format',                  
                },                
                'password': {
                    required: 'Please provide a password',
                },
                'ConfirmPassword': {
                    required: 'Please enter the password again',
                    equalTo: 'Confirm password does not match password',
                }
            }
        });
});
