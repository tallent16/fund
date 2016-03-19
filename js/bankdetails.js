$(document).ready(function (){  
	/*List one record at a time*/
	
    
	$("#next").click(function(){
		 if ($(".divs div.bank-list:visible").next().length != 0){
            $(".divs div:visible").next().show().prev().hide();
         }
        else {
		    $(".divs div.bank-list:visible").hide();
            $(".divs div.bank-list:first").show();
        }
       /* changeDropDown	=	$('.divs div.bank-list:not(:hidden)').attr("id");
        resetDirectorDropDown(changeDropDown);*/
        console.log($('.divs div.bank-list:visible').attr("id"));
		console.log($('.divs div.bank-list:visible').next().attr("id"));
        return false;
    });

    $("#prev").click(function(){
        if ($(".divs div.bank-list:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div.bank-list:visible").hide();
            $(".divs div.bank-list:last").show();
        }
         changeDropDown	=	$('.divs div.bank-list:not(:hidden)').attr("id");
		
        return false;
    });
	/*end of list*/
	
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
	}
	/*End of add bank*/
/*	
	$("#save_button").click(function(){
      $("#isSaveButton").val("yes");
    });*/
});
