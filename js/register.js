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
	 
	 $.validator.addMethod("alphanumeric", function(value, element) {
		return this.optional(element) || /^(?=.*\d)[a-zA-Z0-9]{10,}$/.test(value);
	}
	, "Letters, numbers or underscores only please"); 
	 
	 
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
					minlength: 10,
					alphanumeric: true
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
                    minlength: 'Password strength should be atleast Moderate',
                    alphanumeric: 'Please enter 10 characters with atleast 1 letter & atleast 1 number or underscore'
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
