<div id="profile_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<label>
							{{ Lang::get('borrower-profile.companyprofile') }}
						</label>		
						<div class="form-group" id="company_profile_parent">
							<textarea 	class="form-control required" 
										rows="10" 
										id="company_profile" 
										name="company_profile"
										{{ $modelBorPrf->viewStatus }}
										>{{$modelBorPrf->company_profile}}</textarea>
						</div>								
					</div><!--col-6-->	
								
					<div class="col-sm-6">
						<label>
							{{ Lang::get('borrower-profile.about_us') }}
						</label>
						<div class="form-group"  id="about_us_parent"> 
							<textarea 	class="form-control required" 
										rows="10" 
										id="about_us" 
										name="about_us"
										{{ $modelBorPrf->viewStatus }} >{{$modelBorPrf->company_aboutus}}</textarea>
						</div>		
					</div><!--col-6-->
				</div><!--row1-->
					
				<div class="row"><!--row2-->
					<div class="col-sm-6">
						<label>{{ Lang::get('borrower-profile.risk_industry') }}</label>		
						<div class="form-group">
							<textarea 	class="form-control" 
										rows="5" 
										id="risk_industry" 
										name="risk_industry"
										{{ $modelBorPrf->viewStatus }}>{{$modelBorPrf->risk_industry}}</textarea>
						</div>
							
					</div><!--col-6-->			
					
					<div class="col-sm-6">
						<label>{{ Lang::get('borrower-profile.risk_strength') }}</label>
						<div class="form-group">
							<textarea 	class="form-control" 
										rows="5" 
										id="risk_strength" 
										name="risk_strength"
										{{ $modelBorPrf->viewStatus }} >{{$modelBorPrf->risk_strength}}</textarea>
						</div>		
					</div><!--col-6-->
				</div>
				
				<div class="row"><!--row3-->
					<div class="col-sm-6">
						<label>
							{{ Lang::get('borrower-profile.risk_weakness') }}
						</label>		
						<div class="form-group">
							<textarea 	class="form-control" 
										rows="5" 
										id="risk_weakness" 
										name="risk_weakness"
										{{ $modelBorPrf->viewStatus }}>{{$modelBorPrf->risk_industry}}</textarea>
						</div>						
					</div><!--col-6-->
				
					<div class="col-sm-6">
					</div>
				</div>				
			</div>
			
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
