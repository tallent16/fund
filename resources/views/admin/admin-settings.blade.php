@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Settings') )
@section('section')  
<div class="col-sm-12 space-around">
	
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
	
</div>
	@endsection  
@stop
