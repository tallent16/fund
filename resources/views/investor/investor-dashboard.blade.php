@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
		<script>
		 var current_loansJson	=	{{$InvDashMod->featuredLoanJson}}		
		 var barchartJson		=	{{$InvDashMod->barChartJson}}		
		$(document).ready(function(){
			$('.fa-caret-right').on("click", function() {
				var curLoanLen	=	current_loansJson.length;
				var curLoanInd	=	$("#current_loan_index").val();
				if( curLoanLen > 0) {
					changeCurLoanInd	=	parseInt(curLoanInd)+1;
					if(	changeCurLoanInd >  parseInt(curLoanLen-1)) {
						changeCurLoanInd	=	0;
					}
					setCurrentLoanFunc(changeCurLoanInd);
					$("#current_loan_index").val(changeCurLoanInd);
				}
			});
			repaymentBarChartFunc();
		});
		
		function repaymentBarChartFunc(){
			var datasetsArry	=	[];
			var dataLabelArry	=	[];
			var datavalueArry	=	[];
			var colors = [];
		
			colors.push({
					fillColor : "rgba(245,75,75,0.5)",
					strokeColor : "rgba(245,75,75,0.8)",
					highlightFill : "rgba(245,75,75,0.75)",
					highlightStroke : "rgba(245,75,75,1)"
			});
			 if(barchartJson.length > 0){
				$.each( barchartJson, function( key ) {
				
					dataLabelArry.push(barchartJson[key].pay_period);
					datavalueArry.push(barchartJson[key].percentage_payment);
				});
				datasetsArry.push({
					  
						label: "",
						fillColor : colors[0].fillColor,
						strokeColor : colors[0].strokeColor,
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: colors[0].highlightFill,
						pointHighlightStroke: colors[0].highlightStroke,
						//~ data: datavalueArry
						data: datavalueArry
					});
				
			}
			var bdata = {
			  labels :dataLabelArry , 			  
			  width:10,
				datasets : datasetsArry
			}

			var options = {
					responsive:true
			}

			var cbar = document.getElementById("cbar").getContext("2d");
			var barChart = new Chart(cbar).Line(bdata, options);	
		}
		function setCurrentLoanFunc(currentIndex){
			var currentlist	=	current_loansJson[currentIndex];
			
			$("#cur_loan_subhead").html(currentlist.business_name);
			$("#cur_loan_content").html(currentlist.purpose);
			$("#cur_loan_rate").html(currentlist.rate+"%");
			$("#cur_loan_duration").html(currentlist.duration);
			$("#cur_loan_amount").html(currentlist.amount);
			$("#cur_loan_repayment_type").html(currentlist.repayment_type);
			$("#cur_loan_bid_type").html(currentlist.bid_type);
		}
		//~ function setwidth(){
			//~ Chart.types.Bar.extend({
				//~ name: "bar",
				//~ draw: function(){
					//~ this.options.barValueSpacing = this.chart.width / 8;
					//~ Chart.types.Bar.prototype.draw.apply(this, arguments);
					//~ }
				//~ });
		//~ }
	</script>
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
										<td  class="tab-left-head">
										{{Lang::get('Rate%')}}
										</td> 
										<td  id="cur_loan_rate" >
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
												{{$invFeatureLoans[0]->amount}}
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
							@section ('cchart4_panel_title',Lang::get('borrower-dashboard.bar_chart'))
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
												<th class="tab-head text-right">{{Lang::get('Verified')}}</th>
												<th class="tab-head text-right">{{Lang::get('Pending Approval')}}</th>										
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Investments')}}</td>
												<td class="text-right">
													{{$Investments_verified}}
												</td>
												<td class="text-right">
													{{$Investments_pending}}
												</td>										
											</tr>
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Deposits')}}</td>
												<td class="text-right">
													{{$deposits_verified}}
												</td>	
												<td class="text-right">
													{{$deposits_pending}}
												</td>	
																							
											</tr>	
											<tr> 
												<td class="text-left tab-left-head">{{Lang::get('Withdrawals')}}</td>
												<td class="text-right">
													{{$withdrawals_verified}}
												</td>	
												<td class="text-right">
													{{$withdrawals_pending}}
												</td>	
																				
											</tr>@var	$ava_for_invest_verified	=	$deposits_verified -(($Investments_verified+$withdrawals_verified))
							@var	$ava_for_invest_pending		=	$deposits_pending -(($Investments_pending+$withdrawals_pending))
							@var	$grand_total				=	$ava_for_invest_verified+$ava_for_invest_pending
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Available for investment')}}</td>
												<td class="text-right">{{$ava_for_invest_verified}}</td>
												<td class="text-right">{{$ava_for_invest_pending}}</td>										
											</tr>										
											<tr>
												<td class="text-left tab-left-head">{{Lang::get('Grand Total')}}</td>
												<td class="text-right">{{$grand_total}}</td>										
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
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT INVESTED')}}</th>
									<th class="tab-head">{{Lang::get('DATE OF INVESTMENT')}}</th>
									<th class="tab-head text-right">{{Lang::get('TENURE OF LOAN')}}</th>
									<th class="tab-head">{{Lang::get('TYPE OF LOAN')}}</th>
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
										<td class="text-right">{{$loanRow['loan_sanctioned_amount']}}</td>
										<td class="text-right">{{$loanRow['bid_amount']}}</td>
										<td>{{$loanRow['date_of_investment']}}%</td>
										<td class="text-right">{{$loanRow['loan_tenure']}}</td>
										<td>{{$loanRow['bid_type']}}</td>
										<td class="text-right">{{$loanRow['bid_interest_rate']}}</td>
										<td class="text-right">{{$loanRow['interest_paid']}}</td>
										<td class="text-right">{{$loanRow['principal_amount_paid']}}</td>
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
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT INVESTED')}}</th>
									<th class="tab-head">{{Lang::get('DATE OF INVESTMENT')}}</th>
									<th class="tab-head">{{Lang::get('BID CLOSE DATE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TENURE OF LOAN')}}</th>
									<th class="tab-head">{{Lang::get('TYPE OF LOAN')}}</th>	
									<th class="tab-head"></th>	
									<th class="tab-head"></th>									
								</tr>
							</thead>
							<tbody>
								@foreach($invUnderBidInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['borrower_risk_grade']}}</td>
										<td class="text-right">{{$loanRow['apply_amount']}}</td>
										<td class="text-right">{{$loanRow['bid_amount']}}</td>
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
					<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">{{Lang::get('BORROWER\'S NAME')}}</th>
									<th class="tab-head">{{Lang::get('GRADE')}}</th>
									<th class="tab-head text-right">{{Lang::get('TOTAL AMOUNT OF LOAN')}}</th>
									<th class="tab-head text-right">{{Lang::get('AMOUNT OVERDUE')}}</th>
									<th class="tab-head text-right">{{Lang::get('OVERDUE SINCE')}}</th>
									<th class="tab-head" colspan="5"></th>	
																																
								</tr>
							</thead>
							<tbody>
								@foreach($overDueInfo as $loanRow)
									<tr>
										<td>{{$loanRow['business_name']}}</td>
										<td>{{$loanRow['borrower_risk_grade']}}</td>
										<td class="text-right">{{$loanRow['accepted_amount']}}</td>
										<td class="text-right">{{$loanRow['payment_schedule_amount']}}</td>
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
