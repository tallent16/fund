@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>		
	<script src="{{ url("js/loan-details.js") }}" type="text/javascript"></script>		
	<script>
		var baseUrl	=	"{{url()}}"
		var replyUrl=	baseUrl+'/ajax/investor/send_reply'
	</script>
	<script src="{{ url("js/common.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','My Loans'))
@section('section')     
<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
@var	$commnetInfo	=	$LoanDetMod->commentInfo	
<div class="col-sm-12 space-around"> 	
	@if($submitted)
		<div class="row annoucement-msg-container">
			<div class="alert alert-success">
				<a aria-label="close" data-dismiss="alert" class="close" href="#">×</a>	
					@if($subType	==	"yes")
						{{Lang::get('Bid Cancelled Successfully')}}
					@else
						{{Lang::get('Bid Submitted Successfully')}}
					@endif			
			</div>
		</div>		
	@endif
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
						@if(count($commnetInfo) > 0)
							@include('widgets.common.myloans_comments',array("commnetInfo"=>$commnetInfo)) 
						@else
							<p>
								{{ Lang::get('borrower-myloans.no_comments') }} 
							</p>
						@endif
					</div>	<!--end panel body-->					
				</div>
				
		<!---	</div>-->
		</div>					
										
	</div>								
</div>

    @endsection  
@stop
