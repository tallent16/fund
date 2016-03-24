@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/borrower-makepayment.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading','Make Payment') 
@section('section')     
	<div class="col-sm-12 space-around"> 			
	
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection">
				<div class="row">
				   <div class="col-xs-12">
						Payment Details
					</div>									
				</div>                           
			</div><!-------------end of---panel heading---------------------->	
			
			
<div class="panel-body apply-loan">
			<div class="row">
					<div class="col-sm-12 col-lg-6 input-space">
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Loan Reference Number') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
										<input type="text" name="bank_code" value="1018" class="form-control" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Scheduled Date') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">	
									<div class="controls">
									<div class="input-group">												
											<input 	type="text" 
													id="schduledate" 
													name="duedate"
													value=""
													class="date-picker form-control"
													readonly disabled/>		
										<label class="input-group-addon btn" for="schduledate" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</label>
										</div>
										</div>
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Installment Amount') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
										<input type="text" name="bank_code" value="1000" class="form-control" disabled>
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
													name="duedate"
													value=""
													class="date-picker form-control"
													readonly disabled/>		
										<label class="input-group-addon btn" for="actualdate" disabled>
											<span class="glyphicon glyphicon-calendar"></span>
										</label>
										</div>
										</div>
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Penalty') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
										<input type="text" name="bank_code" value="1000" class="form-control" disabled>
							</div>
						</div>
						
						
					</div>
					
					<div class="col-sm-12 col-lg-6 input-space">
						
						
						
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Total due') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
										<input type="text" name="bank_code" value="1000" class="form-control" disabled>
							</div>
						</div>
						<div class="row">		
							<div class="col-xs-12 col-sm-4">											
								<label>{{ Lang::get('Remarks') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-8">													
										<textarea rows="6" id="" class="form-control" ></textarea>
							</div>
						</div>
						
					</div>
				</div>
		
									
	</div>		
			
			
		</div><!-----panel--->      
		
		
		<div class="col-sm-12">
			<div class="pull-right">
					<button type="submit" 
						class="btn verification-button"	>
					<i class="fa pull-right"></i>
					Submit for Approval
				</button>
			</div>
		</div>		
		             
   
</div><!-----col--12--->

	@endsection  
@stop
