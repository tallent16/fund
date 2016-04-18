@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	 
	@endsection
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container">
		
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{ Lang::get('LOAN APPROVAL')}}</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->

			<div class="panel-body applyloan table-border-custom">				
				<div class="col-sm-12 text-right"> 					
					<button type="button" class="btn verification-button">
						{{ Lang::get('Approve')}}</button>
					<button type="button" class="btn verification-button">						
						{{ Lang::get('Cancel')}}</button>
					<button type="button" class="btn verification-button">						
						{{ Lang::get('Save Comments')}}</button>
					<button type="button" class="btn verification-button">						
						{{ Lang::get('Return to Borrower')}}</button>					
				</div>
			
		
				<div class="col-lg-12 col-md-6 col-xs-12 space-around">
					<ul class="nav nav-tabs">
						<li class="active">
							<a 	data-toggle="tab"
								href="#loan_details">
								{{ Lang::get('LOAN DETAILS') }}
							</a>
						</li>
						<li>
							<a 	data-toggle="tab"
								href="#comments">
								{{ Lang::get('COMMENTS') }}
							</a>
						</li>								
					</ul>					

					<div class="tab-content">						
						<!-------first-tab--------------------------------->
						@include('widgets.admin.tab.loanapproval_loandetails')
						<!-------second tab--starts------------------------>
						@include('widgets.admin.tab.loanapproval_comments')						
					</div><!--tab content-->
				</div>	
			</div><!--panel-body--->
	
	</div><!--panel-->
</div>	

	@endsection  
@stop
