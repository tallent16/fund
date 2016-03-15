<div id="bank_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo applyloan"> 						
		<div class="panel-body">
			<div class="row">
				<fieldset {{ $modelBorPrf->viewStatus }}>	
				<div class="col-sm-6 input-space">
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>{{ Lang::get('borrower-profile.bank_code') }}</label>												
						</div>
											
						<div class="col-xs-8">													
								<input 	type="text" 
										id="bank_code" 
										name="bank_code"
										value="{{ $modelBorPrf->bank_code }}"
										class="form-control"
										/>	
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>	{{ Lang::get('borrower-profile.bank_name') }}</label>												
						</div>
											
						<div class="col-xs-8">													
								<input 	type="text" 
										id="bank_name" 
										name="bank_name"
										value="{{ $modelBorPrf->bank_name }}"
										class="form-control"
										/>
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>	{{ Lang::get('borrower-profile.branch_code') }}</label>												
						</div>
											
						<div class="col-xs-8">													
								<input 	type="text" 
											id="branch_code" 
											name="branch_code"
											value="{{ $modelBorPrf->branch_code }}"
											class="form-control text-right"
											/>
						</div>
					</div>
					
					<div class="row">		
						<div class="col-xs-4">											
							<label>	{{ Lang::get('borrower-profile.acc_num') }}</label>												
						</div>
											
						<div class="col-xs-8">													
								<input 	type="text" 
										id="bank_account_number" 
										name="bank_account_number"
										value="{{ $modelBorPrf->bank_account_number }}"
										class="form-control text-right"
										/>
						</div>
					</div>						
					
				</div><!--col-6--->
				
				<div class="col-sm-6 input-space">
				</div><!--col-6--->
														
				</fieldset>	
			</div>
		</div>
	</div>
</div><!--profile tab-->
