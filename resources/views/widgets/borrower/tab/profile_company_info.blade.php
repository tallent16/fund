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
			
		<fieldset {{ $modelBorPrf->viewStatus }}>		
			<!------row--1----------->	
			<div class="row">		
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">{{ Lang::get('borrower-profile.business_name') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3" id="business_name_parent">													
					<input 	type="text" 
							id="business_name" 
							name="business_name"
							value="{{ $modelBorPrf->business_name }}"
							class="form-control required"
							/>											
				</div>
				
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.business_org') }}
					</label>												
				</div>
													
				<div class="col-xs-12 col-sm-7 col-lg-3" 
						id="business_organisation_parent">													
					<select class="selectpicker required"
							id="business_organisation" 
							name="business_organisation"
							>
							{{ $modelBorPrf->busin_organSelectOptions }}
					</select>										
				</div>											
			</div>		
			<!------row--1----------->	
			<!------row 2------------>		
			<div class="row">			
				<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-profile.regis_num') }}
						</label>												
					</div>									
					<div class="col-xs-12 col-sm-7 col-lg-3" id="business_registration_number_parent">													
							<input 	type="text" 
									id="business_registration_number" 
									name="business_registration_number"
									value="{{ $modelBorPrf->business_registration_number }}"
									class="form-control required"
									/>									
					</div>
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
							{{ Lang::get('borrower-profile.industry') }}
					</label>												
				</div>
									
				<div class="col-xs-12 col-sm-7 col-lg-3" id="industry_parent">													
					{{ Form::select('industry',$modelBorPrf->industryInfo , 
												$modelBorPrf->industry, 
												['class' => 'selectpicker text-right required']) }}								
				</div>
			</div>			
			<!------row 2------------>
			<!------row--3----------->
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.reg_address') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="registered_address_parent">													
					<textarea	id="registered_address" 
									name="registered_address"
									class="form-control required"
								>{{ $modelBorPrf->registered_address }}</textarea>		
				</div>	
				
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('Mailing Address') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="mailing_address_parent">													
						<textarea	id="mailing_address" 
									name="mailing_address"
									class="form-control required"
								>{{$modelBorPrf->mailing_address}}</textarea>				
				</div>
			</div>			
			<!------row--3----------->
			<!------row--4----------->
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.date_incorp') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="date_of_incorporation_parent">													
					<div class="controls">
						<div class="input-group">
							<input 	type="text" 
									id="date_of_incorporation" 
									name="date_of_incorporation"
									value="{{ $modelBorPrf->date_of_incorporation }}"
									class="date-picker form-control required"
									 />	
							<label class="input-group-addon btn" for="date_of_incorporation">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>													
					</div>								
				</div>		
						
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.operation_since') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="operation_since_parent">													
					<div class="controls">
						<div class="input-group">
							<input 	type="text"  
									id="operation_since" 
									name="operation_since"
									value="{{ $modelBorPrf->operation_since }}"
									class="date-picker form-control required"
									 />
							<label class="input-group-addon btn" for="operation_since">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>													
					</div>								
				</div>					
			</div>
			<!------row--4----------->
			<!------row--5----------->				
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.paid_capital') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="paid_up_capital_parent">													
					<input 	type="text" 
								id="paid_up_capital" 
								name="paid_up_capital"
								value="{{number_format($modelBorPrf->paid_up_capital,2,'.',',') 	 }}"
								class="form-control text-right required amount-align"
								decimal=2
								/>						
				</div>
								
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.no_employees') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="number_of_employees_parent">													
					<input 	type="text" 
								id="number_of_employees" 
								name="number_of_employees"
								value="{{ $modelBorPrf->number_of_employees }}"
								class="form-control text-right required numeric"
								/>
				</div>				
			</div>
			<!------row--5----------->
			<!------row--6----------->
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.contact_person') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="contact_person_parent">													
					<input 	type="text" 
								id="contact_person" 
								name="contact_person"
								value="{{ $modelBorPrf->contact_person }}"
								class="form-control required"
								/>		
				</div>							
				
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.contact_mobile') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="contact_person_mobile_parent">													
					<input 	type="text" 
								id="contact_person_mobile" 
								name="contact_person_mobile"
								value="{{ $modelBorPrf->contact_person_mobile }}"
								class="form-control text-right  required mobile"
								maxlength="10"
								/>	
				</div>
			</div>
			<!------row--6----------->
			<!------row--7----------->	
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('borrower-profile.company_image') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="company_image_parent">									
					<input 	type="file" 
								class="jfilestyle  required" 
								data-buttonBefore="true" 
								name="company_image"
								id="company_image"
								accept="image/*" 
								/>	
															
					<input 	type="hidden" 
								id="company_image_hidden"
								name="company_image_hidden"
								value="{{ $modelBorPrf->company_image }}"
								/>		
					@if($modelBorPrf->company_image!="")
						<a 	href="{{url($modelBorPrf->company_image)}}"  
							target="_blank" 
							class="hyperlink">
							{{basename($modelBorPrf->company_image)}}
						</a>
					@endif
				</div>
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label>
						{{ Lang::get('borrower-profile.company_thumb_image') }}
					</label>												
				</div>
									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="industry_parent">									
					<input 	type="file" 
							class="jfilestyle" 
							data-buttonBefore="true" 
							name="company_thumbnail"
							accept="image/*" 
							/>
					<input 	type="hidden" 
								id="company_thumbnail_hidden"
								name="company_thumbnail_hidden"
								value="{{ $modelBorPrf->company_image_thumbnail }}"
								/>				
					@if($modelBorPrf->company_image_thumbnail!="")
						<a href="{{url($modelBorPrf->company_image_thumbnail)}}" 
							target="_blank" 
							class="hyperlink">
							{{basename($modelBorPrf->company_image_thumbnail)}}
						</a>
					@endif							
				</div>							
			</div>	
			<!--	row columns added new on 3/June/2016 ACRA Business Profile and Memoradum and Articles of Association -->
			<div class="row">
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label class="input-required">
						{{ Lang::get('ACRA Business Profile') }}
					</label>												
				</div>									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="acra_profile_doc_url_parent">									
					<input 	type="file" 
								class="jfilestyle  required" 
								data-buttonBefore="true" 
								name="acra_profile_doc_url"
								id="acra_profile_doc_url"
								/>	
															
					<input 	type="hidden" 
								id="acra_profile_doc_url_hidden"
								name="acra_profile_doc_url_hidden"
								value="{{ $modelBorPrf->acra_profile_doc_url }}"
								/>		
					@if($modelBorPrf->acra_profile_doc_url!="")
						@var	$acraUrl	=	url('download/borrower/profile/attachment')."/".$modelBorPrf->borrower_id."/3";	
						<a 	href="{{$acraUrl}}"  
							class="hyperlink">
							{{basename($modelBorPrf->acra_profile_doc_url)}}
						</a>
					@endif
					
				</div>
				<div class="col-xs-12 col-sm-5 col-lg-3">											
					<label>
						{{ Lang::get('Memorandum and Articles of Association') }}
					</label>												
				</div>
									
				<div class="col-xs-12 col-sm-7 col-lg-3"  id="moa_doc_url_parent">									
					<input 	type="file" 
							class="jfilestyle" 
							data-buttonBefore="true" 
							name="moa_doc_url"
							id="moa_doc_url"
							
							/>	
							<input 	type="hidden" 
								id="moa_doc_url_hidden"
								name="moa_doc_url_hidden"
								value="{{ $modelBorPrf->moa_doc_url }}"
								/>			
					@if($modelBorPrf->moa_doc_url!="")
						@var	$moaUrl	=	url('download/borrower/profile/attachment')."/".$modelBorPrf->borrower_id."/4";	
						<a href="{{$moaUrl}}" 
							class="hyperlink">
							{{basename($modelBorPrf->moa_doc_url)}}
						</a>
					@endif							
				</div>							
			</div>	
		<!--	row columns added new on 3/June/2016 ACRA Business Profile and Memoradum and Articles of Association -->
		</fieldset>	
			<!------row--7----------->	
			
		</div><!---panel body---> 
	</div><!---panel---> 
</div><!---tab---> 
