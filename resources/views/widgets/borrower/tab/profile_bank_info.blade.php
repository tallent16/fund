<div id="bank_info" class="tab-pane fade">  	
	
			<form class="form-horizontal" role="form">	
					<div class="table-responsive directorinfo"><!---table start-->
					<fieldset {{ $modelBorPrf->viewStatus }}>	
					<table class="table table-bordered .tab-fontsize text-left">						
						<tbody>		
							<tr>
								<td>
									{{ Lang::get('borrower-profile.bank_code') }}
								</td>
								<td>
									<input 	type="text" 
											id="bank_code" 
											name="bank_code"
											value="{{ $modelBorPrf->bank_code }}"
											class="form-control"
											/>
								</td>																
							</tr>					
							<tr>
								<td>
									{{ Lang::get('borrower-profile.bank_name') }}
								</td>
								<td>
									<input 	type="text" 
											id="bank_name" 
											name="bank_name"
											value="{{ $modelBorPrf->bank_name }}"
											class="form-control"
											/>
								</td>
							</tr>
							<tr>
								<td>{{ Lang::get('borrower-profile.branch_code') }}</td>
									<td>
										<input 	type="text" 
												id="branch_code" 
												name="branch_code"
												value="{{ $modelBorPrf->branch_code }}"
												class="form-control"
												/>
									</td>
							</tr>
							<tr>
							<td>{{ Lang::get('borrower-profile.acc_num') }}</td>
								<td>
									<input 	type="text" 
											id="bank_account_number" 
											name="bank_account_number"
											value="{{ $modelBorPrf->bank_account_number }}"
											class="form-control"
											/>
								</td>
							</tr>
															
						</tbody>									
					</table>	
					</fieldset>	
				</div>
			</form>
	
</div><!--profile tab-->
