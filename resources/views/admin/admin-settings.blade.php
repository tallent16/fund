@extends('layouts.dashboard')
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script>
var baseurl = "{{url('')}}"
$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	/*******************************************************/
	$("#type").change(function() {	
		$.ajax({
			type: "POST",
			url: "{{url()}}/admin/ajax/systemmessagetable",
			data: {modulelist: $(this).find(":selected").text()},                   
			dataType    : 'json'
		}) // using the done promise callback
		
		.done(function(data) {						
			//console.log(data);
			showSystemMessagesTab(data);
		});
	});
	$("#type").trigger('change');
	/******************************************************/
	$("#mail_subjectcontent").on('click', '#module_table tr td:nth-child(4),:nth-child(6)', function () {
		var $this = $(this);	
		var slugvalue = $this.closest('td').siblings().find('#slug').val();
		$.ajax({
			type: "POST",
			url: "{{url()}}/admin/ajax/editmessage",
			data: {slug_name:slugvalue },                   
			dataType    : 'json'
		}) // using the done promise callback 
		
		.done(function(data) {
			//console.log(data);
			showEditForm(data);
		});
	});	
	 /******************************************************/
	$("#mail_subjectcontent").on('click', '#module_table tr td:last-child', function () { 
		var $this = $(this);	
		var slugvalue = $this.closest('td').siblings().find('#slug').val();
		$.ajax({
			type: "POST",
			url: "{{url()}}/admin/ajax/editmailcontent",
			data: {slug_name:slugvalue },                   
			dataType    : 'json'
		}) // using the done promise callback 
		
		.done(function(data) {
			//console.log(data);
			showEditMailContent(data);
		});
	});	
});        

function showEditMailContent(data){
	var	str_emailedit ='';	
	str_emailedit	  = str_emailedit + ""
				  +	"<div class='row'><div class='col-sm-12'>"
				  +	"<div class='col-sm-3'>Event/Action</div>"
				  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='eventaction' id='eventaction' value='"+data.event+"'> "
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
				  +	"<div class='col-sm-4'></div>"
				  + "<div class='col-sm-2 text-right'>"+ "<input type='button' class='form-control btn btn-primary' name='email_message_save' id='email_message_save' value='save' >"
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
function callModuleClickEvent(){
	$('#module_message_save').click(function (){
		$('#form-settings').attr('action',baseurl+'/admin/system/messages/save');
		$('#form-settings').submit();
	});
}
function showEditForm(data){	
				
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
				  +	"<div class='col-sm-4'></div>"
				  + "<div class='col-sm-2 text-right'>"+ "<input type='button' class='form-control btn btn-primary' name='module_message_save' id='module_message_save' value='save' >"
				  + "</div></div></div>";
	$('#module_popup .modal-body').html(str_edit);
	$('#module_popup').modal("show");		
	callModuleClickEvent();	
}

function showSystemMessagesTab(data) {
	
	var	str="";
	str		=	"<div class='row'><div class='table-responsive'><table class='table table-bordered .tab-fontsize text-left'>";
	str		=	str+"<thead><tr><th class='tab-head text-left col-sm-2'>Module</th>";
	str		=	str+"<th class='tab-head text-left col-sm-2'>Event Action</th>";		
	str		=	str+"<th class='tab-head text-left col-sm-6'>Message</th>";
	str		=	str+"<th class='tab-head text-left col-sm-1'>Send Email</th>";
	str		=	str+"<th colspan='2' class='tab-head text-center col-sm-1'>Action</th></tr></thead>";
	str		=	str+"<tbody>";
	if(data.rows.length > 0){
		$.each( data.rows, function( key ) {
			str	=	str+"<tr><td style='display:none;'><input type='hidden' id='slug' name='slug_name' value='"+data.rows[key].slug_name+"'></td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].module+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].event_action+"</td>";
			str	=	str+"<td id='edit_message'>";
			str	=	str+data.rows[key].message_text+"</td>";					
			str	=	str+"<td>";
			str	=	str+data.rows[key].send_email_text+"</td>";					
			str	=	str+"<td>";
			str	=	str+"<i class='fa fa-edit'></i> Message"+"</td>";					
			str	=	str+"<td>";
			if(data.rows[key].send_email_text == "Yes"){
				str	=	str+"<i class='fa fa-edit'></i>  Email";
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
 </script>
 <script src="{{ url('js/admin-settings.js')}}" type="text/javascript"></script>		
@endsection
@section('page_heading',Lang::get('Settings') )
@section('section')  
<div id="alert-module-update"></div>	
<div class="col-sm-12 space-around">
	@var $settings_list = $adminsettingModel->settingsList;	
	<form class="form-inline" id="form-settings" method="post" enctype="multipart/form-data" action="{{url('admin/system/settings/save')}}">	
	<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
			
		<div class="row">
			<div class="col-lg-12 col-md-6 col-xs-12">
				<ul class="nav nav-tabs">
					<li class="active">
						<a 	data-toggle="tab"
							href="#general">
							{{ Lang::get('General') }}
						</a>
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#mail_config">
							{{ Lang::get('Mail Configuration') }}
						</a>
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#mail_subjectcontent">
							{{ Lang::get('Messages') }}
						</a>					
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#loan_feescharges">
							{{ Lang::get('Loan Fees And Charges') }}
						</a>
					</li>
				</ul>
								
				<div class="tab-content">
					<!-------first-tab--------------------------------->
					@include('widgets.admin.tab.settings_general')
					<!-------second tab--starts------------------------>
					@include('widgets.admin.tab.settings_mailconfig')
					<!-------third tab--starts------------------------>
					@include('widgets.admin.tab.settings_mailsubjectcontent')
					<!-------fourth tab--starts------------------------>
					@include('widgets.admin.tab.settings_loanfeescharges')
				</div><!--tab content-->
				
			</div>
		</div>
		
		<button type="submit" class="btn verification-button">Save Settings</button>
	</form>	
</div>
	@endsection  
@stop
