@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>	
		@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
			var baseUrl	=	"{{url('')}}/admin"
		@else	
			var baseUrl	=	"{{url('')}}/borrower"	
		@endif
	</script>
	<script src="{{ url('js/admin-borrower-repaymentview.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  
@if( ($adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_PAID)
		||	$type	==	"view")
	@var	$fieldSetAttr	=	"disabled"
@else
	@var	$fieldSetAttr	=	""
@endif
@if($submitted)
	<div class="col-sm-12 space-around">
		<div class="annoucement-msg-container">
			<div class="alert alert-success">
				{{Lang::get('Borrower Repayment Schedule Successfully updated')}}
		</div>				
	</div>
@endif


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
			<form method="post" id="save_form_payment">
				<input  type="hidden" 
						name="_token"
						id="hidden_token"
						value="{{ csrf_token() }}" />
				<input  type="hidden" 
						name="loan_id"
						value="{{$adminBorRepayViewMod->loanId}}" />	
				<input  type="hidden" 
						name="borrower_id" 
						value="{{$adminBorRepayViewMod->borrowerId}}"/>	
				<input  type="hidden" 
						name="repaymentSchdId" 	
						value="{{$adminBorRepayViewMod->repaymentSchdId}}"	/>	
				<input  type="hidden" 
						name="installment_number" 
						value="{{$adminBorRepayViewMod->installmentNumber}}"/>
				<input  type="hidden" 
						name="payment_id" 
						value="{{$adminBorRepayViewMod->paymentId}}"/>
				<input  type="hidden" 
						name="isSaveButton" 
						id="isSaveButton" 
						value=""/>
				<input type="hidden" value="" id="submitType" name="submitType">
				<fieldset {{$fieldSetAttr}}>
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<div class="row"><!-- Row 0 Only For Admin Screen-->					
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>
								{{ Lang::get('Borrower Name')}}
							</label>
						</div>								
						<div class="col-xs-12 col-sm-7 col-lg-3">
							<input 	type="text" 
									class="form-control"
									name="borrower_name"
									id="borrower_name" 											
									value="{{$adminBorRepayViewMod->borrower_name}}"							 
									disabled>	
						</div>	
								
					</div> <!-- Row 0 -->
				@endif
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
									name="duedate"									
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
									value="{{$adminBorRepayViewMod->repaymentDate}}" 
									/>

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
								name="amount_Paid"
								id="amount_Paid" 											
								value="{{number_format($adminBorRepayViewMod->amountPaid, 2, '.', ',')}}"	
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
									value="{{number_format($adminBorRepayViewMod->principalAmount, 2, '.', ',')}}"
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
								value="{{number_format($adminBorRepayViewMod->interestAmount, 2, '.', ',')}}"
								disabled >	
					</div>					
				</div> <!-- Row 3 -->
				
				<div class="row"><!-- Row 4 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Overdue Penalty Charges') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">					
							<input 	id="penalty_amount" 
									type="text" 
									class="penalty_amount form-control text-right" 
									name="penalty_amount"									
									value="{{number_format($adminBorRepayViewMod->penaltyAmt,2,'.',',')}}" 
									disabled />						
					</div>
								
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Penalty Handling Charges')}}
						</label>
					</div>								
					<div class="col-xs-12 col-sm-7 col-lg-3">
						<input 	type="text" 
								class="form-control text-right"
								name="penalty_companyshare"
								id="penalty_companyshare" 											
								value="{{number_format($adminBorRepayViewMod->penaltyCompShare, 2, '.',',')}}"	
								disabled >	
					</div>					
				</div> <!-- Row 4 -->
				
				<div class="row"><!-- Row 5 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
							{{ Lang::get('Transcation Reference No') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-5" id="trans_ref_parent">					
							<input 	id="trans_ref" 
									type="text" 
									class="trans_ref_no form-control" 
									name="trans_ref"									
									value="{{$adminBorRepayViewMod->transreference_no}}" 
									 />						
					</div>
				</div> <!-- Row 5 -->
				
				<div class="row"><!-- Row 6-->	
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Remarks')}}
						</label>
					</div>								
					<div class="col-xs-12 col-sm-7 col-lg-5">
						<textarea 	rows="3" 
									class="form-control" 
									name="repay_remarks">{{$adminBorRepayViewMod->remarks}}</textarea>	
					</div>	
				</div> <!-- Row 6 -->
				@if($type	!=	"view")
					@if( ($adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_UNPAID)
						|| ($adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_UNVERIFIED) )
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">	
									@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
										<button class="btn verification-button"
												id="save_button">
												{{ Lang::get('Save')}}
										</button>
									@endif
									@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
										@if( $adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_UNVERIFIED )
											@permission('approve.admin.borrowerrepayment')	
												<button class="btn verification-button"
														id="submit_button">
													{{ Lang::get('Approve')}}
												</button>
											@endpermission
										@endif
									@endif
								</div>
							</div>
						</div>			
					@endif
					</fieldset>
					@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)	
						@if( $adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_PAID )
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										@permission('unapprove.admin.borrowerrepayment')
											<button class="btn verification-button"
													id="unapprove_button">
													{{ Lang::get('UnApprove')}}
											</button>
										@endpermission
									</div>
								</div>
							</div>			
						@endif
					@endif
				@endif
			</form>
		</div>
		
	</div>				
</div>

@endsection  
@stop
