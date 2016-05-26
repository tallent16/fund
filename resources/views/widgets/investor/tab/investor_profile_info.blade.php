	<div id="inv_profile_info" class="tab-pane fade in active">  	
		<div class="panel-body applyloan table-border-custom input-space">
			<fieldset {{$InvPrfMod->viewStatus}} >
					<!--------------------row--1--------------------------->				
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('First Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="firstname" 
								value="{{$InvPrfMod->firstname}}" 
								class="form-control">
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label>	{{ Lang::get('Last Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="lastname" 
								value="{{$InvPrfMod->lastname}}" 
								class="form-control">
						</div>						
					</div>
					<!--------------------row--1--------------------------->
					
					<!--------------------row--2--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('Display Name') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
							<input type="text" 
									name="displayname" 
									id="displayname" 
									value="{{$InvPrfMod->displayname}}" 
									onchange="checkDisplayName(this.value);"
									class="form-control">
							<label 	style="display: none;" 
									class="control-label label_displayname_error" 
									></label>
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('Email') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
							<input type="text" 
									name="email" 
									id="email" 
									value="{{$InvPrfMod->email}}" 
									onchange="checkEmail(this.value);"
									class="form-control">
							<label 	style="display: none;" 
									class="control-label label_email_error" 
									></label>
						</div>						
					</div>
					<!--------------------row--2--------------------------->
					
					<!--------------------row--3--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label>	{{ Lang::get('Mobile Number') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="mobile" 
								value="{{$InvPrfMod->mobile}}" class="form-control">
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">									
							<label>	{{ Lang::get('Date of Birth') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
							<div class="controls">
								<div class="input-group">
									<input 	type="text" 
											id="date_of_birth"  
											name="date_of_birth" 
											value="{{$InvPrfMod->date_of_birth}}"
											class="date-picker-2 form-control"
											readonly />	
									<label class="input-group-addon btn" for="date_of_birth">
										<span class="glyphicon glyphicon-calendar"></span>
									</label>
								</div>													
							</div>
						</div>
					</div>
					<!--------------------row--3--------------------------->
					
					<!--------------------row--4--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('NRIC Number') }}</label>												
						</div>
											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="nric_number" 
								value="{{$InvPrfMod->nric_number}}" class="form-control text-right">
						</div>
					</div>	
					<!--------------------row--4--------------------------->
					
					<hr><!---------------divider--------------------------->
					
					<!--------------------row--5--------------------------->
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">										
							<label>	{{ Lang::get('Bank Name') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">													
								<input type="text" name="bank_name" 
								value="{{$InvPrfMod->bank_name}}" class="form-control">
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('Bank Code') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="bank_code" 
								value="{{$InvPrfMod->bank_code}}" class="form-control">
						</div>						
					</div>
					<!--------------------row--5--------------------------->
					
					<!--------------------row--6--------------------------->
					<div class="row">						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('Branch Code') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="branch_code" 
								value="{{$InvPrfMod->branch_code}}" class="form-control">
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>	{{ Lang::get('Bank Account Number') }}</label>												
						</div>											
						<div class="col-xs-12 col-sm-7 col-lg-3">												
								<input type="text" name="bank_account_number" 
								value="{{$InvPrfMod->bank_account_number}}" class="form-control text-right">
						</div>
					</div>
					<!--------------------row--6--------------------------->
				
			</fieldset>	
		</div><!-----panel---> 
	</div><!---tab--pane--->
