<div id="comments" class="tab-pane fade">  
	<div class="panel panel-default directorinfo applyloan"> 
		<div class="panel-body">
			<div class="row">
				
				<div class="col-sm-12">
					<div class="panel-primary panel-container">
						<div class="panel-heading panel-headsection"><!--panel head-->
							
							<div class="row">
								<div class="col-xs-12">
									<div class="col-xs-1 col-lg-1">
											<input type="checkbox" name="check" ><br>
										</div>
									<div class="col-xs-9 col-lg-9">
										<span class="pull-left">{{Lang::get('Comments')}}</span> 
									</div>
									<div class="col-xs-2 col-lg-2 text-right">
										{{Lang::get('Closed')}}
									</div>
								</div>
							</div>
							
							
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 space-around">
							<div class="col-xs-1">
								<input type="checkbox" name="check" ><br>
							</div>
							<div class="col-xs-9">
								<textarea rows="4" cols="50" class="form-control" disabled>
								
								</textarea>
							</div>
							<div class="col-xs-2 text-right">
								{{Lang::get('Closed')}}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 space-around">
							<div class="col-xs-1">
								<input type="checkbox" name="check" ><br>
							</div>
							<div class="col-xs-9">
								<textarea rows="4" cols="50" class="form-control" disabled>
								
								</textarea>
							</div>
							<div class="col-xs-2 text-right">
								{{Lang::get('Closed')}}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 space-around">
							<div class="col-xs-1">
								<input type="checkbox" name="check" ><br>
							</div>
							<div class="col-xs-9">
								<textarea rows="4" cols="50" class="form-control" disabled>
								
								</textarea>
							</div>
							<div class="col-xs-2 text-right">
								{{Lang::get('Closed')}}
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<div class="row"> 
				<div class="col-sm-12 space-around"> 
					<div class="pull-right">
						<button type="button" id="add_comment_button"	class="btn verification-button">
						<i class="fa pull-right"></i>
						{{Lang::get('Add Comments')}}
						</button>
						<button type="button" id="delete_comment_button"  class="btn verification-button">
						<i class="fa pull-right"></i>
						{{Lang::get('Delete Comments')}}
						</button>
						<button type="button" id="save_comment_button" class="btn verification-button">
						<i class="fa pull-right"></i>
						{{Lang::get('Close Comments')}}
						</button>
					</div>
				</div>
			</div>
			
		</div>
	</div>
</div>
