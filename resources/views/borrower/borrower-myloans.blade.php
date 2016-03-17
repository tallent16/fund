@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var baseUrl	=	"{{url()}}"
	</script>
	<script src="{{ asset("js/common.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('borrower-loaninfo.page_heading'))
@section('section')     
@var	$pos 			= 	strpos(base64_decode($loan_id), "bids");
@var	$commnetInfo	=	$LoanDetMod->commentInfo	
<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
<div class="col-sm-12 space-around"> 			
	<div class="row">	
					
		<div class="col-sm-12 col-lg-8 ">							
			<ul class="nav nav-tabs">
				<li {{ ($pos === false)?"class='active'":""}}>
					<a data-toggle="tab" href="#home">{{ Lang::get('borrower-myloans.loan_details') }}</a>
				</li>
				<li><a data-toggle="tab" href="#menu1">{{ Lang::get('borrower-myloans.company_details') }}</a></li>
				<li><a data-toggle="tab" href="#menu2">{{ Lang::get('borrower-myloans.loan_updates') }}</a></li>
				<li  {{ ($pos !== false)?"class='active'":""}}>
					<a data-toggle="tab" href="#menu3">{{ Lang::get('borrower-myloans.bid_info') }}</a>
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
				<div class="panel-body bid-table-space">
					
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-3 col-sm-4 col-xs-4">
								{{$LoanDetMod->no_of_bidders}}
							</div>
							<div class="col-md-5 col-sm-4 col-xs-4">
								{{$LoanDetMod->total_bid}}
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								{{$LoanDetMod->days_to_go}}<span class="pull-right"><i class="fa fa-exclamation-circle"></i></span>
							</div>
						</div>
						
						<div class="row bidders-value">
							<div class="col-md-3 col-sm-4 col-xs-4">
								{{ Lang::get('borrower-myloans.bidders') }}
							</div>
							<div class="col-md-5 col-sm-4 col-xs-4">
								{{ Lang::get('borrower-myloans.of') }} {{$LoanDetMod->apply_amount}} {{ Lang::get('borrower-myloans.goal') }}
							</div>
							<div class="col-md-4 col-sm-4 col-xs-4">
								{{ Lang::get('borrower-myloans.days_left') }}
							</div>
						</div>
						<div class="row  space-around">	
								<div class="progress">
									<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
									aria-valuemin="0" aria-valuemax="100" style="width:{{$LoanDetMod->perc_funded}}%">		
									</div>
								</div>
							</div>	
								
						<div class="row  space-around">	
							<div class="row">												
								<div class="col-md-7 col-xs-7"> 									
									<i class="fa fa-file-text"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.grade_borrower') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->borrower_risk_grade}}</div>
							</div>
							
							<div class="row">													
								<div class="col-md-7 col-xs-7">									
									<i class="fa fa-database"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.loan_type') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->repayment_type}}</div>
							</div>
							
							<div class="row">											 		
								<div class="col-md-7 col-xs-7">									
									<i class="fa fa-archive"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.tenure') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->loan_tenure}}</div>
							</div>
							
							<div class="row">										
								<div class="col-md-7 col-xs-7"> 									
									<i class="fa fa-inr fa-lg"></i><span class="bid-now-section"> {{ Lang::get('borrower-myloans.interest_range') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->target_interest}} %</div>
							</div>
							
							<div class="row">						
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-bar-chart-o "></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.avg_interest_bid') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->avg_int_bid}} %</div>
							</div>
							
							<div class="row">					
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-dollar fa-lg"></i><span class="bid-now-section"> {{ Lang::get('borrower-myloans.amt_bidded') }}:</span>
								</div>
								<div class="col-md-5 col-xs-5">{{$LoanDetMod->total_bid}}</div>
							</div>
							
							<div class="row">						
								<div class="col-md-7 col-xs-7"> 
									<i class="fa fa-info-circle fa-lg"></i><span class="bid-now-section">{{ Lang::get('borrower-loaninfo.status') }}:</span>
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
								{{ Lang::get('borrower-myloans.comments') }}  
							</div>													
						</div>							
					</div>	<!--end panel head-->

					<div class="panel-body"><!--panel body--> 
						@if(count($commnetInfo) > 0)
							@include('widgets.common.myloans_comments',array("commnetInfo"=>$commnetInfo)) 
						@else
							<p>
								{{ Lang::get('borrower-myloans.no_comments') }} 
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
