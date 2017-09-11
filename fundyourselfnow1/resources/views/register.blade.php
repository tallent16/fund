@inject('countries', 'App\Http\Utilities\Country')
@extends ('layouts.plane')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />	
@endsection 
@section('bottomscripts') 
	<!--<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>-->
	<script src="{{ url('js/passwordstrength.js') }}" type="text/javascript"></script>	  
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	  
	<script>		
		var systemSettings					=	{{json_encode($regMod->systemAllSetting)}}
		var systemMessages					=	{{json_encode($regMod->systemAllMessage[1])}}
	</script>
 
	<?php  
	 if(config::get('app.locale') != ''){
         $lang = config::get('app.locale');

   }else{
   $lang = 'en';

   }  
     $validation = "js/validation/register_".$lang.".js"; 
   ?>
<script src="{{ url($validation) }}" type="text/javascript"></script>	  
	<script src="{{ url('js/register.js') }}" type="text/javascript"></script>	  

@endsection
@section ('body')
@include('header',array('class'=>'',)) 
<!-- Register Content -->
<div class="container-fluid"  style="margin-top:120px;margin-bottom:120px;">   
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-6 register-style">		
            <!-- Register Block -->
<!--
            <div class="block block-themed">
				<div class="row header-register">
					<div class="block-header">	
						<div class="row">
							<div class="col-md-3">
								<h5 class="block-title">
									{{ Lang::get('Sign up') }}
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
-->
<!--
            <div class="row col-md-offset-3"> 
				<a class="navbar-brand" href="{{ url ('') }}">
					{{ Html::image('img/LOGO.jpg') }}
				</a> 
			</div>
-->

<div class="panel panel-default">
	  
		<div class="panel-heading">
		<h3 class="panel-title">  {{ Lang::get('register.signup') }}</h3>
	
	</div>
		
	<div class="panel-body">
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
									{{ Lang::get('register.backer') }}
								</label>
								<label for="example-inline-radio1" class="radio-inline">
									<input id="Userrole" name="Userrole" type="radio" value="Borrower" />                                    
								   {{ Lang::get('register.creator') }}
								</label>								
							</div>
						</div>						
					
						<div class="row">
							<div class="col-xs-6 form-group">
								<div class="form-material form-material-success">
									<label 	for="register-username" class="input-required"> {{ Lang::get('register.username') }}</label>
									<input 	class="form-control" 
											id="username"
											name="username" 
											placeholder=" {{ Lang::get('register.username') }}" 
											type="text" 
											data-val="true"
											data-val-required="Please enter Username"
											data-val-remote="Username already registered. Please enter a different Username"
											value="" />
									</div>
							</div>
						
							<div class="col-xs-6 form-group">									
								<div class="form-material form-material-success">
									<label 	for="register-email" class="input-required"> {{ Lang::get('register.email') }}</label>
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
											placeholder="{{ Lang::get('register.email') }}" 
											type="text" value="" />
								</div>									
							</div>
						</div>
					
					<div class="row">
						<div class="col-xs-6 form-group">
							<div class="form-material form-material-success">					
								<label 	for="register-firstname" class="input-required"> {{ Lang::get('register.firstname') }}</label>
									<input 	class="form-control" 
										id="firstname"
										name="firstname" 
										placeholder="{{ Lang::get('register.firstname') }}" 
										type="text" 
										value="" />
							</div>
						</div>
							
						<div class="col-xs-6 form-group">
							<div class="form-material form-material-success">	
								<label 	for="register-lastname" class="input-required"> {{ Lang::get('register.lastname') }}</label>
								<input 	class="form-control" 
										id="lastname"
										name="lastname" 
										placeholder="{{ Lang::get('register.lastname') }}" 
										type="text" 
										value="" />
							</div>
						</div>
					</div>
					<!---row3---->	
					<div class="row">
						<div class="col-xs-6 form-group pass">						
							<div class="form-material form-material-success">
								<label for="register-password" class="input-required">{{ Lang::get('register.password') }}</label>
								<input 	class="form-control" 
										
										id="password"
										name="password" 
										placeholder="******" 
										type="Password" 
										value="" />
										<div id="Password-error1" style=" color: #a94442;"></div>
								<div id="messages"></div>
							</div>
						</div>	
						<div class="col-xs-6 form-group cpass">
							<div class="form-material form-material-success">
								<label for="register-password2" class="input-required">{{ Lang::get('register.confirmpass') }}</label>
								<input 	class="form-control" 
										id="ConfirmPassword" 
										name="ConfirmPassword" 
										placeholder="******" 
										type="Password" 
										value="" />
										<div id="CPassword-error1" style=" color: #a94442;"></div>
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
						<div class="col-xs-6 form-group ques">	
							<div class="form-material">
								<label for="example-select" class="input-required">{{ Lang::get('register.secuirtyquestion') }}</label>
								<select class="selectpicker customeselect"  
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
								<div id="SecurityQuestion1-error" style=" color: #a94442;"></div>
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

                   <div class="row">
						<div class="col-xs-6 form-group">
                          <div class="form-material">
                          <label 	for="register-lastname" class="input-required"> {{ Lang::get('register.nationality') }}</label>
					<select id="country" name="country" class="form-control">
				<option value = "">Please select </option>
                    @foreach ($countries as $country)

                        <option value="{{ $country->id }}" <?php if($country->code==$usercountry){ echo "selected"; }?>>{{ $country->name }}</option>
                    @endforeach             
                </select>
                </div>
					</div>
						</div>
					 <!---row4---->	
					<div class="row">
						<div class="col-xs-12 form-group">
							<label class="css-input switch switch-sm switch-success">
								{{ Lang::get('register.bound_to') }} 
<!--
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
-->
							</label>
						</div>
					</div>
					 <!---row5---->	
					<div class="row">
						<div class="col-xs-12 form-group">
							<button id="reg-submit-btn" 
									type="button" 
									class="btn btn-success register-button">
									<i class="fa pull-right"></i> 
									{{ Lang::get('register.signup') }}
							</button> <a href="{{ url ('auth/login') }}">{{ Lang::get('register.sign_in') }}</a>
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
    </div>
</div>
@section ('popup-box_panel_title',Lang::get('Terms & Conditions'))
	@section ('popup-box_panel_body')
			@include('widgets.modal_box.toc_message')
	@endsection
	@section ('popup-box_panel_footer')
		
	<div class='row space-around'>
		<div class='col-sm-12'>
			<div class='text-left'>
				<input 	type='checkbox' 
						name='read_toc_message' 
						id='read_toc_message' 
						value='1' > I have read the terms and conditions and agree to abide by it.
			</div>
			<div class='text-right'>
				<input 	type='button' 
						class='btn verification-button yellow_btn' 
						name='toc_message_submit' 
						id='toc_message_submit' 
						value='Submit' 
						disabled
						>
						<input 	type='button' 
						class='btn verification-button' 
						name='toc_message_dismiss' 
						id='toc_message_dismiss' 
						value='Dismiss' 
						data-dismiss='modal'>

			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'toc_information',
												'aria_labelledby'=>'toc_information',
												'as'=>'popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))
<!-- END Register Content -->
<footer class="footer">
@include('footer')

</footer>
@endsection

@stop
