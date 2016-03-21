$(document).ready(function (){  
	
	/*List one record at a time*/	    
	$("#next").click(function(){
		if($(this).parents().hasClass("disabled"))
			return;
		 if ($(".divs div.bank-list:visible").next().length != 0){			
            $(".divs div.bank-list:visible").next().show().prev().hide();                     
         }
        else {			
		    $(".divs div.bank-list:visible").hide();		    
            $(".divs div.bank-list:first").show();            
        }     
        return false;
    });

    $("#prev").click(function(){
		if($(this).parents().hasClass("disabled"))
			return;
        if ($(".divs div.bank-list:visible").prev().length != 0)
            $(".divs div.bank-list:visible").prev().show().next().hide();
        else {
            $(".divs div.bank-list:visible").hide();
            $(".divs div.bank-list:last").show();
        }       
        return false;
    });
	/*end of list*/
	
	//Disable the pagination function ,button and the input fields when status is verified 
	jQuery('.form-control').on('input', function() {		
		$("#add-bank").addClass('disabled');
		$(".pagination li").addClass('disabled');
		$("#next").attr('id','');
		$("#prev").attr('id','');
	});
	
	/*Add a bank*/
	$("#add-bank").click(function(){
       addNewBankRow();
    });
    
    function addNewBankRow(){
		
		htmlTemplate = $("#bankTemplate").html();
		counterint = parseInt($("#max_bank").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$(".divs ").append(htmlTemplate);
		$("#name_"+counterstr).val("bank"+counterstr);
		$("#max_bank").val(counterstr);
		$(".divs div.bank-list:visible").hide();
        $(".divs div.bank-list:last").show();
        $(".bankdet-pagi").hide();
        
	}
	/*End of add bank*/

});
