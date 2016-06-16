@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script type="text/javascript">
		
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
						console.log(data);
						showSystemMessagesTab(data);
					});
				});
            $("#type").trigger('change');
            /******************************************************/
			$("#mail_subjectcontent").on('click', '#module_table tr', function (e) {
				e.stopPropagation();
				var $this = $(this);
				var trid = $this.find('#slug').val();
															          
				$.ajax({
						type: "POST",
						url: "{{url()}}/admin/ajax/editmessage",
						data: {slug_name: $this.find('#slug').val()},                   
						dataType    : 'json'
					}) // using the done promise callback 
					
					.done(function(data) {						
						//console.log(data);
						showEditForm(data);
					});
			});				
			 /******************************************************/
        });
        
        function showEditForm(data){
			var	str;	
			str		= str +	"<div class='row'><div class='col-sm-12'>"
						  +	"<div class='col-sm-3'>Module</div>"
						  + "<div class='col-sm-6'>"+ "<input type='text' class='form-control' name='Module' id='Module' value='"+data.module+"'> "
						  + "</div></div></div>"	
						  +	"<div class='row'><div class='col-sm-12'>"
						  +	"<div class='col-sm-3'></div>"
						  + "<div class='col-sm-6'>"+ "<input type='hidden' class='form-control' name='slug' id='slug' value='"+data.slug_name+"'> "
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
						  + "<div class='col-sm-6 text-left'>"+ "<input type='checkbox' class='form-control' name='sendmail' id='sendmail' value='"+data.send_email+"'  >"
						  + "</div></div></div>";
		
			$('#module_popup .modal-body').html(str);
			$('#module_popup').modal("show");			
		}
		
        function showSystemMessagesTab(data) {
			
			var	str;
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
					str	=	str+"Edit Message"+"</td>";
					str	=	str+"<td>";
					str	=	str+"Edit Email"+"</td>";
					str	=	str+"</tr>";
				});
			}else{
				str	=	str+"<tr><td colspan='5'> No Data Found</td></tr>";
			}
			str	=	str+"</tbody></table></div></div>";
			$('#module_table').html(str);
		}
		 
    </script>	
@endsection
@section('page_heading',Lang::get('Settings') )
@section('section')  
<div class="col-sm-12 space-around">
	@var $settings_list = $adminsettingModel->settingsList;	
	<form class="form-inline" id="form-settings" method="post" enctype="multipart/form-data">	
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
