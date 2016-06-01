<div id="bank_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo applyloan"> 						
		<div class="panel-body">			
			
			<fieldset {{ $modelBorPrf->viewStatus }}>
					<!---row1----->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('borrower-profile.bank_name') }}
							</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3" id="bank_name_parent">													
								<input 	type="text" 
										id="bank_name" 
										name="bank_name"
										value="{{ $modelBorPrf->bank_name }}"
										class="form-control required"
										/>
						</div>
					</div>
					<!---row1----->
					<!---row2----->					
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('borrower-profile.bank_code') }}
							</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3" id="bank_code_parent">													
								<input 	type="text" 
										id="bank_code" 
										name="bank_code"
										value="{{ $modelBorPrf->bank_code }}"
										class="form-control required"
										/>	
						</div>
					</div>
					<!---row2----->
					<!---row3----->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	
								{{ Lang::get('borrower-profile.branch_code') }}
							</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3" id="branch_code_parent">													
								<input 	type="text" 
											id="branch_code" 
											name="branch_code"
											value="{{ $modelBorPrf->branch_code }}"
											class="form-control text-right required"
											/>
						</div>
					</div>
					<!---row3----->
					<!---row4----->	
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('borrower-profile.acc_num') }}
							</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3" id="bank_account_number_parent">													
								<input 	type="text" 
										id="bank_account_number" 
										name="bank_account_number"
										value="{{ $modelBorPrf->bank_account_number }}"
										class="form-control text-right required numeric"
										/>
						</div>
					</div>			
					<!---row4----->										
			</fieldset>		
					
		</div>
	</div>
</div><!--profile tab-->
