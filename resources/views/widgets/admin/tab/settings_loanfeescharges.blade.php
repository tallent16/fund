<div id="loan_feescharges" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				@foreach($settings_list as $row)
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Loan Monthly Pay by Day')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="loan_monthly"												
								id="loan_monthly"
								value="{{$row->monthly_pay_by_date}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Processing Fixed Fees')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="processing_fixed_fees"												
								id="processing_fixed_fees"
								value="{{$row->loan_fixed_fees}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Processing Fees(%)')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="processing_fees_percent"												
								id="processing_fees_percent"
								value="{{$row->loan_fees_percent}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Processing Fees Minimum')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="processing_fee_minimum"												
								id="processing_fee_minimum"
								value="{{$row->loan_fees_minimum_applicable}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Penalty Process Fees Amount')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="penalty_process_fee"												
								id="penalty_process_fee"
								value="{{$row->penalty_fee_minimum}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Penalty Process Fees Amount(%)')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="penalty_process_percent"												
								id="penalty_process_percent"
								value="{{$row->penalty_fee_percent}}">										
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Penalty Interest(%)')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="penalty_interest"												
								id="penalty_interest"
								value="{{$row->penalty_interest}}">										
					</div>
				</div>	
				@endforeach	
			</div>
			
		</div>
	</div>
</div>
