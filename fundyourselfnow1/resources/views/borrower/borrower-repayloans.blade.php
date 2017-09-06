@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading',Lang::get('Repay Loans')) 
@section('section')     
	<div class="col-sm-12 space-around"> 			
	
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection">
				<div class="row">
				   <div class="col-xs-12">
						{{ Lang::get('REPAY LOANS')}}
					</div>									
				</div>                           
			</div><!-------------end of---panel heading---------------------->	
					
			<div class="table-responsive">
				<table class="table table-striped text-left">
					<thead>
						<tr>
							<th class="tab-head text-right">{{ Lang::get('Installment No')}}</th>
							<th class="tab-head text-left">{{ Lang::get('Project Reference No')}}</th>
							<th class="tab-head text-left">{{ Lang::get('Scheduled date')}}</th>
							<th class="tab-head text-left">{{ Lang::get('Project Period')}}</th>
							<th class="tab-head text-right">{{ Lang::get('Scheduled Amount')}}</th>
<!--
							<th class="tab-head text-right">{{ Lang::get('Penalty')}}</th>							
-->
							<th class="tab-head"></th>								
						</tr>
					</thead>
					<tbody>
				
					@var $repayloanlist = $modelrepayloan->unpaidLoanList;
				
						@if (count($modelrepayloan->unpaidLoanList) > 0)
							
							@var $i=1
							<?php $prloan = "" ?>
						
							@foreach ($repayloanlist as $loanRow)
																		
								@if($loanRow->loan_id != $prloan)
									@var $button_enable = ""
									<?php $prloan = $loanRow->loan_id ?>
								@else
									@var $button_enable = "style=display:none;"
								@endif	
								
								<tr>
									<td class="text-right">{{$loanRow->installment_number}}</td>
									<td>{{$loanRow->ref}}</td>
									<td>{{$loanRow->schd_date}}</td>
									<td>{{$loanRow->inst_period}}</td>
									<td class="text-right">{{number_format($loanRow->schd_amount, 2, ".", ",")}}</td>
<!--
									<td class="text-right">{{number_format($loanRow->penalty, 2, ".", ",")}}</td>						
-->
<!--
									<td class="text-right">{{number_format($loanRow->penaltyCompShare, 2, ".", ",")}}</td>						
-->
									<td>
										<a href="{{ url ('borrower/makepayment/'.base64_encode($loanRow->repayment_schedule_id).'/'.base64_encode($loanRow->loan_id)) }}">																				
										<button type="submit" id="{{$loanRow->repayment_schedule_id}}" class="button-orange" {{$button_enable}}>{{ Lang::get('REPAY')}}</button>
										<input type="hidden" id="{{$loanRow->installment_number}}" class="button-orange">
										
										</a>	
									</td>								
								</tr>	
							@endforeach	
						@else
							
							<tr>
								<td colspan="7" class="text-center">
									No Data Found
								</td>
							</tr>
						@endif
								
					</tbody>
				</table>						
			</div><!-----table responsive--->	
		</div><!-----panel--->                      
   
</div><!-----col--12--->
	@endsection  
@stop
