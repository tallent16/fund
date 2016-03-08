@var	$opt1	=	""
@var	$opt2	=	""
@if( $modelBorPrf->verified_status	==	BORROWER_BANK_STATUS_UNVERIFIED)
	@var $opt1	="selected"
@elseif( $modelBorPrf->verified_status	==	BORROWER_BANK_STATUS_VERIFIED)
	@var $opt2	="selected"
@endif

<div id="company_info" class="tab-pane fade in active">	
				<div class="table-responsive directorinfo"><!---table start-->
					<fieldset {{ $modelBorPrf->viewStatus }}>	
					<table class="table table-bordered .tab-fontsize text-left">						
						<tbody>							
							<tr>
								<td>
									{{ Lang::get('borrower-profile.business_name') }}
								</td>
								<td>
									<input 	type="text" 
											id="business_name" 
											name="business_name"
											value="{{ $modelBorPrf->business_name }}"
											class="form-control"
											/>
								</td>		
								<td>{{ Lang::get('borrower-profile.no_employees') }}</td> 
								<td>
									<input 	type="text" 
											id="number_of_employees" 
											name="number_of_employees"
											value="{{ $modelBorPrf->number_of_employees }}"
											class="form-control"
											/>
								</td>																
							</tr>
							<tr>
								<td>
									{{ Lang::get('borrower-profile.business_org') }}
								</td>
								<td>
									<select class="selectpicker"
											id="business_organisation" 
											name="business_organisation"
											>
											{{ $modelBorPrf->busin_organSelectOptions }}
									</select>
<!--
									<input 	type="text" 
											id="business_organisation" 
											name="business_organisation"
											value="{{ $modelBorPrf->business_organisation }}"
											class="form-control"
											/>
-->
								</td>		
								<td>{{ Lang::get('borrower-profile.regis_num') }}</td>
								<td>
									<input 	type="text" 
											id="business_registration_number" 
											name="business_registration_number"
											value="{{ $modelBorPrf->business_registration_number }}"
											class="form-control"
											/>
								</td>
								
																														
							
							</tr>
							<tr>
								<td>{{ Lang::get('borrower-profile.date_incorp') }}</td>
								<td>
									<div class="controls">
										<div class="input-group">
											<input 	type="text" 
													id="date_of_incorporation" 
													name="date_of_incorporation"
													value="{{ $modelBorPrf->date_of_incorporation }}"
													class="date-picker form-control"
													readonly />	
											<label class="input-group-addon btn" for="date_of_incorporation">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>
								</td>
								<td>{{ Lang::get('borrower-profile.operation_since') }}</td> 
								<td>
									<div class="controls">
										<div class="input-group">
											<input 	type="text"  
													id="operation_since" 
													name="operation_since"
													value="{{ $modelBorPrf->operation_since }}"
													class="date-picker form-control"
													readonly />
											<label class="input-group-addon btn" for="operation_since">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>
								</td>	
										
							
																																		
																							
							</tr>
							<tr>
														
								<td>{{ Lang::get('borrower-profile.mailing_address') }}</td> 
								<td>
									<textarea	id="mailing_address" 
												name="mailing_address"
												class="form-control"
											>{{$modelBorPrf->mailing_address}}</textarea>
								</td>	
								<td>{{ Lang::get('borrower-profile.reg_address') }}</td> 
								<td>
									<textarea	id="registered_address" 
												name="registered_address"
												class="form-control"
											>{{ $modelBorPrf->registered_address }}</textarea>
								</td>																										
									
							</tr>
							<tr>
								<td>{{ Lang::get('borrower-profile.contact_person') }}</td>
								<td>
									<input 	type="text" 
											id="contact_person" 
											name="contact_person"
											value="{{ $modelBorPrf->contact_person }}"
											class="form-control"
											/>
								</td>		
								
								<td>{{ Lang::get('borrower-profile.contact_mobile') }}</td>
								<td>
									<input 	type="text" 
											id="contact_person_mobile" 
											name="contact_person_mobile"
											value="{{ $modelBorPrf->contact_person_mobile }}"
											class="form-control"
											/>
								</td>																										
							
							<!--	<td>{{ Lang::get('borrower-profile.bank_verification') }}</td>
								<td>
									<select id="verified_status" 
											name="verified_status"
											class="selectpicker">
										<option value=1 {{ $opt1 }}>Not verified</option>
										<option value=2  {{ $opt2 }}>verified</option>
									</select>
								</td>		-->														
							</tr>							
							<tr>
								<td>{{ Lang::get('borrower-profile.paid_capital') }}</td>
								<td>
									<input 	type="text" 
											id="paid_up_capital" 
											name="paid_up_capital"
											value="{{ $modelBorPrf->paid_up_capital }}"
											class="form-control"
											/>
								</td>																										
							</tr>								
														
						</tbody>									
					</table>	
					</fieldset>					
				</div> <!---table end---> 				
			
</div><!---tab---> 

