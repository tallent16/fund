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
					<div class="col-md-6 col-xs-12 input-space">
						<fieldset {{ $modelBorPrf->viewStatus }}>
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">{{ Lang::get('borrower-profile.business_name') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7" id="business_name_parent">													
									<input 	type="text" 
											id="business_name" 
											name="business_name"
											value="{{ $modelBorPrf->business_name }}"
											class="form-control required"
											/>											
								</div>
							</div>		
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.business_org') }}
									</label>												
								</div>
													
								<div 	class="col-xs-12 col-sm-7" 
										id="business_organisation_parent">													
										<select class="selectpicker required"
												id="business_organisation" 
												name="business_organisation"
												>
												{{ $modelBorPrf->busin_organSelectOptions }}
										</select>										
								</div>
							</div>		
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.regis_num') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7" id="business_registration_number_parent">													
										<input 	type="text" 
												id="business_registration_number" 
												name="business_registration_number"
												value="{{ $modelBorPrf->business_registration_number }}"
												class="form-control text-right required"
												/>									
								</div>
							</div>		
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
											{{ Lang::get('borrower-profile.industry') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7" id="industry_parent">													
									{{ Form::select('industry',$modelBorPrf->industryInfo , 
																$modelBorPrf->industry, 
																['class' => 'selectpicker text-right required']) }}								
								</div>
							</div>		
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.date_incorp') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="date_of_incorporation_parent">													
									<div class="controls">
										<div class="input-group">
											<input 	type="text" 
													id="date_of_incorporation" 
													name="date_of_incorporation"
													value="{{ $modelBorPrf->date_of_incorporation }}"
													class="date-picker form-control required"
													readonly />	
											<label class="input-group-addon btn" for="date_of_incorporation">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>								
								</div>
							</div>	
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.operation_since') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="operation_since_parent">													
									<div class="controls">
										<div class="input-group">
											<input 	type="text"  
													id="operation_since" 
													name="operation_since"
													value="{{ $modelBorPrf->operation_since }}"
													class="date-picker form-control required"
													readonly />
											<label class="input-group-addon btn" for="operation_since">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>								
								</div>
							</div>	
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.paid_capital') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="paid_up_capital_parent">													
									<input 	type="text" 
												id="paid_up_capital" 
												name="paid_up_capital"
												value="{{ $modelBorPrf->paid_up_capital }}"
												class="form-control text-right required"
												/>						
								</div>
							</div>
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.company_image') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="company_image_parent">									
										<input 	type="file" 
													class="jfilestyle  required" 
													data-buttonBefore="true" 
													name="company_image"
													id="company_image"
													/>									
										<input 	type="hidden" 
													id="company_image_hidden"
													value="{{ $modelBorPrf->company_image }}"
													/>									
								</div>
							</div>
								
								
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label>
										{{ Lang::get('borrower-profile.company_thumb_image') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="industry_parent">									
									<input 	type="file" 
											class="jfilestyle" 
											data-buttonBefore="true" 
											name="company_thumbnail"
											/>									
								</div>
							</div>
						</fieldset>	
					</div>
					   
					<div class="col-md-6 col-xs-12 input-space">	
						<fieldset {{ $modelBorPrf->viewStatus }}>	
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.reg_address') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="registered_address_parent">													
									<textarea	id="registered_address" 
													name="registered_address"
													class="form-control required"
												>{{ $modelBorPrf->registered_address }}</textarea>		
								</div>
							</div>
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('Mailing Address') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="mailing_address_parent">													
										<textarea	id="mailing_address" 
													name="mailing_address"
													class="form-control required"
												>{{$modelBorPrf->mailing_address}}</textarea>				
								</div>
							</div>
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.contact_person') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="contact_person_parent">													
									<input 	type="text" 
												id="contact_person" 
												name="contact_person"
												value="{{ $modelBorPrf->contact_person }}"
												class="form-control required"
												/>		
								</div>
							</div>
							
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.contact_mobile') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="contact_person_mobile_parent">													
									<input 	type="text" 
												id="contact_person_mobile" 
												name="contact_person_mobile"
												value="{{ $modelBorPrf->contact_person_mobile }}"
												class="form-control text-right  required"
												/>	
								</div>
							</div>
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<label class="input-required">
										{{ Lang::get('borrower-profile.no_employees') }}
									</label>												
								</div>
													
								<div class="col-xs-12 col-sm-7"  id="number_of_employees_parent">													
									<input 	type="text" 
												id="number_of_employees" 
												name="number_of_employees"
												value="{{ $modelBorPrf->number_of_employees }}"
												class="form-control text-right required"
												/>
								</div>
							</div>
						</fieldset>
						<div class="row">		
							<div class="col-xs-12 col-sm-5">											
								<label>
									{{ Lang::get('Grade') }}
								</label>												
							</div>
												
							<div 	class="col-xs-12 col-sm-7">		
								@var	$gradeInfo	=	[''=>'none']+$modelBorPrf->gradeInfo
								{{ Form::select('grade',$gradeInfo, 
																$modelBorPrf->grade, 
																['class' => 'selectpicker text-right',$gradeStatus])
								}}										
							</div>
						</div>
					<!--<div class="row">		
							<div class="col-xs-4">											
								<label>{{ Lang::get('borrower-profile.company_video') }}</label>												
							</div>
												
							<div class="col-xs-8">									
								<input 	type="file" 
												class="jfilestyle" 
												data-buttonBefore="true" 
												name="company_video">								
							</div>
						</div>-->
							
								
					</div>
			</div><!---row---> 
			@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
				@if($gradeStatus	==	"")
					<div class="row">
						<div class="col-md-6 col-xs-12 input-space">
						</div>
						<div class="col-md-6 col-xs-12 input-space">
							<div class="row">		
								<div class="col-xs-12 col-sm-5">											
									<button type="button" 
											id="update_grade"
											class="btn verification-button" >
											<i class="fa pull-right"></i>
											{{ Lang::get('Update Grade') }}
									</button>											
								</div>
													
								<div 	class="col-xs-12 col-sm-7">													
									
								</div>
							</div>	
						</div>
					</div>
				@endif
			@endif
		</div><!---panel body---> 
	</div><!---panel---> 
</div><!---tab---> 



