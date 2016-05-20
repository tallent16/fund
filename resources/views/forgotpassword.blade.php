@extends ('layouts.plane')
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
               
				
				<form class="form-vertical" role="form" method="POST" action=""> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="userid" value="{{$modelresetpass->userid}}">
					<fieldset>
							<div class="col-sm-12 form-group" {{$forgotpassdisabled}}>
								<label class="control-label col-sm-4" for="pwd">Security Question</label>
								<div class="col-sm-8"> 
									<input type="text" name="secretquestion" value="{{$modelresetpass->secretquestion}}" class="form-control" id="pwd" placeholder="Security Question" disabled>
								</div>
							</div>
							<div class="col-sm-12 form-group" {{$forgotpassdisabled}}>
								<label class="control-label col-sm-4">Answer</label>
								<div class="col-sm-8"> 
									<input type="text" name="secretanswer" class="form-control" id="pwd" placeholder="Answer">
								</div>
							</div>
						
							<div class="col-sm-12 form-group" {{$changepassdisabled}}>
								<label class="control-label col-sm-4" for="pwd">Old Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="Old password" name="oldpassword">
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">New Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="New password" name="newpassword" >
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">Confirm 
								Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="Confirm New password" name="confirmpassword">
								</div>
							</div>
							<div class="col-sm-12 form-group col-sm-offset-6">
								 <button type="submit" class="login-button btn btn-primary   btn-success"
									>
								{{ Lang::get('Confirm') }}
								</button>
								 <button type="button" class="login-button btn btn-primary   btn-success"
									>
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
