
$(document).ready(function(){ 	
	 $("tr.tablesrow:odd").css("background-color", "rgb(225, 225, 225)");
	
	// date picker
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	}); 
	
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	});         
	

	
	// Add event listener for opening and closing transcation details
	$(".details-control").click(function() {
		
		var loan_id = $(this).parent().attr("id");		
		if($(this).parent().hasClass("shown")){
			$("#"+loan_id).removeClass("shown");
			$("#tran_row_"+loan_id).hide();			
		}
		else{
			$("#"+loan_id).addClass("shown");
			$("#tran_row_"+loan_id).show();				
		}
	});
	/******************************Popup Function**********************/
	//~ var baseUrl	=	"{{url('')}}"
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	    
   
	
	//~ $(".details-control").on('click',function(){
	function getaudittablesinfo(){
		var a= $(this).closest('tr').attr('id');
		$(this).parent().siblings('tr.shown').removeClass("shown");
		
		var b = '#tran_row_'+a;		
		$("tr:not('"+b+"')").siblings('[id^="tran_row_"]').hide();
		$(b).show();
		
		var modulename = $(this).find('input').val();		     
		var ret = modulename.split(" ");
		var str1 = ret[0];	
		var str2 = ret[1];	
		if(str1 == 'Loans'){
			str2 = 'Info';			
		}
			
		$.ajax({ 
            type        : 'GET', 				// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+"/admin/audit_trial/module/"+str1+"/"+str2, 	// the url where we want to POST           
            dataType    : 'json',
            async		: false,
        }) // using the done promise callback
		.done(function(data) {				
			showTablesList(data);
		}); 
	}
	//~ });	
	
	$("#modulelist").change(function() {	
				
		$.ajax({
			type: "POST",
			url: baseUrl+"/admin/audit_trial/optionfilter",
			data: {module_list: $(this).find(":selected").text()},			                  
			dataType    : 'json'
		})
		.done(function(data) {	
						
			showdropdown(data);
		});
	});
	$("#modulelist").trigger("change");
	
	
	
}); 

function showdropdown(data){
	var	str = 	"";	
	str		=	str+"<select name='action_list' id='action_list' class='selectpicker'> ";
	//~ str		=	str+"	<div class='btn-group bootstrap-select'>";
	//~ str = str + "<button class='btn dropdown-toggle btn-default ' type='button' id='action_list' data-toggle='dropdown' aria-expanded='true'>";
	//~ str = str +" <span data-bind='label'>Select One</span><span class='caret'></span>";
   //~ str = str + " </button>";
   //~ str = str +" <select class='dropdown-menu' name='action_list' role='menu'> ";
	$.each(data.rows, function(value, key) {
		
		str		=	str+"<option value='"+value.toString()+"' >"+key+" ";
		//~ str = str +" <li>"+key+"</li>";
	
	});
	//~ str = str +  " </ul></div>";
	str		=	str+"</select>";
	$('#actiondropdown').html(str);
	$("#action_list").val("{{$adminAuditTrailMod->actionListValue}}");
}

function showTablesList(data){
	var	str = 	"";	
	str		=	str+"<ul style='list-style-type:none;'>";
	
		$.each( data.rows, function(key,val) {
			str	=	str+"<li id='mod_id' style='cursor:pointer;' >";
			str	=	str+"<span class='fa fa-check-square'></span>"+" "+val+"\n";	
			str	=	str+"<input type ='hidden' value="+ key+">\n";	
			str	=	str+"</li></br>";		
		});
		str	=	str+"</ul>";
		$('.module_list').html(str);
	
}

