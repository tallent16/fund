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
        });
        function showSystemMessagesTab(data) {
			
			var	str;
			str		=	"<div class='row'><div class='table-responsive'><table class='table table-bordered .tab-fontsize text-left'>";
			str		=	str+"<thead><tr><th class='tab-head text-left col-sm-2'>Module</th>";
			str		=	str+"<th class='tab-head text-left col-sm-2'>Event Action</th>";		
			str		=	str+"<th class='tab-head text-left col-sm-6'>Message</th>";
			str		=	str+"<th class='tab-head text-left col-sm-2'>Send Email</th></tr></thead>";
			str		=	str+"<tbody>";
			if(data.rows.length > 0){
				$.each( data.rows, function( key ) {
					str	=	str+"<tr><td>";
					str	=	str+data.rows[key].module+"</td>";
					str	=	str+"<td>";
					str	=	str+data.rows[key].event_action+"</td>";
					str	=	str+"<td>";
					str	=	str+data.rows[key].message_text+"</td>";
					str	=	str+"<td>";
					str	=	str+data.rows[key].send_email_text+"</td>";
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
	<form class="form-inline" id="form-settings" method="post" enctype="multipart/form-data">	
	<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
		@var $settings_list = $adminsettingModel->settingsList;		
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
							{{ Lang::get('Mail Subject And Content') }}
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
