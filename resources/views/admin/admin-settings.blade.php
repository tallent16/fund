@extends('layouts.dashboard')
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
		
		<button type="submit" id="update_settings" class="btn verification-button">Save Settings</button>
	</form>	
</div>
	@endsection  
	@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script>
var baseurl = "{{url('')}}"  
</script>
<script src="{{ url('js/admin-settings.js')}}" type="text/javascript"></script>		
@endsection
@stop
