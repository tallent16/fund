$(document).ready(function(){
	  //Only accept numbers    
	$(".numeric").keydown(function(event) { 
		// Allow only backspace and delete
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});		
	//if Checkbox is marked, then Auto close time textbox will be editable otherwise disabled 		
	$("#autobidclose").change(function() {			
		if($("#autobidclose").prop('checked') == true){
			$('#auto_close_time').prop('disabled',false );
		}else{
			$('#auto_close_time').prop('disabled', true);
		}
		change();
	});
	
	//after submit same tab to be active
	$('#current-tab  a').click(function(e) {
	  e.preventDefault();
	  $(this).tab('show');	  
	});
	
	$("ul.nav-tabs#current-tab > li > a").on("shown.bs.tab", function(e) {
	  var id = $(e.target).attr("href");
	  localStorage.setItem('selectedTab', id);
	  $('#update_settings').show();
	  if(id == '#mail_subjectcontent'){   //hide save button
			$('#update_settings').hide();
	  }
	});
	
	var selectedTab = localStorage.getItem('selectedTab');	
	$('#current-tab a[href="' + selectedTab + '"]').tab('show');
	
	//ajax for Messages Tab
		$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	/*****************List No of Rows***********************************/	
	$("#type").change(function() {	
		$.ajax({
			type: "POST",
			url: baseurl+"/admin/ajax/systemmessagetable",
			data: {modulelist: $(this).find(":selected").text()},                   
			dataType    : 'json'
		}) // using the done promise callback
		
		.done(function(data) {						
			//console.log(data);
			showSystemMessagesTab(data);
		});
	});
	$("#type").trigger('change');
	/***************Edit Email Subject and Content Popup****************/
	$("#mail_subjectcontent").on('click', '#module_table tr td:nth-child(4) a,td:nth-child(6) a', function () {
		var $this = $(this);	
		var slugvalue = $this.closest('td').siblings().find('#slug').val();
		$.ajax({
			type: "POST",
			url: baseurl+"/admin/ajax/editmessage",
			data: {slug_name:slugvalue },                   
			dataType    : 'json'
		}) // using the done promise callback 
		
		.done(function(data) {
			//console.log(data);
			showEditMessageContent(data);
		});
	});	
	 /**************Edit Message Popup**********************************/
	$("#mail_subjectcontent").on('click', '#module_table tr td:last-child a', function () { 
		var $this = $(this);	
		var slugvalue = $this.closest('td').siblings().find('#slug').val();
		$.ajax({
			type: "POST",
			url: baseurl+"/admin/ajax/editmailcontent",
			data: {slug_name:slugvalue },                   
			dataType    : 'json'
		}) // using the done promise callback 
		
		.done(function(data) {
			//console.log(data);
			showEditMailContent(data);
		});
	});	
});
/***************Edit Email Subject and Content Popup****************/
function showEditMailContent(data){
	var	str_emailedit ='';	
	str_emailedit	  = str_emailedit + ""
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Event/Action</div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='eventaction' id='eventaction' value='"+data.event+"' disabled> "
				  + "</div></div></div>"
				  + "<div class='row' style='display:none;'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='slug_name' id='slug_name' value='"+data.slug_name+"' > "
				  + "</div></div></div>"
				  + "<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Email Subject</div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='email_subject' id='email_subject' value='"+data.email_subject+"' > "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Message</div>"
				  + "<div class='col-sm-6'>"+ "<textarea class='form-control' name='email_content' rows='5' id='email_content' >"+data.email_content+"</textarea>"
				  + "</div></div></div>"				
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  +	"<div class='col-sm-3'></div>"
				  + "<div class='col-sm-3 text-right'>"+ "<input type='button' class='form-control btn verification-button' name='email_message_save' id='email_message_save' value='save' >"
				  + "</div></div>"
				  + "<div class='col-sm-12'>"
				  +	"<hr>"
				  +	"<p>Note : You can use HTML in the content to make formatting more attractive.<br> You can use the following Shortcodes [borrower_name]"
				  +	",[borrower_organisation],[loan_apply_date],[loan_bid_close_date],[loan_apply_amount]</p>"
				  + "<hr>"				  
				  + "</div></div>";
	
	$('#email_popup .modal-body').html(str_emailedit);
	$('#email_popup').modal("show");	
	callEmailClickEvent();

}
function callEmailClickEvent(){
	$('#email_message_save').click(function (){
		$('#form-settings').attr('action',baseurl+'/admin/system/emaildata/save');
		$('#form-settings').submit();		
	});
}

 /**************Edit Message Popup**********************************/
