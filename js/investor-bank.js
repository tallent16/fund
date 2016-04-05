$(".error").hide();
/*
function withdrawamountfunction(){

var avail_bal = $("#available_bal").val();
var withdraw  = $("#withdraw_amount").val();
if(withdraw > avail_bal || withdraw <= 0 ){  
	$(".error").show();
}
	
}
*/



/*
$(document).ready(function(){
    setTimeout(
            function(){
                document.getElementById( "withdraw_payment" ).reset();
            },
            5
            );
});


/*
$("#withdraw").click(function() {	
	var avail_bal = $("#available_bal").val();
	var withdraw  = $("#withdraw_amount").val();
	
	if(withdraw > avail_bal || withdraw <= 0 ){
		$(".error").show();
		alert('Insufficient Balance');
	}	
	location.reload(true);	
});*/
/*
$("withdraw").submit(function(ev){
   ev.preventDefault();
   //Check if the inputs are valid
   var avail_bal = $("#available_bal").val();
	var withdraw  = $("#withdraw_amount").val();
	
	if(withdraw > avail_bal || withdraw > 0 ){
		$(".error").show();		
	}	
   if( formvalid ){
      $.ajax() //Make your ajax call 
   }
})


$("withdraw").submit(function(ev){
  $.ajax({
    url: "url",
    type: "post",
    async: false, //To make the ajax call synchronous
    success: function(valid){
      if(!valid)
        ev.preventDefault();
    }
  }); 
})*/
