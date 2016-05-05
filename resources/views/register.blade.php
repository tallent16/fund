@extends ('layouts.plane')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/passwordstrength.js') }}" type="text/javascript"></script>	  
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	  
	<script src="{{ url('js/register.js') }}" type="text/javascript"></script>	  

@endsection
@section ('body')
<!-- Register Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-7 register-style">		
            <!-- Register Block -->
            <div class="block block-themed">
				<div class="row header-register">
					<div class="block-header">	
						<div class="row">
							<div class="col-md-3">
								<h5 class="block-title">
									{{ Lang::get('register.register') }}
								</h5>
							</div> 
							<div class="col-md-9 text-right"> 
								<a href="{{'auth/login'}}">
									{{ Lang::get('register.back2login') }}
								</a> 
							</div>
						</div>
					</div>      
				</div>                            
            </div>
            <div class="row col-md-offset-3"> 
				<a class="navbar-brand" href="{{ url ('') }}">
					{{ Html::image('img/LOGO.jpg') }}
				</a> 
			</div>
            <div class="block-content block-content-full block-content-narrow">                    
                  <br>
					<form 	id="form-register" method="post" action="{{ url('submit_registration')}}"
							class="js-validation-register push-20-t push-20" 
							novalidate="novalidate">
							<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
							
						<div class="row">
							<div class="form-group col-xs-12">								
								<label for="example-inline-radio2" class="radio-inline">
									<input checked="checked" name="Userrole" type="radio" value="Investor" />                                    
									{{ Lang::get('register.investor') }}
								</label>
								<label for="example-inline-radio1" class="radio-inline">
									<input id="Userrole" name="Userrole" type="radio" value="Borrower" />                                    
								   {{ Lang::get('register.borrower') }}
								</label>								
							</div>
						</div>						
						<!---row1--->
						<div class="row">
							<div class="col-xs-6 form-group">
								<div class="form-material form-material-success">
									<label 	for="register-username"> {{ Lang::get('User Name') }}</label>
									<input 	class="form-control" 
											id="username"
											name="username" 
											placeholder="User Name" 
											type="text" 
											data-val="true"
											data-val-required="Please enter an Username"
											data-val-remote="Username already registered. Please enter a different Username"
											value="" />
									</div>
							</div>
						
							<div class="col-xs-6 form-group">									
								<div class="form-material form-material-success">
									<label 	for="register-email"> {{ Lang::get('login.email') }}</label>
									<input 	class="form-control" 
											data-val="true" data-val-regex="* Please enter a valid e-mail adress" 
											data-val-regex-pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" 
											data-val-remote="* Email already registered. Please enter a different email." 
											data-val-remote-additionalfields="*.EmailAddress" 
											data-val-remote-type="POST" 
											data-val-remote-url="/Authentication/User/CheckEmailavailability"
											data-val-required="* E-mail Id is required" 
											id="EmailAddress" 
											name="EmailAddress" 
											placeholder="Email" 
											type="text" value="" />
								</div>									
							</div>
						</div>
					<!---row2--->	
					<div class="row">
						<div class="col-xs-6 form-group">					
							<label 	for="register-firstname"> {{ Lang::get('First Name') }}</label>
								<input 	class="form-control" 
									id="firstname"
									name="firstname" 
									placeholder="First Name" 
									type="text" 
									value="" />
						</div>
							
						<div class="col-xs-6 form-group">
							<label 	for="register-lastname"> {{ Lang::get('Last Name') }}</label>
							<input 	class="form-control" 
									id="lastname"
									name="lastname" 
									placeholder="Last Name" 
									type="text" 
									value="" />
						</div>
					</div>
					<!---row3---->	
					<div class="row">
						<div class="col-xs-6 form-group">						
							<div class="form-material form-material-success">
								<label for="register-password">{{ Lang::get('login.password') }}</label>
								<input 	class="form-control" 
										data-val="true"
										data-val-remote="* Email and Password must not be same" 
										data-val-remote-additionalfields="*.Password,*.EmailAddress" 
										data-val-remote-type="POST" 
										data-val-remote-url="/Authentication/User/CheckEmailPasswordMatchcase" 
										data-val-required="* Password is required" 
										id="password"
										name="password" 
										placeholder="******" 
										type="Password" 
										value="" />
								<div id="messages"></div>
							</div>
						</div>	
						<div class="col-xs-6 form-group">
							<div class="form-material form-material-success">
								<label for="register-password2">{{ Lang::get('register.confirmpass') }}</label>
								<input 	class="form-control" 
										data-val="true" 
										data-val-equalto="* The password and confirmation password do not match." 
										data-val-equalto-other="*.Password" 
										data-val-required="* Confirmation Password is required" 
										id="ConfirmPassword" 
										name="ConfirmPassword" 
										placeholder="******" 
										type="Password" 
										value="" />
							</div>
						</div>  
					                     
							<div class="progress progress-striped active">
								<div 	id="jak_pstrength" 
										class="progress-bar" 
										role="progressbar" 
										aria-valuenow="0" 
										aria-valuemin="0" 
										aria-valuemax="100" 
										style="width: 0%;">
								</div>
							</div>
						</div> 				
					 <!---row4---->	                     
					<div class="row">
						<div class="col-xs-6 form-group">	
							<div class="form-material">
								<label for="example-select">{{ Lang::get('register.secuirtyquestion') }}</label>
								<select class="form-control" 
										data-val="true" 
										data-val-number="The field SecurityQuestion1 must be a number." 
										data-val-required="The SecurityQuestion1 field is required." 
										id="SecurityQuestion1" 
										name="SecurityQuestion1" >
										<option value="">--{{ Lang::get('register.select') }}--</option>
										<option value="1">{{ Lang::get('register.cityborn') }}</option>
										<option value="2">{{ Lang::get('register.petname') }}</option>
										<option value="3">{{ Lang::get('register.mothername') }}</option>
										<option value="4">{{ Lang::get('register.fathername') }}</option>
										<option value="5">{{ Lang::get('register.firstcar') }}</option>
										<option value="6">{{ Lang::get('register.favcolour') }}</option>
										<option value="7">{{ Lang::get('register.spousebirthday') }}</option>
										<option value="8">{{ Lang::get('register.favsport') }}</option>
										<option value="9">{{ Lang::get('register.vehiclenum') }}</option>
										<option value="10">{{ Lang::get('register.bestfriend') }}</option>
										<option value="12">{{ Lang::get('register.favactor') }}</option>
										<option value="13">{{ Lang::get('register.primaryschool') }}</option>
										<option value="14">{{ Lang::get('register.favmovie') }}</option>
								</select>
							</div>
						</div>
						<div class="col-xs-6 form-group">
							<div class="form-material">
								<label for="example-select" class="col-xs-12">&nbsp;</label>
								<input 	class="form-control" 
										data-val="true" 
										data-val-required="* Question Answer is required." 
										id="SecurityQuestionAnswer1" 
										name="SecurityQuestionAnswer1" 
										placeholder="{{ Lang::get('register.secuirtyanswer') }}" 
										type="text" 
										value="" />
							</div>
						</div>
					</div>
					 <!---row4---->	
					<div class="row">
						<div class="col-xs-12 form-group">
							<label class="css-input switch switch-sm switch-success">
								{{ Lang::get('register.logging') }} 
								<a target="_blank" href="">
								   {{ Lang::get('register.termsissuer') }}
								</a>,
								<a target="_blank" href="">
									{{ Lang::get('register.termspayee') }}
								</a>,
								<a target="_blank" href="">
									{{ Lang::get('register.codeconduct') }}
								</a>
								and 
								<a target="_blank" href="">
									{{ Lang::get('register.privacy') }}
								</a>
							</label>
						</div>
					</div>
					 <!---row5---->	
					<div class="row">
						<div class="col-xs-12 form-group">
							<button id="reg-submit-btn" 
									type="submit" 
									class="btn btn-success register-button">
									<i class="fa pull-right"></i> 
									{{ Lang::get('register.signup') }}
							</button>
						</div>
					</div>
					<input 	data-val="true" 
							data-val-required="The PrivateReferral field is required." 
							id="PrivateReferral" 
							name="PrivateReferral" 
							type="hidden" 
							value="False" />
                    </form>                    
   
                    <!-- END Register Form -->
               <!-- </div>-->
            </div>
            <!-- END Register Block -->
        </div>
    </div>
</div>
<!-- END Register Content -->
@endsection
@stop
