@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>	
		var baseUrl	=	"{{url('')}}"	
		$(document).ready(function(){ 
			 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('#hidden_token').val()
				}
			});
		// date picker
			$('.actual_date').datetimepicker({
				autoclose: true, 
				minView: 2,
				format: 'dd-mm-yyyy' 
			}); 
			$("#save_button").on("click",function(){
				$("#isSaveButton").val("yes");
			});
			$("#submit_button").on("click",function(){
				$("#isSaveButton").val("");
			});
			$("#save_form_payment").on("submit",function(e){
				$('span.error').remove();
				$('.has-error').removeClass("has-error");
				var $parentTag = $("#trans_ref_parent");
				$('[disabled]').removeAttr('disabled');
				if($("#isSaveButton").val()	!=	"yes") {
					if($("#trans_ref").val()	==	"") {
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						e.preventDefault();
					}
				}
			});
			$("#actual_date").on('change',function(){
				var	schRepDate		=	$("#scdule_date").val();
				var	actRepDate		=	$(this).val();
				var	principalAmt	=	$("#principal_amount").val();
				var	interestAmt		=	$("#interest_amount").val();
				$.ajax({
					type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url         : baseUrl+'/admin/ajax/recalculatePenality', // the url where we want to POST
					data        : {	schRepDate:schRepDate,
									actRepDate:actRepDate,
									principalAmt:principalAmt,
									interestAmt:interestAmt,
									},
					dataType    : 'json'
				}) // using the done promise callback
				.done(function(data) {
					resetPenalityFunc(data);
				});
			});
		}); 
		function resetPenalityFunc(data) {
			$("#amount_Paid").val(data.amountPaid);
			$("#penalty_amount").val(data.penaltyAmt);
			$("#penalty_companyshare").val(data.penaltyCompShare);
		}
	</script>
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
		
		<fieldset {{$fieldSetAttr}}>
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
									readonly />

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
									<button class="btn verification-button"
											id="save_button">
										{{ Lang::get('Save')}}
									</button>
									@if( $adminBorRepayViewMod->repaymentStatus	==	BORROWER_REPAYMENT_STATUS_UNVERIFIED )
										<button class="btn verification-button"
												id="submit_button">
											{{ Lang::get('Approve')}}
										</button>
									@endif
								</div>
							</div>
						</div>			
					@endif
				@endif
			</form>
		</div>
		</fieldset>
	</div>				
</div>

@endsection  
@stop
