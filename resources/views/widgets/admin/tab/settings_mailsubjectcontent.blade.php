<div id="mail_subjectcontent" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				
				<div class="row">
					<div class="col-sm-1">
						<label>Module</label>
					</div>
					<div class="col-sm-3">
						{{ Form::select('modulelist', $adminsettingModel->moduleList, '$adminsettingModel->defaultmoduleval', ["class" => "selectpicker","id" => "type"]) }} 
					</div>
				</div>
				
				<div>&nbsp;</div>
				<div id="module_table"></div>
				
				<!--	<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table class="table table-bordered .tab-fontsize text-left">		
									<tbody>
										<tr>
											<th class="tab-head text-left col-sm-3">{{ Lang::get('Module')}}</th>	
											<th class="tab-head text-left col-sm-3">{{ Lang::get('Event')}}</th>	
											<th class="tab-head text-left col-sm-3">{{ Lang::get('Message')}}</th>	
											<th class="tab-head text-left col-sm-3">{{ Lang::get('Send Mail')}}</th>	
										<tr>
										<tr>
											<td class="col-sm-3">dfsd</td>	
											<td class="col-sm-3">dsfds</td>	
											<td class="col-sm-3">dsfdsds</td>	
											<td class="col-sm-3">1</td>	
										<tr>
											<tr>
											<td class="col-sm-3">dfsd</td>	
											<td class="col-sm-3">dsfds</td>	
											<td class="col-sm-3">dsfdsds</td>	
											<td class="col-sm-3">1</td>	
										<tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>-->
			
			<!--	<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Event/Action')}}
					</div>
					<div class="col-sm-4">
						<select class="selectpicker"><option>Event</option></select>										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Subject')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_subject"												
								id="mail_subject"
								value="">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Content')}}
					</div>
					<div class="col-sm-4">
						<textarea rows="4" class="form-control"></textarea>										
					</div>
				</div>	
				
			</div>
			
			<div class="col-sm-12">
			<hr>
			<p>Note : You can use HTML in the content to make formatting more attractive.<br> You can use the following Shortcodes [borrower_name]
			,[borrower_organisation],[loan_apply_date],[loan_bid_close_date],[loan_apply_amount]</p>
			<hr>
			</div>-->
		</div>
	</div>
</div>
</div>
