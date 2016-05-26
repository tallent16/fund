@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var 	baseUrl	=	"{{url()}}"
		var 	replyUrl=	baseUrl+'/ajax/borrower/send_reply'
		$(document).ready(function() {
			$("#manage_bids_button").on('click',function() {
				window.location	=	$(this).attr("data-action");
			});
		});
	</script>
	
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
				@if( ($LoanDetMod->loan_status	==	LOAN_STATUS_DISBURSED)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_LOAN_REPAID) )
					<li>
						<a data-toggle="tab" href="#payment_schedule">{{Lang::get('PAYMENT SCHEDULE')}}</a>
					</li>
				@endif
				@if( ($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_CLOSED_FOR_BIDS)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED) )
					<li  {{ ($pos !== false)?"class='active'":""}}>
						<a data-toggle="tab" href="#menu3">{{ Lang::get('borrower-myloans.bid_info') }}</a>
					</li>
				@endif		
				
			</ul>

			<div class="tab-content myloan-wrapper">
				<div id="home" class="tab-pane fade {{ ($pos === false)?'in active':'' }}">
					@include('widgets.common.tab.myloans_loandetails') 
				</div>
				<div id="menu1" class="tab-pane fade">
					@include('widgets.common.tab.myloans_companydetails')
				</div>
				<div id="menu2" class="tab-pane fade">
					@include('widgets.borrower.tab.myloans_loanupdates')
				</div>
				@if( ($LoanDetMod->loan_status	==	LOAN_STATUS_DISBURSED)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_LOAN_REPAID) )
					
					<div id="payment_schedule" class="tab-pane fade">
						@include('widgets.investor.tab.myloans_payment_schedule')
					</div>	
				@endif
				@if( ($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_CLOSED_FOR_BIDS)
					||	($LoanDetMod->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED) )
					<div id="menu3" class="tab-pane fade  {{ ($pos !== false)?'in active':'' }}">
						@include('widgets.borrower.tab.myloans_bidinfo')
					</div>
				@endif
			</div>
		</div>
					
		<div class="col-sm-12 col-lg-4 bid-table-space"> 
			<!-- summary panel starts here -->
			<div class="panel panel-default">
				<div class="panel-body ">
					@include('widgets.common.myloans_summary') 
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
