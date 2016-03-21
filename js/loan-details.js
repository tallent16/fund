$(document).ready(function (){  
	
	/*List one record at a time*/	    
	$("#bid_now").click(function(){
		$(this).hide();
		$('#form-bid').show();
    });

    $("#cancel_bid").click(function(){
		$('#isCancelButton').val("yes");
    });
	
});
