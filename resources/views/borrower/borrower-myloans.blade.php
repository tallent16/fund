@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>		
@endsection
@section('page_heading','My Loans'))
@section('section')     

<div class="col-sm-12 space-around"> 			
	<div class="row">	
					
		<div class="col-sm-12 col-lg-8 ">							
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#home">LOAN DETAILS</a></li>
				<li><a data-toggle="tab" href="#menu1">COMPANY DETAILS</a></li>
				<li><a data-toggle="tab" href="#menu2">LOAN UPDATES</a></li>
				<li><a data-toggle="tab" href="#menu3">BID INFO</a></li>
			</ul>

			<div class="tab-content myloan-wrapper">
				<div id="home" class="tab-pane fade in active">
					@include('widgets.borrower.tab.myloans_loandetails')
				</div>
				<div id="menu1" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_companydetails')
				</div>
				<div id="menu2" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_loanupdates')
				</div>
				<div id="menu3" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_bidinfo')
				</div>
			</div>
		</div>
					
		<div class="col-sm-12 col-lg-4"> 
			<!--<div class="row">-->
				
				<div class="panel panel-default">
					<div class="panel-body">
						
						<div class="row">
							<div class="col-md-12">
								<div class="pull-right">
									<i class="fa fa-exclamation-circle"></i>
								</div>
							</div>
						</div>
					
					<div class="col-md-12">
					
						<div class="row space-around">
							<div class="col-md-3 col-sm-4 col-xs-4">
								5
							</div>
							<div class="col-md-6 col-sm-4 col-xs-4">
								$8,500.00
							</div>
							<div class="col-md-3 col-sm-4 col-xs-4">
								255
							</div>
						</div>
						
						<div class="row space-around bidders-value">
							<div class="col-md-3 col-sm-4 col-xs-4">
								Bidders
							</div>
							<div class="col-md-6 col-sm-4 col-xs-4">
								of $20,000.00 Goal
							</div>
							<div class="col-md-3 col-sm-4 col-xs-4">
								Days to go
							</div>
						</div>
						
				<div class="row  space-around">	
						<div class="progress">
							<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
							aria-valuemin="0" aria-valuemax="100" style="width:70%">		
							</div>
						</div>
					</div>	
					
					<div class="row  space-around">	
						<div class="row">						
							<div class="col-md-7 col-xs-7"> <i class="fa fa-file-text"></i> <span class="bid-now-section"> Grade of Borrower:</span></div>
							<div class="col-md-5 col-xs-5">C</div>
						</div>
						
						<div class="row">						
							<div class="col-md-7 col-xs-7"> <i class="fa fa-database"></i> <span class="bid-now-section"> Type of Loan:</span></div>
							<div class="col-md-5 col-xs-5">Monthly repayment</div>
						</div>
						
						<div class="row">				 		
							<div class="col-md-7 col-xs-7"> <i class="fa fa-archive"></i> <span class="bid-now-section"> Tenure:</span></div>
							<div class="col-md-5 col-xs-5">12</div>
						</div>
						
						<div class="row">							
							<div class="col-md-7 col-xs-7"> <i class="fa fa-inr"></i> <span class="bid-now-section"> Interest Range:</span></div>
							<div class="col-md-5 col-xs-5">10%</div>
						</div>
						
						<div class="row">						
							<div class="col-md-7 col-xs-7"> <i class="fa fa-line-chart"></i> <span class="bid-now-section"> Average Interest Bidded:</span></div>
							<div class="col-md-5 col-xs-5">13%</div>
						</div>
						
						<div class="row">					
							<div class="col-md-7 col-xs-7"> <i class="fa fa-usd"></i> <span class="bid-now-section"> Amount bidded:</span></div>
							<div class="col-md-5 col-xs-5">$50,000</div>
						</div>
						
						<div class="row">						
							<div class="col-md-7 col-xs-7"> <i class="fa fa-info-circle"></i> <span class="bid-now-section"> Status:</span></div>
							<div class="col-md-5 col-xs-5">Open for Lending</div>
						</div>
					</div>	
						
						<div class="row space-around">
							<div class="text-center">	
									<button type="submit" class="btn add-director-button">BID NOW  <i class="fa fa-gavel"></i></button>
							</div>
						</div>
						
					</div>
						
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
