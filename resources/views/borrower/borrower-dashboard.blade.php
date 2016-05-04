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
										<th class="tab-head col-sm-4">
											{{ Lang::get('borrower-dashboard.rate') }}
										</th>
										<th class="tab-head col-sm-4">
											{{ Lang::get('borrower-dashboard.duration') }}
										</th>
										<th class="tab-head col-sm-4">
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
												{{number_format($borCurLoans[0]->amount,2,'.',',')}}
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
											{{number_format($totalLoanAmount,2,'.',',')}}
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
										<td class="text-right">{{number_format($loanRow['amount_paid'],2,'.',',')}}</td>
										<td class="text-right">{{$loanRow['inst_rate']}}%</td>
										<td class="text-right">{{$loanRow['no_of_installment']}}</td>
										<td class="text-right">{{number_format($loanRow['total_repayments'],2,'.',',')}}</td>
										<td class="text-right">{{number_format($loanRow['tot_prin_outstanding'],2,'.',',')}}</td>
										<td>{{$loanRow['repayment_status']}}</td>
									</tr>				
								@endforeach						
							</tbody>
						</table>						
					</div><!-----third row end--->	
                </div>              
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
			</script>
			<script src="{{ url("js/borrower-dashboard.js") }}" type="text/javascript"></script>
	@endsection
@stop
