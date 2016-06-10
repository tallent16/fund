<div id="risk_factor" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<fieldset {{$commentButtonsVisibe}} >
				<div class="col-sm-12">
					<div class="row"><!--row2-->
						<div class="col-sm-6">
							<label>{{ Lang::get('borrower-profile.risk_industry') }}</label>		
							<div class="form-group" id="risk_industry_parent" >
								<textarea 	class="form-control required" 
											rows="5" 
											id="risk_industry" 
											name="risk_industry"
											>{{$adminLoanApprMod->risk_industry}}</textarea>
							</div>
								
						</div><!--col-6-->			
						
						<div class="col-sm-6">
							<label>{{ Lang::get('borrower-profile.risk_strength') }}</label>
							<div class="form-group" id="risk_strength_parent">
								<textarea 	class="form-control  required" 
											rows="5" 
											id="risk_strength" 
											name="risk_strength"
											 >{{$adminLoanApprMod->risk_strength}}</textarea>
							</div>		
						</div><!--col-6-->
					</div>
					
					<div class="row"><!--row3-->
						<div class="col-sm-6">
							<label>
								{{ Lang::get('borrower-profile.risk_weakness') }}
							</label>		
							<div class="form-group" id="risk_weakness_parent">
								<textarea 	class="form-control  required" 
											rows="5" 
											id="risk_weakness" 
											name="risk_weakness"
											>{{$adminLoanApprMod->risk_weakness}}</textarea>
							</div>						
						</div><!--col-6-->
					
						<div class="col-sm-6">
						</div>
					</div>				
				</div>
			</fieldset>
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
