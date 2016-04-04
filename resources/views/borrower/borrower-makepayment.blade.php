@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/borrower-makepayment.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Make Payment'))
@section('section')     
	<div class="col-sm-12 space-around"> 	
		
	@if($submitted)
	<div class="row">
		<div class="col-sm-12">
			<div class="annoucement-msg-container" id="success-alert">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{Lang::get('Payment Added Successfully')}}
				</div>
			</div>
		</div>
	</div>
	@endif
		
	@var $repayloanpayment = $modelrepayloanpayment;
			
		<form method="post" id="save_form_payment">
			<input  type="hidden" name="_token" 		 	value="{{ csrf_token() }}">
			<input  type="hidden" name="loan_id" 		 	value="{{$modelrepayloanpayment->loanId}}"			 	class="form-control">	
			<input  type="hidden" name="borrower_id" 	 	value="{{$modelrepayloanpayment->borrowerId}}" 	 		class="form-control">	
			<input  type="hidden" name="repaymentSchdId" 	value="{{$modelrepayloanpayment->repaymentSchdId}}"		class="form-control">	
			<input  type="hidden" name="installment_number" value="{{$modelrepayloanpayment->installmentNumber}}" 	class="form-control">	
				
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection">
				<div class="row">
				   <div class="col-xs-12">
						{{Lang::get('Payment Details')}}
					</div>									
				</div>                           
			</div><!-------------end of---panel heading---------------------->	
		
			<div class="panel-body apply-loan">
				<div class="row">
					
					<div class="col-sm-12 col-lg-6 input-space">
												
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Loan Number') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input 	type="text" 
										name="loan_num" 
										value="{{$modelrepayloanpayment->loanRefNumber}}" 
										class="form-control" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Principal Amount') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input type="text" 
										name="principal_amount" 
										value="{{$modelrepayloanpayment->principalAmount}}" 
										class="form-control text-right" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Interest Amount') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input 	type="text" 
										name="interest_amount" 
										value="{{$modelrepayloanpayment->interestAmount}}"
										class="form-control text-right" disabled>	
							</div>
						</div>
												
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Penalty Amount') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input  type="text" 
										name="penalty_amount" 
										value="{{$modelrepayloanpayment->penaltyAmt}}" 
										class="form-control text-right" disabled>
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Total Due') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input  type="text" 
										name="amount_Paid" 
										id="amount_Paid"
										value="{{$modelrepayloanpayment->amountPaid}}" 
										class="form-control text-right" disabled>
							</div>
						</div>						
						
					</div>
					
					<div class="col-sm-12 col-lg-6 input-space">
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Sched Payment Date') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">	
								<div class="controls">
									<div class="input-group">												
										<input 	type="text" 
												id="schduledate" 
												name="duedate"
												value="{{date('d-m-Y', strtotime($modelrepayloanpayment->schedDate))}}"
												class="form-control"
												readonly disabled/>	
									</div>
								</div>
							</div>
						</div>
												
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Actual Payment Date') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">	
								<div class="controls">
									<div class="input-group">												
											<input 	type="text" 
													id="actualdate" 
													name="actualdate"
													value="{{date('d-m-Y', strtotime($modelrepayloanpayment->repaymentDate))}}"
													class="form-control"
													readonly disabled/>											
									</div>
								</div>
							</div>
						</div>
						
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Transcation Ref') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<input type="text" 
										name="trans_ref" 
										value="" 
										class="form-control text-right">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Remarks') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
								<textarea rows="4" 
											name="repay_remarks" 
											id="remarks" 
											class="form-control">
											</textarea>
							</div>
						</div>
						
					</div>
					
				</div><!----row----->
			</div><!---panel body-->			
		</div><!-----panel--->      
		
		<div class="col-sm-12">
			<div class="pull-right">
				<button type="submit" 
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Submit for Approval')}}
				</button>
			</div>
		</div>		
		</form>	   
	          
</div><!-----col--12--->

	@endsection  
@stop
