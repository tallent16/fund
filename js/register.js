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
                'password': {
                    required: true,
                    //minlength: 5
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
                'password': {
                    required: 'Please provide a password',
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
