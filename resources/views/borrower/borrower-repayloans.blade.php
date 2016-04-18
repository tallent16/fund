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
				<table class="table tab-fontsize table-striped">
					<thead>
						<tr>
							<th class="tab-head">{{ Lang::get('INSTALLMENT NUMBER')}}</th>
							<th class="tab-head">{{ Lang::get('LOAN REFERENCE NUMBER')}}</th>
							<th class="tab-head">{{ Lang::get('SCHDELUED DATE')}}</th>
							<th class="tab-head">{{ Lang::get('LOAN PERIOD')}}</th>
							<th class="tab-head text-right">{{ Lang::get('SCHDELUED AMOUNT')}}</th>
							<th class="tab-head text-right">{{ Lang::get('PENALTY')}}</th>							
							<th class="tab-head"></th>								
						</tr>
					</thead>
					<tbody>
				
					@var $repayloanlist = $modelrepayloan->unpaidLoanList;
				
						@if (count($modelrepayloan->unpaidLoanList) > 0)
							
							@var $i=1
						
							@foreach ($repayloanlist as $loanRow)
																		
								@if($loanRow->repayment_status == 1)
								
									@if($i == 1)
										@if($loanRow->repayment_status == $i)
										@var $button_enable = ""
										@endif
									@else
										@var $button_enable = "style=display:none;"
									@endif	
									
									
								@else
									@var $button_enable = "style=display:none;"
								@endif
								
								@var $i++
								<tr>
									<td>{{$loanRow->installment_number}}</td>
									<td>{{$loanRow->ref}}</td>
									<td>{{$loanRow->schd_date}}</td>
									<td>{{$loanRow->inst_period}}</td>
									<td class="text-right">{{round($loanRow->schd_amount,2)}}</td>
									<td class="text-right">{{round($loanRow->penalty,2)}}</td>							
									<td>
										<a href="{{ url ('borrower/makepayment/'.base64_encode($loanRow->repayment_schedule_id).'/'.base64_encode($loanRow->loan_id)) }}">																				
										<button type="submit" id="{{$loanRow->repayment_schedule_id}}" class="button-orange" {{$button_enable}}>{{ Lang::get('REPAY')}}</button>
										<input type="hidden" id="{{$loanRow->installment_number}}" class="button-orange">
										
										</a>	
									</td>								
								</tr>	
							@endforeach	
						
						@endif
								
					</tbody>
				</table>						
			</div><!-----table responsive--->	
		</div><!-----panel--->                      
   
</div><!-----col--12--->
	@endsection  
@stop
