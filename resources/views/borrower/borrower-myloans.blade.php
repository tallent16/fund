@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var baseUrl	=	"{{url()}}"
	</script>
	<script src="{{ asset("js/common.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','My Loans'))
@section('section')     
@var	$pos 			= 	strpos(base64_decode($loan_id), "bids");
@var	$commnetInfo	=	$LoanDetMod->commentInfo	
<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
<div class="col-sm-12 space-around"> 			
	<div class="row">	
					
		<div class="col-sm-12 col-lg-8 ">							
			<ul class="nav nav-tabs">
				<li {{ ($pos === false)?"class='active'":""}}>
					<a data-toggle="tab" href="#home">LOAN DETAILS</a>
				</li>
				<li><a data-toggle="tab" href="#menu1">COMPANY DETAILS</a></li>
				<li><a data-toggle="tab" href="#menu2">LOAN UPDATES</a></li>
				<li  {{ ($pos !== false)?"class='active'":""}}>
					<a data-toggle="tab" href="#menu3">BID INFO</a>
				</li>
			</ul>

			<div class="tab-content myloan-wrapper">
				<div id="home" class="tab-pane fade {{ ($pos === false)?'in active':'' }}">
					@include('widgets.common.tab.myloans_loandetails') 
				</div>
				<div id="menu1" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_companydetails')
				</div>
				<div id="menu2" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_loanupdates')
				</div>
				<div id="menu3" class="tab-pane fade  {{ ($pos !== false)?'in active':'' }}">
					@include('widgets.borrower.tab.myloans_bidinfo')
				</div>
			</div>
		</div>
					
		<div class="col-sm-12 col-lg-4"> 
			<!-- summary panel starts here -->
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
								{{$LoanDetMod->no_of_bidders}}
							</div>
							<div class="col-md-6 col-sm-4 col-xs-4">
								{{$LoanDetMod->total_bid}}
							</div>
							<div class="col-md-3 col-sm-4 col-xs-4">
								{{$LoanDetMod->days_to_go}}
							</div>
						</div>
						
						<div class="row space-around bidders-value">
							<div class="col-md-3 col-sm-4 col-xs-4">
								Bidders
							</div>
							<div class="col-md-6 col-sm-4 col-xs-4">
								of {{$LoanDetMod->apply_amount}} Goal
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
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-file-text"></i> 
									<span class="bid-now-section"> Grade of Borrower:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->borrower_risk_grade}}</div>
							</div>
							
							<div class="row">						
								<div class="col-md-7 col-xs-7">
									<i class="fa fa-database"></i>
									<span class="bid-now-section"> Type of Loan:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->repayment_type}}</div>
							</div>
							
							<div class="row">				 		
								<div class="col-md-7 col-xs-7">
									<i class="fa fa-archive"></i>
									<span class="bid-now-section"> Tenure:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->loan_tenure}}</div>
							</div>
							
							<div class="row">							
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-inr"></i> 
									<span class="bid-now-section"> Interest Range:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->target_interest}}%</div>
							</div>
							
							<div class="row">						
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-line-chart"></i> 
									<span class="bid-now-section"> Average Interest Bidded:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->avg_int_bid}}%</div>
							</div>
							
							<div class="row">					
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-usd"></i> 
									<span class="bid-now-section"> Amount bidded:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->total_bid}}</div>
							</div>
							
							<div class="row">						
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-info-circle"></i> 
									<span class="bid-now-section"> Status:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->statusText}}</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
			<!-- summary panel ends here -->
			
			<!-- comments panel starts here -->
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
						@if(count($commnetInfo) > 0)
							@include('widgets.common.myloans_comments',array("commnetInfo"=>$commnetInfo)) 
						@else
							<p>
								No Comments Found
							</p>
						@endif
					</div>	<!--end panel body-->					
				</div>
			<!-- comments panel ends here -->
		</div>					
										
	</div>								
</div>
	@endsection  
@stop
