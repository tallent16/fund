@var	$gender_male		=	""
@var	$gender_female		=	""
@var	$gender_disabled	=	"disabled"
@if($InvPrfMod->gender	==	1)
	@var	$gender_male		=	"checked"
	@var	$gender_disabled	=	""
@elseif($InvPrfMod->gender	==	2)
	@var	$gender_female		=	"checked"
	@var	$gender_disabled	=	""
@else
	@var	$gender_male		=	"checked"
@endif  

	<div id="inv_profile_info" class="tab-pane fade in active">  	
		<div class="panel-body applyloan table-border-custom input-space">
			<fieldset {{$InvPrfMod->viewStatus}} >
					<!--------------------row--1--------------------------->				
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('First Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="firstname" 
								value="{{$InvPrfMod->firstname}}" 
								class="form-control" required>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label class="input-required">	{{ Lang::get('Last Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="lastname" 
								value="{{$InvPrfMod->lastname}}" 
								class="form-control" required>
						</div>						
					</div>
					<!--------------------row--1--------------------------->
					
					<!--------------------row--2--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Display Name') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
							<input type="text" 
									name="displayname" 
									id="displayname" 
									value="{{$InvPrfMod->displayname}}" 
									onchange="checkDisplayName(this.value);"
									class="form-control" required>
							<label 	style="display: none;" 
									class="control-label label_displayname_error" 
									></label>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Email') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
							<input type="text" 
									name="email" 
									id="email" 
									value="{{$InvPrfMod->email}}" 
									onchange="checkEmail(this.value);"
									class="form-control" required>
							<label 	style="display: none;" 
									class="control-label label_email_error" 
									></label>
						</div>						
					</div>
					<!--------------------row--2--------------------------->
					
					</fieldset>
					<!--------------------row--3--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label class="input-required">	{{ Lang::get('Mobile Number') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="mobile" 
								value="{{$InvPrfMod->mobile}}" 
								class="form-control" required>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">									
							<label class="input-required">	{{ Lang::get('Date of Birth') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
							<div class="controls">
								<div class="input-group">
									<input 	type="text" 
											id="date_of_birth"  
											name="date_of_birth" 
											value="{{$InvPrfMod->date_of_birth}}"
											class="date-picker-2 form-control"
											{{$InvPrfMod->viewStatus}} />	 
									<label class="input-group-addon btn" for="date_of_birth">
										<span class="glyphicon glyphicon-calendar" ></span>
									</label>
								</div>													
							</div>
						</div>
					</div>
					<!--------------------row--3--------------------------->
					<fieldset {{$InvPrfMod->viewStatus}} >
					<!--------------------row--4--------------------------->
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Gender') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
							<label class="radio-inline">
								<input type="radio" 
										name="gender" 
										value="1" 
										{{$gender_male}}>
								{{ Lang::get('Male')}}
							</label>
							<label class="radio-inline">
								<input type="radio" 
										name="gender" 
										value="2" 
										{{$gender_female}}>
								{{ Lang::get('Female')}}
							</label>
						</div>
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label  class="input-required">	{{ Lang::get('Nationality') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">							
							{{ Form::select('nationality', $InvPrfMod->allTransList, $InvPrfMod->nationality_code, ["class" => "selectpicker required"]) }} 
						</div>
						
					</div>	
					<!--------------------row--4--------------------------->
					
					<!--------------------row--5--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('NRIC Number') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="nric_number" 
								value="{{$InvPrfMod->nric_number}}" 
								class="form-control text-right" required>
						</div>
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Estimated Yearly Income') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">							
								<input type="text" 
										name="estimated_yearly_income" 
										value="{{$InvPrfMod->estimated_yearly_income }}" 
										class="form-control" required>								
						</div>
											
					</div>						
					<!--------------------row--5--------------------------->
					<!--------------------row-6--------------------------->
					
					<hr><!---------------divider-------------------------------->
					<!---------------------------row--6---------------------->	
					<!---------------------------row--7---------------------->	
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('Copy of ID-card - Front') }}
							</label>												
						</div>									
						<div class="col-xs-12 col-sm-7 col-lg-3">									
							<input 	type="file" 
										class="jfilestyle  required" 
										data-buttonBefore="true" 
										name="identity_card_image_front"
										id="identity_card_image_front"										
										required>									
							<input 	type="hidden" 
								id="identity_card_image_front_hidden"
								value="{{ $InvPrfMod->identity_card_image_front }}"
								/>	
							@if($InvPrfMod->identity_card_image_front!="")
								<a 	href="{{url($InvPrfMod->identity_card_image_front)}}"  
									target="_blank" 
									class="hyperlink">
									{{basename($InvPrfMod->identity_card_image_front)}}
								</a>	
							@endif			
						</div>
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label class="input-required">
								{{ Lang::get('Copy of ID-card - Back') }}
							</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">									
							<input 	type="file" 
										class="jfilestyle  required" 
										data-buttonBefore="true" 
										name="identity_card_image_back"
										id="identity_card_image_back"										
										required>									
							<input 	type="hidden" 
								id="identity_card_image_back_hidden"
								value="{{ $InvPrfMod->identity_card_image_back }}"
								/>		
							@if($InvPrfMod->identity_card_image_back!="")
								<a 	href="{{url($InvPrfMod->identity_card_image_back)}}"  
									target="_blank" 
									class="hyperlink">
									{{basename($InvPrfMod->identity_card_image_back)}}
								</a>	
							@endif				
						</div>							
					</div>	
		
					<!------row--7----------->	
						<!------row--8----------->	
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('Address Proof Copy') }}
							</label>												
						</div>									
						<div class="col-xs-12 col-sm-7 col-lg-3">									
							<input 	type="file" 
										class="jfilestyle  required" 
										data-buttonBefore="true" 
										name="address_proof_image"
										id="address_proof_image"										
										required>									
							<input 	type="hidden" 
								id="address_proof_image_hidden"
								value="{{ $InvPrfMod->address_proof_image }}"
								/>		
							@if($InvPrfMod->address_proof_image!="")
								<a 	href="{{url($InvPrfMod->address_proof_image)}}"  
									target="_blank" 
									class="hyperlink">
									{{basename($InvPrfMod->address_proof_image)}}
								</a>	
							@endif					
						</div>
					</div>
					<!--------------------row--8--------------------------->
					<hr><!---------------divider--------------------------->
					
					<!--------------------row--9--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label class="input-required">	{{ Lang::get('Bank Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="bank_name" 
								value="{{$InvPrfMod->bank_name}}" 
								class="form-control" required>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Bank Code') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="bank_code" 
								value="{{$InvPrfMod->bank_code}}" 
								class="form-control" required>
						</div>						
					</div>
					<!--------------------row--9--------------------------->
					
					<!--------------------row--10--------------------------->
					<div class="row">						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Branch Code') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="branch_code" 
								value="{{$InvPrfMod->branch_code}}" 
								class="form-control" required>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">	{{ Lang::get('Bank Account Number') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="bank_account_number" 
								value="{{$InvPrfMod->bank_account_number}}" 
								class="form-control text-right" required>
						</div>
					</div>
					<!--------------------row--10--------------------------->
				
			</fieldset>	
		</div><!-----panel---> 
	</div><!---tab--pane--->
