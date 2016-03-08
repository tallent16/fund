<div id="profile_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<form class="form-horizontal" role="form">	
				
				<div class="col-sm-5">
					<label>Detailed Company Pofile</label>		
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="5" 
									id="company_profile" 
									name="company_profile"
									 {{$modelBorPrf->viewStatus}} >{{$modelBorPrf->company_profile}}</textarea>
					</div>
						
				</div><!--col-5-->
				
				<div class="col-sm-2"></div><!--col-2-->
				
				<div class="col-sm-5">
					<label>About us</label>
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="5" 
									id="about_us" 
									name="about_us"
									disabled ></textarea>
					</div>		
				</div><!--col-5-->
				
			</form>
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
