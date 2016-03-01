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
				<div class="form-group">
					<textarea 	class="form-control" 
								rows="10" 
								id="company_profile" 
								name="company_profile"
								 {{$modelBorPrf->viewStatus}} >{{$modelBorPrf->company_profile}}</textarea>
				</div>
			</div><!--col-6-->
			
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
