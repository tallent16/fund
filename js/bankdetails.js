var $zDiv = $('.divs > div.bank-list'),
$prNx = $('#prev, #next'),
n = $zDiv.length,
c = 0; // current
$(document).ready(function (){
	
	//Disable the pagination function when status is verified 
	jQuery('.form-control').on('input', function() {	
		$(".pagination li").addClass('disabled');
		$("#next").addClass('disabled');
		$("#prev").addClass('disabled');		
	});

	/*Add a bank*/
	$("#add_button").click(function(){
       addNewBankRow();
    });  
	/*End of add bank*/
	
	$("#update_button").click( function() {
		var cur_id = $zDiv.eq(c).attr("id");		
		$('#update_form-'+cur_id).submit();			
	});		 
	
});
function addNewBankRow() {
	
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

/*Pagination*/
function toggView(){ 
  // content:
  $zDiv.hide().eq(c).show(); 
  // buttons:
  	
	var cur_id=$zDiv.eq(c).attr("id");	//dynamic id from the div bank list
	showhidebuttons(cur_id);			//call the function to hide/show
 
   $('#prev').parent().removeClass("disabled"); 
   $('#next').parent().removeClass("disabled"); 
   
  if(c<=0){
    $('#prev').parent().addClass("disabled");      
  }
  if(c>=n-1){
    $('#next').parent().addClass("disabled");     
  }   
}
toggView();

$prNx.click(function(){ 	
	
	var	buttonType	=	$(this).attr("id");	
	if($("#"+buttonType).parent().hasClass("disabled"))	
		return;		
	if($(this).attr("id")	==	"next") 
		++c;		
	else
		--c;		
		
	var cur_id=$zDiv.eq(c).attr("id");	//dynamic id from the div bank list
	showhidebuttons(cur_id);	        //call the function to hide/show
		
	toggView();  
});
/*End of pagination*/

/*Show/Hide Update and Add Button in the Bank Details */
function showhidebuttons(cur_id){
	
	var full_ID = $('#verified_status_' + cur_id).val();
	if(full_ID == 1){
		$('#add_button').hide();
		$('#update_button').show();
	}
	else {
		$('#add_button').show();
		$('#update_button').hide();
	}
	
}

