@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('section')  
           
		<div class="col-sm-12"> 
			<!--First row--->
			<div class="row annoucement-msg-container">
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
								<div class="col-xs-9">
									<span class="pull-left">{{ Lang::get('borrower-dashboard.current_loan') }} </span> 
								</div>
								<div class="col-xs-3 text-right">
									<i class="fa fa-caret-right "></i>
								</div>								
							</div>							
						</div>	<!--end panel head-->
						
						<div class="panel-body"><!--panel body-->
							   <div class="panel-subhead">{{ Lang::get('borrower-dashboard.companyname') }}</div>
							   <div>{{ Lang::get('borrower-dashboard.content') }}</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table table-bordered .tab-fontsizebig">
								<thead>
									<tr>
										<th class="tab-head">{{ Lang::get('borrower-dashboard.rate') }}</th>
										<th class="tab-head">{{ Lang::get('borrower-dashboard.duration') }}</th>
										<th class="tab-head">{{ Lang::get('borrower-dashboard.amount') }}</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>10%</td> 
										<td>1 {{ Lang::get('borrower-dashboard.year') }}</td>
										<td>$1,000</td>
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
							<table class="table table-bordered .tab-fontsizebig">
								<thead>
									<tr>
										<th class="loantaken">{{ Lang::get('borrower-dashboard.loan_taken') }}</th>
										<th class="totalamount">{{ Lang::get('borrower-dashboard.total_amount') }}</th>										
									</tr>
								</thead>
								<tbody>
									<tr>
										<td class="text-center">2</td>
										<td class="text-center">$100,000</td>										
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
									<th class="tab-head">{{ Lang::get('borrower-dashboard.amount_paid') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.interest_rate') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.installments') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.repayment_amount') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.principal_amount') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-dashboard.lastest_status') }}</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1018</td>
									<td>26 {{ Lang::get('borrower-dashboard.nov') }} 2016</td>
									<td>11 {{ Lang::get('borrower-dashboard.nov') }} 2016</td>
									<td>$100,000</td>
									<td>18%</td>
									<td>11</td>
									<td>$91.68</td>
									<td></td>
									<td>{{ Lang::get('borrower-dashboard.paid') }}</td>
								</tr>										
							</tbody>
						</table>						
					</div><!-----third row end--->	
                </div>              
          @endsection  
@stop
