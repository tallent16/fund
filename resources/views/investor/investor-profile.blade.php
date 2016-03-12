@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/investor-profile.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading','Profile') 
@section('section')  		
<div class="col-sm-12 space-around"> 
	
			<div class="col-sm-12">
				<div class="annoucement-msg-container">
					<div class="alert alert-danger annoucement-msg">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Comments/remarks
					</div>
				</div>
			</div>
	
		<div class="col-sm-12 col-lg-12 "> 			
	
				
			<div class="panel panel-primary panel-container">
				<div class="panel-heading panel-headsection">
					<div class="row">
					   <div class="col-xs-12">
							Profile
						</div>									
					</div>                           
				</div><!-------------end of---panel heading---------------------->	
				
				<div class="col-sm-6">
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Full Name</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="full_name" 
								value="Maxene Smith" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Display Name</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="display_name" 
								value="Maxene Smith" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Email</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="email" 
								value="maxenesmith@info.com" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Mobile Number</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="mobile_Num" 
								value="123456789" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Mobile Number verified status</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="mobile_Num_Verification" 
								value="verified" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Date of Birth</label>												
						</div>
											
						<div class="col-xs-8">													
								<div class="controls">
										<div class="input-group">
											<input 	type="text" 
													id="dob"  
													name="dob" 
													value=""
													class="date-picker-2 form-control"
													readonly />	
											<label class="input-group-addon btn" for="dob">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>NRIC Number</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="nric_Num" 
								value="123456789" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Bank Name</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="bank_Name" 
								value="OCBC Bank" class="form-control">
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>Bank Name</label>												
						</div>
											
						<div class="col-xs-8">													
								<input type="text" name="bank_Name" 
								value="OCBC Bank" class="form-control">
						</div>
					</div>
					
				</div>
				<div class="col-sm-6">
				</div>
				
				
				
				
				
				
				
				
				
				<div class="table-responsive">				
					<table class="table text-left table-bordered">					
						<tbody>
							<tr>
								<td class="tab-left-head">Full Name</th>
								<td><input type="text" name="full_name" value="Maxene Smith" class="form-control"></td>																			
							</tr>
							<tr>
								<td class="tab-left-head">Display Name</td>
								<td><input type="text" name="display_name" value="Maxene Smith" class="form-control"></td>																					
							</tr>	
							<tr>
								<td class="tab-left-head">Email</td>
								<td><input type="text" name="email" value="maxenesmith@info.com" class="form-control"></td>																					
							</tr>	
							<tr>
								<td class="tab-left-head">Mobile Number</td>		
								<td><input type="text" name="mobile_Num" value="123456789" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Mobile Number verified status</td>		
								<td><input type="text" name="mobile_Num_Verification" value="verified" class="form-control"></td>																				
							</tr>	
							<tr>
								<td class="tab-left-head">Date of Birth</th>						
								<td>
									<div class="controls">
										<div class="input-group">
											<input 	type="text" 
													id="dob"  
													name="dob" 
													value=""
													class="date-picker-2 form-control"
													readonly />	
											<label class="input-group-addon btn" for="dob">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>
								</td>																					
							</tr>	
							<tr>
								<td class="tab-left-head">NRIC Number</td>		
								<td><input type="text" name="nric_Num" value="123456789" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Bank Name</td>		
								<td><input type="text" name="bank_Name" value="OCBC Bank" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Bank Account Number</td>		
								<td><input type="text" name="bank_Acc_Num" value="123456789" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Bank Code</td>		
								<td><input type="text" name="bank_Code" value="123" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Branch Code</td>		
								<td><input type="text" name="branch_Code" value="123" class="form-control"></td>																				
							</tr>
							<tr>
								<td class="tab-left-head">Verification Status</td>		
								<td><input type="text" name="verification_Status" value="verified" class="form-control"></td>																				
							</tr>
																
						</tbody>
					</table>									
				</div><!-----table responsive--->					
			</div><!-----panel---> 
		</div><!-----col---> 	     
		
				
		
		<div class="col-sm-12 col-lg-12  ">
			<div class="pull-right">
				<button type="submit" 
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					Submit for Verification
				</button>
			</div>
		</div>		
		
		             
   
</div><!-----col--12--->

     
  @endsection  
@stop
