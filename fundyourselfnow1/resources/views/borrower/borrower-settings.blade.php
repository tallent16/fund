@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Settings') 
@section('section')    
	<div class="col-sm-12 borrower-settings"> 

			<div class="panel panel-default">							
				<div class="panel-body">
					
					  <!----------------------------------------General Account Settings Starts------------------------------------------>
					<div class="row">
						<div class="col-sm-11 col-sm-offset-1"> 
							<div class="font-bold">General Account Settings</div>
						</div>
					</div>
					
					<hr width="85%">															
					
					<div class="row">
						<div class="col-sm-11 col-sm-offset-1">
							<form class="form-horizontal" role="form">		
																
								<div class="form-group">
									<label class="col-sm-2" for="pwd">Name:</label>
									<div class="col-sm-4"> 
									  <input type="text" class="form-control" id="name" placeholder="Name">
									</div>		
									<div class="col-sm-6"> 	</div>									
								 </div>
							
								<div class="form-group"> 
									<label class="col-sm-2" for="pwd">Username:</label>
									<div class="col-sm-4"> 
									  <input type="text" class="form-control" id="pwd" placeholder="username">
									</div>
									<div class="col-sm-6"> 	</div>	
								 </div>	
																	
								<div class="form-group">
									<label class="col-sm-2" for="email">Email:</label>
									<div class="col-sm-4">
									  <input type="email" class="form-control" id="email" placeholder="Email">
									</div>
									<div class="col-sm-6"> 	</div>	
								</div>		  
											
								<div class="row">									
									<div class="col-sm-4 col-sm-offset-2 col-xs-6 col-xs-offset-6">
										<div class="pull-left">						 										  
											<button type="submit" class="button-orange">UPDATE</button>	
										</div>
										<div class="pull-right">	
											<button type="submit" class="button-red">DELETE</button>
										</div>
									</div>									  													
								</div>
								
							</form>
						</div><!-----col--->
					</div><!---row--->
				
					<hr>
			        <!----------------------------------------password settings starts------------------------------------------>
					<div class="row">
						<div class="col-sm-11 col-sm-offset-1"> 
							<div class="font-bold">
								Password Settings			
							</div>										
						</div>									
					</div>
					
					<hr width="85%">															
					
					<div class="row">
						<div class="col-sm-11 col-sm-offset-1">
							<form class="form-horizontal" role="form">	
																	
								<div class="form-group">
									<label class="col-sm-2" for="pwd">Old Password:</label>
									<div class="col-sm-4"> 
									  <input type="password" class="form-control" id="oldpwd" placeholder="Old Password">
									</div>		
									<div class="col-sm-6"></div>									
								 </div>
							
								<div class="form-group"> 
									<label class="col-sm-2" for="pwd">New Password:</label>
									<div class="col-sm-4"> 
									  <input type="password" class="form-control" id="newpwd" placeholder="New Password">
									</div>
									<div class="col-sm-6"></div>	
								 </div>	
																	
								<div class="form-group">
									<label class="col-sm-2" for="email">Verify Password:</label>
									<div class="col-sm-4">
									  <input type="password" class="form-control" id="verifypwd" placeholder="Verify Password">
									</div>
									<div class="col-sm-6"></div>	
								</div>		  
											
								<div class="row">														
									<div class="col-sm-4 col-sm-offset-2 col-xs-6 col-xs-offset-6">
										<div class="pull-left">						 										  
											<button type="submit" class="button-orange">UPDATE</button>	
										</div>													
									</div>																									
								</div>
								
							</form> 
						</div><!-----col--->
					</div><!---row--->
				
				</div><!--panel body--->				
			</div><!--panel default--->	

	</div>
	@endsection  
@stop
