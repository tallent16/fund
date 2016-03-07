<div id="profile_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			
			<div class="col-sm-6">
				<div class="row">
					<div class="pull-left">
						{{ Lang::get('borrower-profile.companyprofile') }}
					</div>
				</div>
				<br>			
				<form class="form-horizontal" role="form">	
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="2" 
									id="company_profile" 
									name="company_profile"
									 {{$modelBorPrf->viewStatus}} >{{$modelBorPrf->company_profile}}</textarea>
					</div>
					<label>About us</label>
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="2" 
									id="about_us" 
									name="about_us"
									 ></textarea>
					</div>
					<label>Director's Summary</label>
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="2" 
									id="director_summary" 
									name="director_summary"
									></textarea>
					</div>
					<label>Rich Snapshot</label>
					<div class="form-group">
						<textarea 	class="form-control" 
									rows="2" 
									id="rich_snapshot" 
									name="rich_snapshot"
									></textarea>
					</div>
					
					
				</form>
			</div><!--col-6-->
			
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
