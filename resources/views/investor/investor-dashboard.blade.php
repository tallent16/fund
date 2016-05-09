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
		@var	$invFeatureLoans		=	$InvDashMod->featuredLoanInfo;
		<div class="col-sm-12 space-around"> 
			<!--First row--->
			<div class="row annoucement-msg-container">
				<div class="alert alert-danger annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>	
					{{ Lang::get('Announcement section')}}		
				</div>
			</div>
			<!--first row end-->
			
			<!--second row--->
			<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container table-border-custom">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-10 col-lg-11">
									<span class="pull-left">
										@if( $InvDashMod->isFeaturedLoanInfo	==	"yes" )
											{{Lang::get('FEATURED LOANS')}}
										@else
											{{Lang::get('AVAILABLE LOANS')}}
										@endif
									</span> 
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
										<td  class="tab-left-head col-sm-6">
										{{Lang::get('Rate%')}}
										</td> 
										<td  id="cur_loan_rate" class="col-sm-6">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->rate}}%
											@endif
										</td>										
									</tr>	
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Tenure')}}
										</td> 
										<td  id="cur_loan_duration">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->duration}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Amount')}}
										</td> 
										<td  id="cur_loan_amount">
											 @if(isset($invFeatureLoans[0]))
												{{number_format($invFeatureLoans[0]->amount,2,'.',',')}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Type of Repayment')}}
										</td> 
										<td  id="cur_loan_repayment_type">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->repayment_type}}
											@endif
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head">
											{{Lang::get('Bid Type')}}
										</td> 
										<td  id="cur_loan_bid_type">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->bid_type}}
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
					<div class="panel panel-default">
						<div class="panel-body">
							@section ('cchart4_panel_title',Lang::get('Return on Investment(%)'))
							@section ('cchart4_panel_body')
							@include('widgets.charts.cbarchart')
							@endsection
							@include('widgets.panel', array('header'=>true, 'as'=>'cchart4'))
						</div>								
					</div>	
							@var	$deposits_verified			=	!empty($deposits_verified)?$deposits_verified:0.00
							@var	$deposits_pending			=	!empty($deposits_pending)?$deposits_pending:0.00
							@var	$Investments_verified		=	!empty($Investments_verified)?$Investments_verified:0.00
							@var	$Investments_pending		=	!empty($Investments_pending)?$Investments_pending:0.00
							@var	$withdrawals_verified		=	!empty($withdrawals_verified)?$withdrawals_verified:0.00
							@var	$withdrawals_pending		=	!empty($withdrawals_pending)?$withdrawals_pending:0.00
							@var	$ava_for_invest_verified	=	$deposits_verified -(($Investments_verified+$withdrawals_verified))
							@var	$ava_for_invest_pending		=	$deposits_pending -(($Investments_pending+$withdrawals_pending))
							@var	$grand_total				=	$ava_for_invest_verified+$ava_for_invest_pending
							<div class="table-responsive">                         
									<table class="table" id="account-summary">
										<thead>
											<tr>
												<th class="tab-head text-left">{{Lang::get('ACCOUNT SUMMARY')}}</th>
												<th class="tab-head text-right">{{Lang::get('VERIFIED')}}</th>
												<th class="tab-head text-right">{{Lang::get('PENDING APPROVAL')}}</th>										
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Investments')}}</td>
												<td class="text-right">
													{{number_format($Investments_verified,2,'.',',')}}
												</td>
												<td class="text-right">
													{{number_format($Investments_pending,2,'.',',')}}
												</td>										
											</tr>
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Deposits')}}</td>
												<td class="text-right">
													{{number_format($deposits_verified,2,'.',',')}}
												</td>	
												<td class="text-right">
													{{number_format($deposits_pending,2,'.',',')}}
												</td>	
																							
											</tr>	
											<tr> 
												<td class="text-left tab-left-head">{{Lang::get('Withdrawals')}}</td>
												<td class="text-right">
													{{number_format($withdrawals_verified,2,'.',',')}}
												</td>	
												<td class="text-right">
													{{number_format($withdrawals_pending,2,'.',',')}}
												</td>	
																				
											</tr>@var	$ava_for_invest_verified	=	$deposits_verified -(($Investments_verified+$withdrawals_verified))
							@var	$ava_for_invest_pending		=	$deposits_pending -(($Investments_pending+$withdrawals_pending))
							@var	$grand_total				=	$ava_for_invest_verified+$ava_for_invest_pending
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Available for investment')}}</td>
												<td class="text-right">{{number_format($ava_for_invest_verified,2,'.',',')}}</td>
												<td class="text-right">{{number_format($ava_for_invest_pending,2,'.',',')}}</td>										
											</tr>										
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Grand Total')}}</td>
												<td class="text-right">{{number_format($grand_total,2,'.',',')}}</td>										
												<td class="text-right"></td>										
											</tr>										
										</tbody>
									</table>                     
								</div>
					
					
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
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">{{Lang::get('FUNDS DEPLOYED')}}
          <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
        
						 <div class="panel panel-primary panel-container">
								
					<div class="table-responsive">
						<table class="table tab-fontsize text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head text-left">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT INVESTED')}}</th>
									<th class="tab-head text-left">{{Lang::get('DATE OF INVESTMENT')}}</th>
									<th class="tab-head text-right">{{Lang::get('TENURE OF LOAN')}}</th>
									<th class="tab-head text-left">{{Lang::get('TYPE OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('RATE OF INTEREST')}}</th>
									<th class="tab-head text-right">{{Lang::get('INTEREST PAID')}}</th>
									<th class="tab-head text-right">{{Lang::get('PRINCIPAL PAID')}}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($fundsDepolyedInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['borrower_risk_grade']}}</td>
										<td class="text-right">{{number_format($loanRow['loan_sanctioned_amount'],2,'.',',')}}</td>
										<td class="text-right">{{number_format($loanRow['bid_amount'],2,'.',',')}}</td>
										<td>{{$loanRow['date_of_investment']}}%</td>
										<td class="text-right">{{$loanRow['loan_tenure']}}</td>
										<td>{{$loanRow['bid_type']}}</td>
										<td class="text-right">{{$loanRow['bid_interest_rate']}}</td>
										<td class="text-right">{{number_format($loanRow['interest_paid'],2,'.',',')}}</td>
										<td class="text-right">{{number_format($loanRow['principal_amount_paid'],2,'.',',')}}</td>
									</tr>				
								@endforeach	
												
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
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">{{Lang::get('INVESTMENTS UNDER BID')}}
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        
         <div class="panel panel-primary panel-container">
							
					<div class="table-responsive">
						<table class="table tab-fontsize text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head text-left">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT INVESTED')}}</th>
									<th class="tab-head text-left">{{Lang::get('DATE OF INVESTMENT')}}</th>
									<th class="tab-head text-left">{{Lang::get('BID CLOSE DATE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TENURE OF LOAN')}}</th>
									<th class="tab-head text-left">{{Lang::get('TYPE OF LOAN')}}</th>	
									<th class="tab-head text-left"></th>	
									<th class="tab-head text-left"></th>									
								</tr>
							</thead>
							<tbody>
								@foreach($invUnderBidInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['borrower_risk_grade']}}</td>
										<td class="text-right">{{number_format($loanRow['apply_amount'],2,'.',',')}}</td>
										<td class="text-right">{{number_format($loanRow['bid_amount'],2,'.',',')}}</td>
										<td>{{$loanRow['date_of_investment']}}%</td>
										<td>{{$loanRow['bid_close_date']}}</td>
										<td class="text-right">{{$loanRow['loan_tenure']}}</td>
										<td>{{$loanRow['bid_type']}}</td>
										<td></td>
										<td></td>
									</tr>				
								@endforeach	
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
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">{{Lang::get('OVERDUE LOANS')}}
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
        
				 <div class="panel panel-primary panel-container">
					<div class="table-responsive"><!---table start-->	
					<table class="table tab-fontsize text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head text-left">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT OVERDUE')}}</th>
									<th class="tab-head text-right">{{Lang::get('OVERDUE SINCE')}}</th>
									<th class="tab-head" colspan="5"></th>																																	
								</tr>
							</thead>
							<tbody>
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
							</tbody>
						</table>		
						</div>									
				</div><!-----third row end--->	
                </div>              
        
        </div>
      </div>
    </div>
  </div> 

    @endsection  
@stop
