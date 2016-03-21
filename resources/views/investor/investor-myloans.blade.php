@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>		
	<script src="{{ url("js/loan-details.js") }}" type="text/javascript"></script>		
@endsection
@section('page_heading','My Loans'))
@section('section')     

<div class="col-sm-12 space-around"> 			
	<div class="row">	
					
		<div class="col-sm-12 col-lg-8 ">							
			<ul class="nav nav-tabs">
				<li class="active">
					<a data-toggle="tab" href="#home">{{Lang::get('LOAN DETAILS')}}</a>
				</li>			
				<li>
					<a data-toggle="tab" href="#company_details">{{Lang::get('COMPANY DETAILS')}}</a>
				</li>			
				<li>
					<a data-toggle="tab" href="#payment_schedule">{{Lang::get('PAYMENT SCHEDULE')}}</a>
				</li>			
			</ul>

			<div class="tab-content myloan-wrapper">
				<div id="home" class="tab-pane fade in active">
					@include('widgets.common.tab.myloans_loandetails')
				</div>
				<div id="company_details" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_companydetails')
				</div>
				<div id="payment_schedule" class="tab-pane fade">
					@include('widgets.investor.tab.myloans_payment_schedule')
				</div>			
			</div>
		</div>
					
		<div class="col-sm-12 col-lg-4"> 
			<!--<div class="row">-->
				
				<div class="panel panel-default">
					<div class="panel-body">
						@include('widgets.common.myloans_summary') 
					</div>
				</div>
											
			<!--</div> -->

		<!--	<div class="row">	--->
				<div class="panel panel-primary panel-container myloans">
					
					<div class="panel-heading panel-headsection"><!--panel head-->
						<div class="row">
							<div class="col-xs-1 text-right">
								<span class="pull-left"><i class="fa fa-comments-o"></i></span> 
							</div>			
							<div class="col-xs-10">	
								Comments  
							</div>													
						</div>							
					</div>	<!--end panel head-->

					<div class="panel-body"><!--panel body--> 
						<div class="col-md-12 comments-section">		
							<div class="row">						
								<div class="col-md-6"><i class="fa fa-user panel-subhead"></i>  <span class="loan-comments">Mathew</span></div>
								<div class="col-md-6 text-right"><span class="loan-comments">about a month ago</span></div>
								<div class="col-md-12">
									<p>My prayers that yout financial goal will be met with a little extra.</p>
									<p class="loan-comments text-right">reply</p>
								</div>		
															
							</div>
							<div class="row">								
								<div class="col-md-6"><i class="fa fa-user panel-subhead"></i>  <span class="loan-comments">Amanda</span></div>
								<div class="col-md-6 text-right"><span class="loan-comments">about a month ago</span></div>		
								<div class="col-md-12">
									<p>I'm excitedly waiting for the next step.Have a great weekend!.</p>
									<p class="loan-comments text-right">reply</p>
								</div>
															
							</div>
							<div class="row">								
								<div class="col-md-6"><i class="fa fa-user panel-subhead"></i>  <span class="loan-comments">Xavier</span></div>
								<div class="col-md-6 text-right"><span class="loan-comments">about a month ago</span></div>		
								<div class="col-md-12">
									<p>Thank you all so very much for your continued support.</p>
									<p class="loan-comments text-right">reply</p>
								</div>													
							</div>
							<div class="row">							
								<div class="col-md-6"><i class="fa fa-user panel-subhead"></i>  <span class="loan-comments">Anthony</span></div>
								<div class="col-md-6 text-right"><span class="loan-comments">about a month ago</span></div>	
								<div class="col-md-12">
									<p>I've been keeping a blog for a number of years. The blog posts are short and the Overall feel is of my debt consolidation.</p>
									<p class="loan-comments text-right">reply</p>
								</div>															
							</div>
						</div>
					</div>	<!--end panel body-->					
				</div>
				
		<!---	</div>-->
		</div>					
										
	</div>								
</div>

    @endsection  
@stop
