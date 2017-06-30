<div id="profile_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			
			<div class="col-sm-12">
				<div class="row">
					<div class="col-sm-6">
						<label class="input-required">
							{{ Lang::get('borrower-profile.companyprofile') }}
						</label>		
						<div class="form-group" id="company_profile_parent">
							<textarea 	class="form-control required tinyTextArea" 
										rows="10" 
										id="company_profile" 
										name="company_profile"
										{{ $modelBorPrf->viewStatus }}
										>{{$modelBorPrf->company_profile}}</textarea>
						</div>								
					</div><!--col-6-->	
								
					<div class="col-sm-6">
						<label class="input-required">
							{{ Lang::get('borrower-profile.about_us') }}
						</label>
						<div class="form-group"  id="about_us_parent"> 
							<textarea 	class="form-control required tinyTextArea" 
										rows="10" 
										id="about_us" 
										name="about_us"
										{{ $modelBorPrf->viewStatus }} >{{$modelBorPrf->company_aboutus}}</textarea>
						</div>		
					</div><!--col-6-->
				</div><!--row1-->
			</div>
			
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
