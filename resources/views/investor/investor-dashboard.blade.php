@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
		<script>
		 var current_loansJson	=	{{$InvDashMod->featuredLoanJson}}		
		 var barchartJson		=	{{$InvDashMod->barChartJson}}
	</script>
	<script src="{{ url("js/investor-dashboard.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Dashboard'))
@section('section')
		@var 	$fundsDepolyedInfo 		= 	$InvDashMod->fundsDepolyedInfo;
		@var 	$invUnderBidInfo 		= 	$InvDashMod->invUnderBidInfo;
		@var 	$overDueInfo 			= 	$InvDashMod->overDueInfo;
		@var 	$Investments_verified 	= 	$InvDashMod->invested_amount;
		@var 	$Investments_pending 	= 	$InvDashMod->pending_investment;
		@var 	$deposits_verified 		= 	$InvDashMod->deposits;
		@var 	$deposits_pending 		= 	$InvDashMod->pending_deposits;
		@var 	$withdrawals_verified 	= 	$InvDashMod->withdrawals;
		@var 	$withdrawals_pending	= 	$InvDashMod->pending_withdrawals;
		@var 	$earnings_verified		= 	$InvDashMod->earnings_verified;
		@var 	$earnings_pending		= 	$InvDashMod->earnings_pending;
		@var 	$ava_for_invest			= 	$InvDashMod->ava_for_invest;
		@var	$invFeatureLoans		=	$InvDashMod->featuredLoanInfo;
		<div class="col-sm-12 space-around"> 
			<!--second row--->
			<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container table-border-custom">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-10 col-lg-10">
									<span class="pull-left">
										@if( $InvDashMod->isFeaturedLoanInfo	==	"yes" )
											{{Lang::get('FEATURED LOANS')}}
										@else
											{{Lang::get('AVAILABLE PROJECTS')}}
										@endif
									</span> 
								</div>
								<div class="col-xs-2 col-lg-1">
									<i class="fa fa-caret-left cursor-pointer"></i>
								</div>
								<div class="col-xs-2 col-lg-1">
									<i class="fa fa-caret-right cursor-pointer"></i>
								</div>	
																
							</div>							
						</div>	<!--end panel head-->
						
						<div class="panel-body"><!--panel body-->
								<input 	type="hidden" id="current_loan_index" 
										value="0" />
							   <div class="panel-subhead" id="cur_loan_subhead">
								 	@if(isset($invFeatureLoans[0]))
											{{$invFeatureLoans[0]->business_name}}
										@endif
								</div>
							   <div  id="cur_loan_content">
								 	@if(isset($invFeatureLoans[0]))
										{{$invFeatureLoans[0]->purpose}}
									@endif
								</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table text-left">								
								<tbody>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Amount')}}
										</td> 
										<td  id="cur_project_amount">
											 @if(isset($invFeatureLoans[0]))
												{{number_format($invFeatureLoans[0]->amount,2,'.',',')}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Amount Realised')}}
										</td> 
										<td  id="cur_project_amount_realized">
											 @if(isset($invFeatureLoans[0]))
												{{number_format($invFeatureLoans[0]->amount_realized,2,'.',',')}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Close Date')}}
										</td> 
										<td  id="cur_project_close_date">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->close_date}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('No of days to closure')}}
										</td> 
										<td  id="cur_project_noofdays">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->funding_duration}}
											@endif
										</td>										
									</tr>
								</tbody>
							</table>							 
						</div> <!---table end--->   	
					</div>
				</div>
				<!-----first col end----->
				<!-----second col-------->
				<div class="col-lg-6 col-md-6">
<!--
					<div class="panel panel-default">
						<div class="panel-body">
							@section ('cchart4_panel_title',Lang::get('Return on Investment(%)'))
							@section ('cchart4_panel_body')
							@include('widgets.charts.cbarchart')
							@endsection
							@include('widgets.panel', array('header'=>true, 'as'=>'cchart4'))
						</div>								
					</div>	
