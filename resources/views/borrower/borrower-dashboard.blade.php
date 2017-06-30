@extends('layouts.dashboard')
@section('styles')
<style>
	.chart-legend li span{
		display: inline-block;
		width: 12px;
		height: 12px;
		margin-right: 5px;
	}
	.table-verticalscroll{
		height: 300px;
		overflow-y: auto;   
		display: block;
		overflow-x: hidden
	}
</style>
@endsection
@section('page_heading',Lang::get('borrower-dashboard.page_heading') )
@section('section')  
         @var $borrowerLoans 	= $BorDashMod->loan_details;
         @var $borCurLoans 		= $BorDashMod->curloans;
		<div class="col-sm-12 space-around"> 
			
			<!--second row--->
			<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-10 col-lg-10">
									<span class="pull-left">{{ Lang::get('Current Project') }} </span> 
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
								 		@if(isset($borCurLoans[0]))
											{{$borCurLoans[0]->business_name." ".$borCurLoans[0]->business_organisation}}
										@endif
								</div>
							   <div  id="cur_loan_content">
								   	@if(isset($borCurLoans[0]))
										{{$borCurLoans[0]->purpose}}
									@else
										No Loans Found
									@endif
								</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="tab-head col-sm-4">
											{{ Lang::get('Goal') }}
										</th>
										<th class="tab-head col-sm-4">
											{{ Lang::get('Duration Left') }}
										</th>
										<th class="tab-head col-sm-4">
											{{ Lang::get('Amount Raised') }}
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td  id="cur_loan_rate" >
											 @if(isset($borCurLoans[0]))
												{{$borCurLoans[0]->rate}} ETH
											 @else
											    -
											@endif
										</td> 
										<td  id="cur_loan_duration">
											@if(isset($borCurLoans[0]))
												{{$borCurLoans[0]->duration}}
											@else
											    -
											@endif
										</td>
										<td  id="cur_loan_amount">
											@if(isset($borCurLoans[0]))
												{{number_format($borCurLoans[0]->amount,2,'.',',')}} ETH
											 @else
											    -
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
						
						<div class="table-responsive">                         
							<table class="table table-bordered">
								<thead>
									<tr>
										<th class="tab-head-red">{{ Lang::get('Projects Created') }}</th>
										<th class="totalamount">{{ Lang::get('Amount Raised') }}</th>										
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
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container">
					<div class="panel-heading panel-headsection">
							{{ Lang::get('Upcoming Milestones')	}}	
						</div>
						
						<div class="table-responsive">                         
							<table class="table text-left">
								<tbody class="table-verticalscroll">
								@if(count($BorDashMod->milestones_rs) > 0)
									@foreach($BorDashMod->milestones_rs as $milestonesrow)	
									<tr>											
										<td style="width:60%">									
											{{$milestonesrow->milestone_name}}								
											
										</td>
										<td style="width:30%">
											{{"[".$milestonesrow->milestone_date."] "}} 
										</td>
										<td class="text-right" style="width:30%">								
											{{$milestonesrow->milestone_disbursed}}								
										</td>	
									</tr>
									@endforeach	
								@else
									<tr>
										<td>				
											{{"No Milestones Found"}}
										</td>
									</tr>
								@endif	
								</tbody>
							</table>
						</div>
						
					</div>
				</div>
				
			<!--second col end--->				
		</div>
		
		
		<!---third row---->
			
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
