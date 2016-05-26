$(".error").hide();
$("#withdraw_payment").submit(function(e){	
var avail_bal = $("#available_bal").val();
var withdraw  = $("#withdraw_amount").val();
	if(withdraw > avail_bal || withdraw <= 0 ){  
		$(".error").show();
		e.preventDefault();	
	}	
});
