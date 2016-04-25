@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>		
	$(document).ready(function(){ 
	// date picker
	$('.actual_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
		}); 
	}); 
	</script>
@endsection
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  

<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container disburse-loan">
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Enter the Borrower Repayment')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
			
			<div class="row"><!-- Row 1 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Loan Reference Number')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	type="text" 
							class="form-control"
							name="loan_reference_number"
							id="loan_ref_num" 											
							value="{{$adminBorRepayViewMod->loanRefNumber}}"							 
							disabled>	
				</div>	
			
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Scheduled Repayment Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="scdule_date" 
								type="text" 
								class="scdule_date form-control" 
								name="scdule_date"									
								value="{{$adminBorRepayViewMod->schedDate}}" 
								disabled />

						<label for="scdule_date" class="input-group-addon btn" disabled>
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>				
			</div> <!-- Row 1 -->
			
			<div class="row"><!-- Row 2 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Actual Repayment Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="actual_date" 
								type="text" 
								class="actual_date form-control" 
								name="actual_date"									
								value="{{$adminBorRepayViewMod->repaymentDate}}" />

						<label for="actual_date" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>				
							
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Amount Paid')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	type="text" 
							class="form-control text-right"
							name="amount_paid"
							id="amount_paid" 											
							value="{{$adminBorRepayViewMod->amountPaid}}"							 
							disabled>	
				</div>				
			</div> <!-- Row 2 -->
			
			<div class="row"><!-- Row 3 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Principal Amount') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">					
						<input 	id="principal_amount" 
								type="text" 
								class="principal_amount form-control text-right" 
								name="principal_amount"									
								value="{{$adminBorRepayViewMod->principalAmount}}"
								disabled />						
				</div>
							
							
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Interest Amount')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	type="text" 
							class="form-control text-right"
							name="interest_amount"
							id="interest_amount" 											
							value="{{$adminBorRepayViewMod->interestAmount}}"
							disabled >	
				</div>					
			</div> <!-- Row 3 -->
			
			<div class="row"><!-- Row 4 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Penalty Amount') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">					
						<input 	id="penalty_amount" 
								type="text" 
								class="penalty_amount form-control text-right" 
								name="penalty_amount"									
								value="{{$adminBorRepayViewMod->penaltyAmt}}" 
								disabled />						
				</div>
							
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Penalty Company\'s Share')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	type="text" 
							class="form-control text-right"
							name="penalty_companyshare"
							id="penalty_companyshare" 											
							value="{{$adminBorRepayViewMod->penaltyCompShare}}"							
							disabled >	
				</div>					
			</div> <!-- Row 4 -->
			
			<div class="row"><!-- Row 5 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Transcation Reference No') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-5">					
						<input 	id="trans_ref_no" 
								type="text" 
								class="trans_ref_no form-control" 
								name="trans_ref_no"									
								value="NF254" 
								disabled />						
				</div>
			</div> <!-- Row 5 -->
			
			<div class="row"><!-- Row 6-->	
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Remarks')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-5">
					<textarea rows="3" class="form-control">
					</textarea>	
				</div>	
			</div> <!-- Row 6 -->
			
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">	
						<button class="btn verification-button">
							{{ Lang::get('Save')}}
						</button>
						<button class="btn verification-button">
							{{ Lang::get('Approve')}}
						</button>
					</div>
				</div>
			</div>			
			
		</div>
		
	</div>				
</div>

@endsection  
@stop