-->
				</div>			
			<!--second col end--->				
		</div>
		<!---third row---->
		<div class="row">
			 <div class="col-lg-12 col-md-12">
				 
				 <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
       <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">{{Lang::get('PROJECTS FUNDED')}}
          <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
        
						 <div class="panel panel-primary panel-container">
								
					<div class="table-responsive">
						<table class="table text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('Creator\'s Name')}}</th>
									<th class="tab-head text-left">{{Lang::get('Grade')}}</th>
									<th class="tab-head text-right">{{Lang::get('Amount Invested')}}</th>
									<th class="tab-head text-center">{{Lang::get('Date of Investment')}}</th>
								</tr>
							</thead>
							<tbody>
								@if($fundsDepolyedInfo)
								@foreach($fundsDepolyedInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['loan_risk_grade']}}</td>
										<td class="text-right">{{number_format($loanRow['bid_amount'],2,'.',',')}}</td>
										<td class="text-center">{{$loanRow['date_of_investment']}}</td>
									</tr>				
								@endforeach	
								@else
									<tr>
										<td colspan="10" class="text-center">
											No Data Found
										</td>
									</tr>
								@endif
												
							</tbody>
						</table>						
					</div><!-----third row end--->	
                </div>              
        
        
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">{{Lang::get('PROJECTS UNDER BID')}}
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        
         <div class="panel panel-primary panel-container">
							
					<div class="table-responsive">
						<table class="table text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('Creator\'s Name')}}</th>
									<th class="tab-head text-left">{{Lang::get('Grade')}}</th>
									<th class="tab-head text-right">{{Lang::get('Amount Invested')}}</th>
									<th class="tab-head text-center">{{Lang::get('Date of Investment')}}</th>
								</tr>
							</thead>
							<tbody>
								@if($invUnderBidInfo)
								@foreach($invUnderBidInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['loan_risk_grade']}}</td>
										<td class="text-right">{{number_format($loanRow['bid_amount'],2,'.',',')}}</td>
										<td class="text-center">{{$loanRow['date_of_investment']}}</td>
									</tr>				
								@endforeach	
								@else
									<tr>
										<td colspan="10" class="text-center">
											No Data Found
										</td>
									</tr>
								@endif
							</tbody>
						</table>											
					</div><!-----third row end--->	
                </div>              
             
        
        
        </div>
      </div>
    </div>
<!--
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">{{Lang::get('OVERDUE LOANS')}}
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
        
				 <div class="panel panel-primary panel-container">
					<div class="table-responsive"><!---table start-->	
<!--
					<table class="table text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('Borrower\'s Name')}}</th>
									<th class="tab-head text-left">{{Lang::get('Grade')}}</th>
									<th class="tab-head text-right">{{Lang::get('Total Amount of Loan')}}</th>
									<th class="tab-head text-right">{{Lang::get('Amount Overdue')}}</th>
									<th class="tab-head text-right">{{Lang::get('Overdue Since')}}</th>
									<th class="tab-head" colspan="5"></th>																																	
								</tr>
							</thead>
							<tbody>
								@if($overDueInfo)
								@foreach($overDueInfo as $loanRow)
									<tr>
										<td class="text-left">{{$loanRow['business_name']}}</td>
										<td class="text-left">{{$loanRow['borrower_risk_grade']}}</td>
										<td class="text-right">{{number_format($loanRow['accepted_amount'],2,'.',',')}}</td>
										<td class="text-right">{{number_format($loanRow['payment_schedule_amount'],2,'.',',')}}</td>
										<td class="text-right">{{$loanRow['overdue_since']}}</td>
										<td colspan="5"></td>
									</tr>				
								@endforeach
								@else
									<tr>
										<td colspan="10" class="text-center">
											No Data Found
										</td>
									</tr>
								@endif
							</tbody>
						</table>		
						</div>									
-->
<!--
				</div>
-->
				<!-----third row end--->	
<!--
                </div>              
        
        </div>
      </div>
    </div>
  </div> 
-->


    @endsection  
@stop
