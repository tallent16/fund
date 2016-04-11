@extends('layouts.dashboard')
@section('styles')
<style>
	.chart-legend li span{
		display: inline-block;
		width: 12px;
		height: 12px;
		margin-right: 5px;
	}
</style>
@endsection
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var months = {
		 '01':'Jan',
		 '02':'Feb',
		 '03':'Mar',
		 '04':'Apr',
		 '05':'May',
		 '06':'Jun',
		 '07':'Jul',
		 '08':'Aug',
		 '09':'Sep',
		 '10':'Oct',
		 '11':'Nov',
		 '12':'Dec',
		}
	 var current_loansJson	=	{{$BorDashMod->current_loansJson}}		
	 var barchartJson		=	{{$BorDashMod->barchart_detJson}}		
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
			setwidth();
			
		});
		
		function repaymentBarChartFunc(){
			var datasetsArry	=	[];
			var colors = [];
			
			colors.push({
					fillColor: "rgba(151,187,205,0.5)",
					strokeColor: "rgba(151,187,205,0.8)",
					highlightFill: "rgba(151,187,205,0.75)",
					highlightStroke: "rgba(151,187,205,1)",
			});
			colors.push({
					fillColor : "rgba(95,137,250,0.5)",
					strokeColor : "rgba(95,137,250,0.9)",
					highlightFill: "rgba(95,137,250,0.75)",
					highlightStroke: "rgba(95,137,250,1)"
			});
			colors.push({
					fillColor : "rgba(245,75,75,0.5)",
					strokeColor : "rgba(245,75,75,0.8)",
					highlightFill : "rgba(245,75,75,0.75)",
					highlightStroke : "rgba(245,75,75,1)"
			});
			colors.push({
					fillColor : "rgba(98,223,114,0.5)",
					strokeColor : "rgba(98,223,114,0.8)",
					highlightFill : "rgba(98,223,114,0.75)",
					highlightStroke : "rgba(98,223,114,1)",
			});
			var dataLabel		=	"";
			var dataLabelNew	=	[];
			 if(barchartJson.length > 0){
				dataLabel	=	 (barchartJson[0].barChartLabel).split(',');
				$.each( dataLabel, function( key ) {
					var	monYear	=	(dataLabel[key]).split(' ');
					dataLabelNew.push(months[monYear[1]]+" "+monYear[0]);
				});
				var barcount = 0;
				$.each( barchartJson, function( key ) {
					colorIndex	=	key;
					if(key > 3)
						colorIndex	=	0;
					var dataArry	=	[];
					datasetsArry.push({
						   label:barchartJson[key].loan_ref ,
							fillColor : colors[colorIndex].fillColor,
							strokeColor : colors[colorIndex].strokeColor,
							highlightFill: colors[colorIndex].highlightFill,
							highlightStroke: colors[colorIndex].highlightStroke,
							data : (barchartJson[key].barChartValue).split(',')
						});
					
					loansCount = ((barchartJson[key].barChartValue).split(',')).length
					
					barCount = dataLabel.length * loansCount;
				});
			
				var bdata = {
				  //~ labels : dataLabel, 			  
				  labels : dataLabelNew, 			  
					datasets : datasetsArry
				}

				var options = {
						responsive:true,
				}

				Chart.types.Bar.extend({
					name: "BarWidth",
					draw: function(){
						this.options.barValueSpacing = this.chart.width / barCount;
						Chart.types.Bar.prototype.draw.apply(this, arguments);
					}
				});

				var cbar = document.getElementById("cbar").getContext("2d");
				var barChart = new Chart(cbar).BarWidth(bdata, options);	
				var legend = barChart.generateLegend();

				$('#cbarlegend').append(legend);
			}
		}
		function setCurrentLoanFunc(currentIndex){
			var currentlist	=	current_loansJson[currentIndex];
			
			$("#cur_loan_subhead").html(currentlist.business_name+" "+currentlist.business_organisation);
			$("#cur_loan_content").html(currentlist.purpose);
			$("#cur_loan_rate").html(currentlist.rate+"%");
			$("#cur_loan_duration").html(currentlist.duration);
			$("#cur_loan_amount").html(currentlist.amount);
		}
		function setwidth(){
			Chart.types.Bar.extend({
				name: "bar",
				draw: function(){
					this.options.barValueSpacing = this.chart.width / 8;
					Chart.types.Bar.prototype.draw.apply(this, arguments);
					}
				});
		}
	</script>
