$(document).ready(function (){  
	$("#password").passStrengthify(); 
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	$('#reg-submit-btn').click(function (e) {
		e.preventDefault();

		if ($('#form-register').valid()) {
			$('#form-register').submit();
		}
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
		 
	 $('#form-register').validate({
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
                'username': {
                    required: true,
                    remote: {
                        type: 'post',
                        url: 'ajax/CheckUserNameavailability',
                        data: {
                            'username': function () { return $('#username').val(); }
                        },
                        dataType: 'json'
                    }
                    //minlength: 3
                },
                'EmailAddress': {
                    required: true,
                    email: true,
                    remote: {
                        type: 'post',
                        url: 'ajax/CheckEmailavailability',
                        data: {
                            'EmailAddress': function () { return $('#EmailAddress').val(); }
                        },
                        dataType: 'json'
                    }
                    //minlength: 3
                },
                'firstname': {
                    required: true,
                    //minlength: 5
                },
                'lastname': {
                    required: true,
                    //minlength: 5
                },
                'password': {
                    required: true,
					//~ minlength: 10,
					//~ alphanumeric: true
					custompasswordstrength:true,
                },
                'ConfirmPassword': {
                    required: true,
                    equalTo: '#password',
                    //minlength: 5
                },
                'SecurityQuestion1': {
                    required: true,
                },
                'SecurityQuestionAnswer1': {
                    required: true,
                },
            },
            messages: {
                'username': {
                    required: 'Please enter an Username',
                    remote: 'Username already registered. Please enter a different Username'
                },
                'EmailAddress': {
                    required: 'Please enter an email',
                    email: 'Email is not valid',
                    remote: 'Email already registered. Please enter a different email'
                },
                'firstname': {
                    required: 'Please enter firstname',                    
                },
                'lastname': {
                    required: 'Please enter lastname',
                },
                'password': {
                    required: 'Please provide a password',
                    //~ minlength: 'Password strength should not be weak & (Min:10 characters)',
                    //~ alphanumeric: 'Please enter 10 characters with atleast 1 letter & 1 number & 1 specialcharacter'
                    custompasswordstrength: errPattern
                },
                'ConfirmPassword': {
                    required: 'Please enter the password again',
                    equalTo: 'Confirm password does not match password',
                },
                'SecurityQuestion1': "Please select a security question",
                'SecurityQuestionAnswer1': "Please provide a security answer",
            }
        });
});
