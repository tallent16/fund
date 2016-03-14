@var	$opt1	=	""
@var	$opt2	=	""
@if( $modelBorPrf->verified_status	==	BORROWER_BANK_STATUS_UNVERIFIED)
	@var $opt1	="selected"
@elseif( $modelBorPrf->verified_status	==	BORROWER_BANK_STATUS_VERIFIED)
	@var $opt2	="selected"
@endif

<div id="company_info" class="tab-pane fade in active">	
	
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
				<div class="row">
					<fieldset {{ $modelBorPrf->viewStatus }}>
					
					<div class="col-md-6">
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.business_name') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<input 	type="text" 
										id="business_name" 
										name="business_name"
										value="{{ $modelBorPrf->business_name }}"
										class="form-control"
										/>											
							</div>
						</div>		
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.business_org') }}</label>												
							</div>
												
							<div class="col-xs-8">													
									<select class="selectpicker"
											id="business_organisation" 
											name="business_organisation"
											>
											{{ $modelBorPrf->busin_organSelectOptions }}
									</select>										
							</div>
						</div>		
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.regis_num') }}</label>												
							</div>
												
							<div class="col-xs-8">													
									<input 	type="text" 
											id="business_registration_number" 
											name="business_registration_number"
											value="{{ $modelBorPrf->business_registration_number }}"
											class="form-control"
											/>									
							</div>
						</div>		
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.industry') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								{{ Form::select('industry',$modelBorPrf->industryInfo , 
															$modelBorPrf->industry, 
															['class' => 'selectpicker']) }}								
							</div>
						</div>		
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.date_incorp') }}</label>												
							</div>
												
							<div class="col-xs-8">													
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
							</div>
						</div>	
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.operation_since') }}</label>												
							</div>
												
							<div class="col-xs-8">													
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
							</div>
						</div>	
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.paid_capital') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<input 	type="text" 
											id="paid_up_capital" 
											name="paid_up_capital"
											value="{{ $modelBorPrf->paid_up_capital }}"
											class="form-control"
											/>						
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Company Image</label>												
							</div>
												
							<div class="col-xs-8">									
									<input 	type="file" 
												class="jfilestyle" 
												data-buttonBefore="true" 
												name="company_image">									
							</div>
						</div>
							
							
						<div class="row">		
							<div class="col-xs-4">											
								<label>Company Thumbnail Image</label>												
							</div>
												
							<div class="col-xs-8">									
								<input 	type="file" 
										class="jfilestyle" 
										data-buttonBefore="true" 
										name="company_thumbnail">									
							</div>
						</div>
							
									
					</div>
					   
					<div class="col-md-6">	
							
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.reg_address') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<textarea	id="registered_address" 
												name="registered_address"
												class="form-control"
											>{{ $modelBorPrf->registered_address }}</textarea>		
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.mailing_address') }}</label>												
							</div>
												
							<div class="col-xs-8">													
									<textarea	id="mailing_address" 
												name="mailing_address"
												class="form-control"
											>{{$modelBorPrf->mailing_address}}</textarea>				
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.contact_person') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<input 	type="text" 
											id="contact_person" 
											name="contact_person"
											value="{{ $modelBorPrf->contact_person }}"
											class="form-control"
											/>		
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.contact_mobile') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<input 	type="text" 
											id="contact_person_mobile" 
											name="contact_person_mobile"
											value="{{ $modelBorPrf->contact_person_mobile }}"
											class="form-control"
											/>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.no_employees') }}</label>												
							</div>
												
							<div class="col-xs-8">													
								<input 	type="text" 
											id="number_of_employees" 
											name="number_of_employees"
											value="{{ $modelBorPrf->number_of_employees }}"
											class="form-control"
											/>
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Company Video</label>												
							</div>
												
							<div class="col-xs-8">									
								<input 	type="file" 
												class="jfilestyle" 
												data-buttonBefore="true" 
												name="company_video">								
							</div>
						</div>
							
								
					</div>
					</fieldset>	
					
				</div><!---row---> 
			</div><!---panel body---> 
		</div><!---panel---> 
</div><!---tab---> 