@endsection
@section('page_heading',Lang::get('borrower-dashboard.page_heading') )
@section('section')  
         @var $borrowerLoans 	= $BorDashMod->loan_details;
         @var $borCurLoans 		= $BorDashMod->curloans;
		<div class="col-sm-12 space-around"> 
			<!--First row--->
			<div class="row annoucement-msg-container" style="display:none">
				<div class="alert alert-danger annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Lang::get('borrower-dashboard.annocement_section') }} 
				</div>
			</div>
			<!--first row end-->
			
			<!--second row--->
			<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-10 col-lg-11">
									<span class="pull-left">{{ Lang::get('borrower-dashboard.current_loan') }} </span> 
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
								 		@if(isset($borCurLoans[0]))
											{{$borCurLoans[0]->business_name." ".$borCurLoans[0]->business_organisation}}
										@endif
								</div>
							   <div  id="cur_loan_content">
								   	@if(isset($borCurLoans[0]))
										{{$borCurLoans[0]->purpose}}
									@endif
								</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="tab-head">
											{{ Lang::get('borrower-dashboard.rate') }}
										</th>
										<th class="tab-head">
											{{ Lang::get('borrower-dashboard.duration') }}
										</th>
										<th class="tab-head">
											{{ Lang::get('borrower-dashboard.amount') }}
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td  id="cur_loan_rate" >
											 @if(isset($borCurLoans[0]))
												{{$borCurLoans[0]->rate}}%
											@endif
										</td> 
										<td  id="cur_loan_duration">
											@if(isset($borCurLoans[0]))
												{{$borCurLoans[0]->duration}}
											@endif
										</td>
										<td  id="cur_loan_amount">
											@if(isset($borCurLoans[0]))
												{{$borCurLoans[0]->amount}}
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
						<div class="table-responsive">                         
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="tab-head-red">{{ Lang::get('borrower-dashboard.loan_taken') }}</th>
										<th class="totalamount">{{ Lang::get('borrower-dashboard.total_amount') }}</th>										
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center">{{count($borCurLoans)}}</td>
										<td class="text-center">
											@var $totalLoanAmount	=	0
											@foreach($borCurLoans as $curLoan)
												@var $totalLoanAmount = $totalLoanAmount	+	$curLoan->amount
											@endforeach
											{{$totalLoanAmount}}
										</td>										
									</tr>										
								</tbody>
							</table>                     
						</div>				
					</div>
				</div>			
			<!--second col end--->				
		</div>
		<!---third row---->
		<div class="row">
			 <div class="col-lg-12 col-md-12">
				 <div class="panel panel-primary panel-container">
					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-3">
								<span class="pull-left">{{ Lang::get('borrower-dashboard.loan_overview') }}</span> 
							</div>									
						</div>                           
					</div>				
					<div class="table-responsive">
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.loan_refer') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.last_payment') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.next_payment') }}</th>
									<th class="tab-head text-right">{{ Lang::get('borrower-dashboard.amount_paid') }}</th>
									<th class="tab-head text-right">{{ Lang::get('borrower-dashboard.interest_rate') }}</th>
									<th class="tab-head text-right">{{ Lang::get('borrower-dashboard.installments') }}</th>
									<th class="tab-head text-right">{{ Lang::get('borrower-dashboard.repayment_amount') }}</th>
									<th class="tab-head text-right">{{ Lang::get('borrower-dashboard.principal_amount') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.lastest_status') }}</th>
								</tr>
							</thead>
							<tbody>
								@foreach($borrowerLoans as $loanRow)
									<tr>
										<td>{{$loanRow['loan_reference_number']}}</td>
										<td>{{$loanRow['last_payment']}}</td>
										<td>{{$loanRow['next_payment']}}</td>
										<td class="text-right">{{$loanRow['amount_paid']}}</td>
										<td class="text-right">{{$loanRow['inst_rate']}}%</td>
										<td class="text-right">{{$loanRow['no_of_installment']}}</td>
										<td class="text-right">{{$loanRow['total_repayments']}}</td>
										<td class="text-right">{{$loanRow['tot_prin_outstanding']}}</td>
										<td>{{$loanRow['repayment_status']}}</td>
									</tr>				
								@endforeach						
							</tbody>
						</table>						
					</div><!-----third row end--->	
                </div>              
          @endsection  
@stop
