@extends ('layouts.plane')
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
				
				<form class="form-vertical" role="form" method="POST" action="<?=URL::to('forgot'); ?>"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<fieldset>
						
							<div class="form-group col-xs-6">								
								<label for="example-inline-radio2" class="radio-inline">
									<input checked="checked" name="Userrole" type="radio" value="Forgot Password" />                                    
									{{ Lang::get('Forgot Password') }}
								</label>
							</div>
							
							<div class="form-group col-xs-6">	
								<label for="example-inline-radio1" class="radio-inline">
									<input id="Userrole" name="Userrole" type="radio" value="Change Password" />                                    
								   {{ Lang::get('Change Password') }}
								</label>								
							</div>
							
							<div>&nbsp;</div>
							<div class="col-sm-12 form-group">
									<label 	for="register-email" class="col-sm-2"> {{ Lang::get('Email-ID') }}</label>
								<div class="col-sm-10">
									<input 	class="form-control" 											
											id="EmailAddress" 
											name="EmailAddress" 
											placeholder="Email Address" 
											type="text" value="" />
								</div>							
							</div>
							
							<div class="col-sm-2 form-group col-sm-offset-5">
								 <button type="submit" class="login-button btn btn-primary   btn-success btn-block"
									style="margin-right: 15px;">
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
