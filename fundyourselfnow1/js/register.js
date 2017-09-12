
function cpassword(password,ConfirmPassword,pass){

     if(password==ConfirmPassword){
    $('#CPassword-error1').html('');
      pass="1";
      $('.cpass').removeClass('has-error'); 
  }else{
         pass="0";
        if(ConfirmPassword != ''){
            $('.cpass').addClass('has-error');
    $('#CPassword-error1').html('Confirm password does not match password');
       }
   }
}
$(document).ready(function (){  
    var abc = $("#password").passStrengthify(); 
    var pass="0";
 $("#ConfirmPassword").keyup(function() {
     var password = $("#password").val();
     var ConfirmPassword = $("#ConfirmPassword").val();
     if(ConfirmPassword != ''){
        $("#ConfirmPassword-error").hide(); 
        $('.cpass').removeClass('has-error');   
          $('#CPassword-error1').html('');  
        }else{ 
             $('.cpass').addClass('has-error');
             $('#CPassword-error1').html(''); 
            /* $("#ConfirmPassword-error").show();  
           $('.cpass').addClass('has-error');*/
       }
      if(password==ConfirmPassword){
      	var weak_text = $('#txt').text();
        //alert(pass+weak_text);
        var password = $("#password").val();
        var matchpass = password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,30}$/);
        var plength = password.length;
        if(matchpass){
        if(weak_text=='Weak' || weak_text=='Very weak' || weak_text == 'Too short' || plength<10){
          pass = "0";
        }else{
           pass = "1";
        }
    	}else{
    		pass="0";
    	}
         $('#CPassword-error1').html('');
        
         $('.cpass').removeClass('has-error'); 
       }else{
            pass="0";
           if(ConfirmPassword != ''){
            $('.cpass').addClass('has-error');
              $('#CPassword-error1').html('Confirm password does not match password');
            }
      }
 

});
     $("#password").blur(function() {

         var password = $("#password").val();
          var weak_text = $('#txt').text();
          
         var ConfirmPassword = $("#ConfirmPassword").val();
        /* if(password != ''){  
            $("#password-error").hide(); 
            $('.pass').removeClass('has-error');  
          }else{ */
           /* $("#password-error").show(); 
            $('.pass').addClass('has-error');*/
          /* $("#ConfirmPassword").val(''); 
           $("#Password-error1").html(""); 
           $('#CPassword-error1').html("");
           $('.cpass').removeClass('has-error'); 
       }*/
    var plength = password.length;
 if(password!=ConfirmPassword){
   
         pass="0";
        if(ConfirmPassword != ''){
            $('.cpass').addClass('has-error');
            $('#CPassword-error1').html('Confirm password does not match password');
       
   }
    }
   // alert(ConfirmPassword);
         if(weak_text=='Weak' || weak_text=='Very weak'){
          pass = "0";
           $('.pass').addClass('has-error'); 
         $("#Password-error1").html("Your password is too weak You have to create more strongger password");

         }
   
         var value = $('#txt').text();
       // alert(value);
        if(value == 'Very strong' || value =='Moderate' || value =='Good' || value == 'Strong' || plength > '9' ){
        var password = $("#password").val();
        var matchpass = password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,30}$/);
       if (matchpass){
         pass="1";
       /* $('.pass').removeClass('has-error');
        if(password == ConfirmPassword){ 
              pass="1";
               } 
        $("#Password-error1").html("");*/
        } else{
         $('.pass').addClass('has-error'); 
         $("#Password-error1").html("Password should be min 10 characters. The password should contain 1 uppercase and 1 lowercase alphabet, 1 number and 1 special Character (!@#$%^&*)");
            pass="0";
         }
        }
          //alert(pass);
     });
     $("#password").keyup(function() {

         var password = $("#password").val();
          var weak_text = $('#txt').text();
          
         var ConfirmPassword = $("#ConfirmPassword").val();
         if(password != ''){  
            $("#password-error").hide(); 
            $('.pass').removeClass('has-error');  
          }else{ 
           /* $("#password-error").show(); 
            $('.pass').addClass('has-error');*/
           $("#ConfirmPassword").val(''); 
           $("#Password-error1").html(""); 
           $('#CPassword-error1').html("");
           $('.cpass').removeClass('has-error'); 
       }
    var plength = password.length;
 if(password==ConfirmPassword){
    $('#CPassword-error1').html('');
      pass="1";
      $('.cpass').removeClass('has-error'); 
     }else{
        pass="0";
       
   }
    
   // alert(ConfirmPassword);
        if(weak_text=='Weak' || weak_text=='Very weak'){
           pass="0";

         }
   
         var value = $('#txt').text();
        //alert(value);
        if(value == 'Very strong' || value =='Moderate' || value =='Good' || value == 'Strong' || plength > '9' ){
        var password = $("#password").val();
        var matchpass = password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{10,30}$/);
       if (matchpass){
        $('.pass').removeClass('has-error');
        if(password == ConfirmPassword ){ 
              pass="1";
               } 
        $("#Password-error1").html("");
        } else{
       //$('.pass').addClass('has-error'); 
         //$("#Password-error1").html("Password should be min 10 characters. The password should contain 1 uppercase and 1 lowercase alphabet, 1 number and 1 special Character (!@#$%^&*)");
            pass="0";
         }
           //alert(pass);
        } else{
        	pass="0";
        	// alert(pass);
        }
     });
    

    $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('#hidden_token').val()
    }
    //~ console.log(systemAllSetting);
  });
    $('#SecurityQuestion1').change(function(){
    if($(this).val!=''){
      $("#SecurityQuestion1-error").html('');
        $('.btn-default').css( 'border-color','#ccc');   
    }
   

    });
  $('#reg-submit-btn').click(function (e) {
          //alert(pass);
    e.preventDefault();
          if($('#SecurityQuestion1').val()==''){
           $("#SecurityQuestion1-error").html('Please select a security question');
           $('.btn-default').css( 'border-color','#a94442');
          }
        
    if ($('#form-register').valid() && pass == '1') {
      $("#toc_information").modal();
      if($("input[name='Userrole']:checked").val()  ==  "Investor") {
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
   $.validator.addMethod("custompasswordstrength", function(value, element) {  //alert(element); 
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
                    required: true
                    
          //~ minlength: 10,
          //~ alphanumeric: true
          //custompasswordstrength:true,
                },
                'country': {
                    required: true,
                    
                   
                },
                'ConfirmPassword': {
                    required: true
                    //equalTo: '#password',
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
                    required: message.username_error,
                    remote: systemMessages['register_username_present'],
                    specialChars:"please use only alphanumeric or alphabetic characters ",
                },
                'EmailAddress': {
                    required: 'Please enter an email',
                    email: 'Email is not valid',
                    remote: systemMessages['register_email_present']
                },
                'firstname': {
                    required: message.first_name,  
                    specialChars:"please use only alphanumeric or alphabetic characters ",                  
                },
                'lastname': {
                    required: message.lastname,
                    specialChars:"please use only alphanumeric or alphabetic characters ",
                },
                'password': {
                    required: message.password_error
                   // custompasswordstrength: systemMessages['register_weak_password']
                },
                'country': {
                     required: 'Please select  a country'
                },
                'ConfirmPassword': {
                    required: message.cpassword_error
                   // equalTo: 'Confirm password does not match password',
                },
                'SecurityQuestion1': { 
                    required:"Please select a security question",
            },
                'SecurityQuestionAnswer1': {

                    required:"Please provide a security answer",
                }
            }
        });
});
