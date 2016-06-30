<div id="loan_detail_main" class="tab-pane fade in active">  	
	<div class="panel panel-default loan_details"> 						
		<div class="panel-body">
			<div class="row"><!-- Row 1 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Loan Reference No')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	type="text" 
							class="form-control"
							name="loan_reference_number"
							id="loan_ref_num" 											
							value="{{$bidsModel->loan_reference_number}}" 
							disabled>	
				</div>	

				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Sanctioned Amount') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control text-right"
							name="loan_sanctioned_amount"
							id="loan_sanctioned_amount"
							value=
							"{{number_format($bidsModel->loan_sanctioned_amount, 2, '.', ',')}}"
							disabled>	
				</div>
					
			</div> <!-- Row 1 -->
			
			
			<div class="row"><!-- Row 2 -->	
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Fixed Fees') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control text-right"
							name="loan_fixed_fees"											
							id="loan_fixed_fees" 											
							value="{{number_format($bidsModel->loan_fixed_fees, 2, '.', ',')}}" 
							disabled>	
				</div>
							
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Loan Fees (%)') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control text-right"
							name="loan_fees_percent"												
							id="loan_fees_percent" 											
							value="{{number_format($bidsModel->loan_fees_percent, 2, '.', ',')}}"
							disabled
							>	
				</div>
				
			</div><!-- Row 2 -->
			
			<div class="row"><!-- Row 3 -->	
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Total Processing Fees') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control text-right"
							name="loan_process_fees"											
							id="loan_process_fees" 											
							value="{{number_format($bidsModel->loan_process_fees, 2, '.', ',')}}" 
							disabled>	
				</div>
							
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Amount Disbursed') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control text-right"
							name="amount_disbursed"												
							id="amount_disbursed" 											
							value="{{number_format($bidsModel->amount_disbursed, 2, '.', ',')}}"
							disabled
							>	
				</div>
				
			</div><!-- Row 3-->
				
			<div class="row"><!-- Row 4-->			
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Disbursement Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="disbursement_date" 
								type="text" 
								class="disbursement_date form-control" 
								name="disbursement_date"
								required
								onchange="haveToRecalc()"
								{{$disableFields}}
								value="{{$bidsModel->system_date}}" />

						<label for="disbursement_date" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>
				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Monthly Pay-by Day') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="monthly_pay_by_date" 
								type="text" 
								class="monthly_pay_by_date form-control" 
								name="monthly_pay_by_date"
								required
								onchange="haveToRecalc()"
								{{$disableFields}}
								value="{{$bidsModel->monthly_pay_by_date}}" />

					</div>
				</div>					
			</div><!-- Row 4 -->
		
			<div class="row">  <!-- Row 5-->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label for="bid_type">
						{{ Lang::get('Bid Type') }}
					</label>
				</div>	

				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control"
							disabled
							value="{{$bidsModel->bid_typeText}}">	
				</div>

				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>	
						{{ Lang::get('Repayment Type') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
							class="form-control"
							disabled
							value="{{$bidsModel->repayment_typeText}}">	
				</div>	
								
			</div>  <!-- Row 5-->	
					
			<div class="row">  <!-- Row 6-->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label for="target_interest z">
						{{ Lang::get('Target Interest') }}
					</label>
				</div>	

				<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
							class="form-control  text-right"
							disabled
							value="{{$bidsModel->target_interest}}">	
				</div>

				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>	
						{{ Lang::get('Final Interest') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
							class="form-control  text-right"
							disabled
							value="{{$bidsModel->final_interest_rate}}">	
				</div>	
								
			</div>  <!-- Row 6 -->		
				
			<div class="row">  <!-- Row 7-->			
				@if(Route::currentRouteName()	!=	"admin.loanview")
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label for="payment_ref">
						{{ Lang::get('Payment Reference') }}
					</label>
				</div>	

				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<input 	type="text" 
							class="form-control"
							name="payment_ref"												
							id="payment_ref"
							required
							{{$disableFields}} 											
							value="">	
				</div>
				@else
				<div class="col-xs-12 col-sm-5 col-lg-3" style="display:none" id="reschd_date_label">
					<label for="payment_ref">
						{{ Lang::get('Reschedule Date') }}
					</label>
				</div>	

				<div class="col-xs-12 col-sm-7 col-lg-3 reschd_date" style="display:none" id="reschd_date_div" >									
					<div class="input-group">

						<input 	type="text" 
								class="form-control"
								name="reschd_date"												
								id="reschd_date"
								value="">	
								
						<label for="reschd_date" class="input-group-addon btn">
								<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>
				
				@endif	
				
				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label id="label_remarks">	
						{{ Lang::get('Remarks') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">									
					<textarea rows="3" class="form-control" 
							name="remarks" 
							{{$disableFields}}
							id="remarks"></textarea>	
				</div>	
								
			</div>  <!-- Row 7 -->	
				
		</div>
	</div>
</div>