function showEditMessageContent(data){	
				
	var	str_edit ='';
	var check = '';
	if(data.send_email==1)			
	{
		check = "checked";
	}else{
		check = "";
	}
	str_edit	  = str_edit +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Module</div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='Module' id='Module' value='"+data.module+"' disabled> "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  + "<div class='col-sm-6'>"+ "<input type='hidden' class='form-control' name='slug' id='slug' value='"+data.slug_name+"'> "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  + "<div class='col-sm-6'>"+ "<input type='hidden' class='form-control' name='email_slug' id='email_slug' value='"+data.email_slug+"'> "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Event/Action</div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='event_action' id='event_action' value='"+data.event_action+"' disabled> "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Message</div>"
				  + "<div class='col-sm-6'>"+ "<textarea class='form-control' name='event_action' rows='5' id='event_action' >"+data.message_text+"</textarea>"
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Send Mail</div>"
				  + "<div class='col-sm-1 text-left'>" + "<input type='checkbox' class='form-control' name='sendmail' id='sendmail' value='"+data.send_email+"'  disabled "+check+" />"
				  + "</div></div></div>"
				   + "<div class='row' style='display:none;'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='sendmail' id='sendmail' value='"+data.send_email+"' > "
				  + "</div></div></div>"
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'></div>"
				  +	"<div class='col-sm-3'></div>"				 
				  + "<div class='col-sm-3 text-right'>"+ "<input type='button' class='form-control btn verification-button' name='module_message_save' id='module_message_save' value='save' ></div>"			  
				  +	"<div class='col-sm-3'></div></div></div>";
	$('#module_popup .modal-body').html(str_edit);
	$('#module_popup').modal("show");		
	callModuleClickEvent();	
}
function callModuleClickEvent(){
	$('#module_message_save').click(function (){
		$('#form-settings').attr('action',baseurl+'/admin/system/messages/save');
		$('#form-settings').submit();
		
	});
}
/*****************List No of Rows***********************************/	
function showSystemMessagesTab(data) {
	
	var	str="";
	str		=	"<div class='row'><div class='table-responsive'><table class='table table-bordered .tab-fontsize text-left'>";
	str		=	str+"<thead><tr><th class='tab-head text-left col-sm-2'>Module</th>";
	str		=	str+"<th class='tab-head text-left col-sm-2'>Event Action</th>";		
	str		=	str+"<th class='tab-head text-left col-sm-5'>Message</th>";
	str		=	str+"<th class='tab-head text-center col-sm-1'>Send Email</th>";
	str		=	str+"<th class='tab-head text-center col-sm-1'>Edit Message</th>";
	str		=	str+"<th class='tab-head text-center col-sm-1'>Edit Email</th></tr></thead>";
	str		=	str+"<tbody>";
	if(data.rows.length > 0){
		$.each( data.rows, function( key ) {
			str	=	str+"<tr><td style='display:none;'><input type='hidden' id='slug' name='slug_name' value='"+data.rows[key].slug_name+"'></td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].module+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].event_action+"</td>";
			str	=	str+"<td id='edit_message'><a class='settings-cursor'>";
			str	=	str+data.rows[key].message_text+"</a></td>";					
			str	=	str+"<td class='text-center'>";
			str	=	str+data.rows[key].send_email_text+"</td>";					
			str	=	str+"<td class='text-center'>";
			str	=	str+"<a class='settings-cursor' title='Edit Message'><i class='fa fa-edit'></i>"+"</a></td>";					
			str	=	str+"<td class='text-center'>";
			if(data.rows[key].send_email_text == "Yes"){
				str	=	str+"<a class='settings-cursor' title='Edit Mail Content'><i class='fa fa-edit'></i></a>";
			}
			str	=	str+"</td>";
			
			str	=	str+"</tr>";
		});
	}else{
		str	=	str+"<tr><td colspan='5'> No Data Found</td></tr>";
	}
	str	=	str+"</tbody></table></div></div>";
	$('#module_table').html(str);
}
function previewBorTerms(){	
	var bortermscontent = $('#bor_terms').val();
	var displaycontentformat = "<div class='row'><div class='col-sm-12'>"+bortermscontent+"</div></div>";
	$('#borTermsPopup .modal-body').html(displaycontentformat);
	$('#borTermsPopup').modal("show");
}
function previewInvTerms(){	
	var invtermscontent = $('#inv_terms').val();
	var displaycontentformat = "<div class='row'><div class='col-sm-12'>"+invtermscontent+"</div></div>";
	$('#invTermsPopup .modal-body').html(displaycontentformat);
	$('#invTermsPopup').modal("show");
}
function previewBorFirsttimePopup(){	
	var borfirstcontent = $('#bor_popup').val();
	var displaycontentformat = "<div class='row'><div class='col-sm-12'>"+borfirstcontent+"</div></div>";
	$('#borFirstPopup .modal-body').html(displaycontentformat);
	$('#borFirstPopup').modal("show");
}
function previewInvFirsttimePopup(){	
	var invfirstcontent = $('#inv_popup').val();
	var displaycontentformat = "<div class='row'><div class='col-sm-12'>"+invfirstcontent+"</div></div>";
	$('#invFirstPopup .modal-body').html(displaycontentformat);
	$('#invFirstPopup').modal("show");
}
function handleChange(input) {
    if (input.value < 0) input.value = 0;
    if (input.value > 20) input.value = 20;
}
