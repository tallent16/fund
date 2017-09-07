

$(document).ready(function (){  
	var abc = $("#password").passStrengthify(); 
   var password = $("#password").val();
  var ConfirmPassword = $("#ConfirmPassword").val();
 $("#ConfirmPassword").keyup(function() {
  if(password==ConfirmPassword){
    $('#ConfirmPassword-error').html('');
  }

    });
     $("#password").keyup(function() {
         var value = $('#txt').text();
       // alert(value);
        if(value == 'Very strong' || value =='Moderate' || value =='Good' || value == 'Strong'){
        var password = $("#password").val();
        var matchpass = password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,30}$/);
       
      
    if (matchpass){
     $("#Password-error1").html("");
    } else{
       
         $("#Password-error1").html("Password should be min 10 characters. The password should contain 1 uppercase and 1 lowercase alphabet, 1 number and 1 special Character (!@#$%^&*)");
         
     }
 }
     });
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
		//~ console.log(systemAllSetting);
	});
	$('#reg-submit-btn').click(function (e) {
		e.preventDefault();

		if ($('#form-register').valid()) {
			$("#toc_information").modal();
			if($("input[name='Userrole']:checked").val()	==	"Investor") {
				$("#toc_messageblock").html(systemSettings['toc_investor']);
			}else{
				$("#toc_messageblock").html(systemSettings['toc_borrower']);
			}
		}
	 }); 
	 
	$('#read_toc_message').click(function (e) {
		if($(this).is(":checked")) {
			$("#toc_message_submit").removeAttr("disabled");
		}else{
			$("#toc_message_submit").attr("disabled",true);
			$("#toc_message_submit").prop("disabled",true);
		}
	 }); 
	$('#toc_message_submit').click(function (e) {
		
		if($("#read_toc_message").is(":checked")) {
			$('#form-register').submit();
			console.log("toc_message_submit");
		}
	 }); 



	/* function custompasswordstrength(value, element) {   
        return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,15}$/.test(value);
    }, "Letters, numbers ,special characters"); */
	 
	 //~ $.validator.addMethod("alphanumeric", function(value, element) {   
		//~ return this.optional(element) || /^(?=.*\d+)(?=.*[!@#$%^&*()_+])[a-zA-Z\d\!@#\$%&\*]{10,}$/.test(value);
	//~ }
	//~ , "Letters, numbers ,special characters"); 
	 $.validator.addMethod("custompasswordstrength", function(value, element) {  alert(element); 
		return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,15}$/.test(value);
	}, "Letters, numbers ,special characters"); 
      jQuery.validator.addMethod("specialChars", function( value, element ) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var key = value;

        if (!regex.test(key)) {
           return false;
        }
        return true;
    }, "please use only alphanumeric or alphabetic characters");
	 
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
                    specialChars:true,
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
                    specialChars:true,
                    //minlength: 5
                },
                'lastname': {
                    required: true,
                    specialChars:true,
                    //minlength: 5
                },
                'password': {
                    required: true,
                    
					//~ minlength: 10,
					//~ alphanumeric: true
					//custompasswordstrength:true,
                },
                'country': {
                    required: true,
                    
                   
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
                    remote: systemMessages['register_username_present'],
                    specialChars:"please use only alphanumeric or alphabetic characters ",
                },
                'EmailAddress': {
                    required: 'Please enter an email',
                    email: 'Email is not valid',
                    remote: systemMessages['register_email_present']
                },
                'firstname': {
                    required: 'Please enter firstname',  
                    specialChars:"please use only alphanumeric or alphabetic characters ",                  
                },
                'lastname': {
                    required: 'Please enter lastname',
                    specialChars:"please use only alphanumeric or alphabetic characters ",
                },
                'password': {
                    required: 'Please provide a password',
                   // custompasswordstrength: systemMessages['register_weak_password']
                },
                'country': {
                     required: 'Please select  a country',
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
