<div id="profile_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<div class="col-sm-12">
				<div class="row">
						<div class="col-sm-6">
							<label>Detailed Company Profile</label>		
							<div class="form-group">
								<textarea 	class="form-control" 
											rows="10" 
											id="company_profile" 
											name="company_profile"
											{{ $modelBorPrf->viewStatus }}
											>{{$modelBorPrf->company_profile}}</textarea>
							</div>
								
						</div><!--col-6-->	
									
						<div class="col-sm-6">
							<label>About us</label>
							<div class="form-group">
								<textarea 	class="form-control" 
											rows="10" 
											id="about_us" 
											name="about_us"
											{{ $modelBorPrf->viewStatus }} >{{$modelBorPrf->company_aboutus}}</textarea>
							</div>		
						</div><!--col-6-->
					</div><!--row1-->
					<div class="row">
				<div class="col-sm-6">
					<label>Risk Industy</label>		
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="5" 
									id="risk_industry" 
									name="risk_industry"
									{{ $modelBorPrf->viewStatus }}>{{$modelBorPrf->risk_industry}}</textarea>
					</div>
						
				</div><!--col-6-->			
				
				<div class="col-sm-6">
					<label>Risk Strength</label>
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="5" 
									id="risk_strength" 
									name="risk_strength"
									{{ $modelBorPrf->viewStatus }} >{{$modelBorPrf->risk_strength}}</textarea>
					</div>		
				</div><!--col-6-->
				</div>
				<div class="row">
				<div class="col-sm-6">
					<label>Risk Weakness</label>		
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
