@extends('layouts.dashboard_admin')
@section('styles')
	{{ Html::style('css/bootstrap-timepicker.css') }}
<!--
	{{ Html::style('css/bootstrap-timepicker.min.css') }}
-->
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
				<ul class="nav nav-tabs" id="current-tab">
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
							{{ Lang::get('Project Fees And Charges') }}
						</a>
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#termsandconditions">
							{{ Lang::get('Terms And Conditions') }}
						</a>
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#firsttimepopup">
							{{ Lang::get('First Time Popup') }}
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
					<!-------fifth tab--starts------------------------>
					@include('widgets.admin.tab.settings_termsandconditions')
					<!-------sixth tab--starts------------------------>
					@include('widgets.admin.tab.settings_firsttimepopup')
				</div><!--tab content-->
				
			</div>
		</div>
		@permission('edit_general_message.admin.settings')	
			<button type="submit" id="update_settings" class="btn verification-button">Save Settings</button>
		@endpermission
	</form>	
</div>
	@endsection  
	@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script>
var baseurl = "{{url('')}}"  
</script>
<script src="{{ url('js/admin-settings.js')}}" type="text/javascript"></script>		
<script src="{{ url('js/bootstrap-timepicker.js')}}" type="text/javascript"></script>		
<!--
<script src="{{ url('js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>	
-->
<script>
$('.timepicker').timepicker();
</script>	
@stop
