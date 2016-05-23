@extends ('layouts.plane')
@section('bottomscripts') 
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script src="{{ url('js/passwordstrength.js') }}" type="text/javascript"></script>	  
<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	  
<script src="{{ url('js/resetpassword.js') }}" type="text/javascript"></script>	  
@endsection
@section ('body')
	<div class="container">       
		<div class="row">
			 @var $secretQuestion = $modelresetpass;
				@var $disabled_fun 			= ""
				@var $changepassdisabled 	= ""		
				@if($modelresetpass->typepassword == "Change Password")
										
						@var $changepassdisabled = ""	
						@var $forgotpassdisabled = 'style="display:none"'
				@else
						@var $forgotpassdisabled = ""
						@var $changepassdisabled = 'style="display:none"'
				@endif	
			<div class="col-md-6 col-md-offset-3 register-style">
				<div class="row header-register">
					@if($modelresetpass->typepassword == "Change Password")
						CHANGE PASSWORD
					@else
						FORGOT PASSWORD
					@endif		
				</div>
				
				<div class="row col-md-offset-3">
					<a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a> 
				</div>
				@if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>{{ Lang::get('login.Whoops') }}!</strong> {{ Lang::get('login.Whoopsmsg') }}<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li> 
                            @endforeach
                        </ul>
                    </div>
                @endif
               
				
				<form class="form-vertical" role="form" method="POST" id="resetpassword" action="<?=URL::to('submitpassword'); ?>"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}" id="hidden_token">
					<input type="hidden" name="userid" value="{{$modelresetpass->userId}}">
					<input type="hidden" name="passwordtype" value="{{$modelresetpass->typepassword}}">
					<input name="submit_count" type="hidden" value="submitted" />  
					<fieldset>
							<div class="col-sm-12 form-group" {{$forgotpassdisabled}}>
								<label class="control-label col-sm-4" for="pwd">Security Question</label>
								<div class="col-sm-8"> 
									<input type="text" 
											name="secretquestion" 
											value="{{$modelresetpass->secretquestion}}" 
											class="form-control" 
											id="question" 
											placeholder="Security Question" disabled>
								</div>
							</div>
							<div class="col-sm-12 form-group" {{$forgotpassdisabled}}>
								<label class="control-label col-sm-4">Answer</label>
								<div class="col-sm-8"> 
									<input type="text" 
											name="secretanswer" 
											class="form-control" 
											id="answer" 
											placeholder="Answer" required>
								</div>
							</div>
						
							<div class="col-sm-12 form-group" {{$changepassdisabled}}>
								<label class="control-label col-sm-4" for="pwd">Old Password</label>
								<div class="col-sm-8"> 
									<input type="password" 
											class="form-control" 
											id="pwd" 
											placeholder="Old password" 
											name="oldpassword" required>
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">New Password</label>
								<div class="col-sm-8"> 
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
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">Confirm 
								Password</label>
								<div class="col-sm-8"> 
									<input type="password" 
											class="form-control" 
											id="ConfirmPassword" 
											placeholder="Confirm New password" 
											name="ConfirmPassword" required>								
								</div><div id="errMsg"></div>
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
							<div class="col-sm-12 form-group col-sm-offset-6">
								 <button type="submit" class="login-button btn btn-primary   btn-success" id="confirm-button">
								{{ Lang::get('Confirm') }}
								</button>
								 <button type="button" class="login-button btn btn-primary   btn-success" onClick="document.location.href='/reset'">
								{{ Lang::get('Cancel') }}
								</button>
							</div>
							
						<div>&nbsp;</div>
					    
					</fieldset>
				</form>
			</div>
			
			
		 </div>
    </div>
@stop
