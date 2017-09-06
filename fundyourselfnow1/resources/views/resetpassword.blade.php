@extends ('layouts.plane')
@section('bottomscripts') 
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script src="{{ url('js/passwordstrength.js') }}" type="text/javascript"></script>	  
<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	
<script>var baseUrl	="{{url('')}}"</script>  
<script src="{{ url('js/resetpassword.js') }}" type="text/javascript"></script>	  
@endsection
@section ('body')
	<div class="container">       
		<div class="row">
			
			<div class="col-md-6 col-md-offset-3 register-style">
				<div class="row header-register">
						RESET PASSWORD
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
				<form class="form-vertical" id="resetpassword" role="form" method="POST" action="<?=URL::to('forgot'); ?>" name="resetpassword"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}" id="hidden_token">
					<fieldset>
						
							<div class="form-group col-xs-6">								
								<label for="example-inline-radio2" class="radio-inline">
									<input checked="checked" name="passwordtype" type="radio" value="Forgot Password" />                                    
									{{ Lang::get('Forgot Password') }}
								</label>
							</div>
							
							<div class="form-group col-xs-6">	
								<label for="example-inline-radio1" class="radio-inline">
									<input id="Userrole" name="passwordtype" type="radio" value="Change Password" />                                    
								   {{ Lang::get('Change Password') }}
								</label>								
							</div>
							
							<div>&nbsp;</div>
							<div class="col-sm-12 form-group">
									<label 	for="register-email" class="col-sm-2"> {{ Lang::get('Email-ID') }}</label>
								<div class="col-sm-10">
									<input 	class="form-control" 
											data-val="true" data-val-regex="* Please enter a valid e-mail adress" 
											data-val-regex-pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}" 
											data-val-remote="* Email already registered. Please enter a different email." 
											data-val-remote-additionalfields="*.EmailAddress" 
											data-val-remote-type="POST" 
											data-val-remote-url="/Authentication/User/CheckEmailavailable"
											data-val-required="* E-mail Id is required" 
											id="EmailAddress" 
											name="EmailAddress" 
											placeholder="Email" 
											type="text" value="" required>
								</div>							
							</div>
							
							<div class="col-sm-2 form-group col-sm-offset-5">
								 <button 	type="submit"
											class="login-button btn btn-primary   btn-success btn-block" 
											id="next_button"
									>
								{{ Lang::get('Next') }}
								</button>
							</div>
						<div>&nbsp;</div>
					    
					</fieldset>
				</form>
			</div>			
			
		 </div>
    </div>
@stop
