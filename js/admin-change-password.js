$(document).ready(function (){  
	$("#new_password").passStrengthify(); 
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	$('#change_password_button').click(function (e) {
		
		if ($('#form-change-password').valid()) {
			$("#form-change-password").attr("action",baseUrl+"/admin/changepassword/save");
			$('#form-change-password').submit();
		}
	 }); 
	$('#cancel_button').click(function (e) {
		window.location = $(this).attr("data-action");
	 }); 
	 
	 //~ $.validator.addMethod("alphanumeric", function(value, element) {   
		//~ return this.optional(element) || /^(?=.*\d+)(?=.*[!@#$%^&*()_+])[a-zA-Z\d\!@#\$%&\*]{10,}$/.test(value);
	//~ }
	//~ , "Letters, numbers ,special characters"); 
	 $.validator.addMethod("custompasswordstrength", function(value, element) {   
		return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,15}$/.test(value);
	}
	, "Letters, numbers ,special characters"); 
	 
	 var errPattern	=	'Please enter min 10 and max 15 characters with atleast Upper case letter ';
		 errPattern	=	errPattern+'& 1 number & 1 specialcharacter((!@#$%^&*)';
		 
	 $('#form-change-password').validate({
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
                
                'current_user_password': {
                    required: true,
                    //minlength: 5
                },
                'new_password': {
                    required: true,
					custompasswordstrength:true,
                },
                'confirm_password': {
                    required: true,
                    equalTo: '#new_password',
                    //minlength: 5
                },
            },
            messages: {
               
                'current_user_password': {
                    required: 'Please enter the current user Password',
                },
                'new_password': {
                    required: 'Please enter the new password',
                    //~ minlength: 'Password strength should not be weak & (Min:10 characters)',
                    //~ alphanumeric: 'Please enter 10 characters with atleast 1 letter & 1 number & 1 specialcharacter'
                    custompasswordstrength: errPattern
                },
                'confirm_password': {
                    required: 'Please enter the confirm password again',
                    equalTo: 'Confirm password does not match password',
                },
            }
        });
});
