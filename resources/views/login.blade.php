@extends ('layouts.plane')
@section ('body')
	<div class="container">       
		<div class="row">
			
			<div>&nbsp;</div>
			@if(session()->has('submit'))
			<div class="alert alert-success col-md-4 col-md-offset-4">
				{{session()->get('submit')}}
			</div>
			@endif			
			
            <div class="col-md-4 col-md-offset-4 register-style">	
				
				<div class="row header-register">
					<div class="col-md-3"><h5 class="block-title">{{ Lang::get('login.login') }}</h5></div>  
					<div class="col-md-9 text-right"> <a href="{{ url ('register') }}">{{ Lang::get('login.back2register') }}</a></div>
				</div>	  
				
				<div class="row col-md-offset-2">
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
                
				{{session()->forget('submit')}}
				
               @section ('login_panel_title',Lang::get('login.pleasesignin'))
               @section ('login_panel_body')
				<form class="form" role="form" method="POST" action="<?=URL::to('/auth/login'); ?>"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<fieldset>
						<div class="form-group">
							<input class="form-control" placeholder="{{ Lang::get('Email or Username')  }}" 
							name="email" type="text" autofocus>
						</div>
						<div class="form-group">
							<input class="form-control" placeholder="{{ Lang::get('login.password') }}" 
							name="password" type="password" value="">
							<div class="text-right">
								{{ Lang::get('Forgot or Change')}} <a href="{{ url ('reset') }}">{{ Lang::get('Password')}}</a>?
							</div>
						</div>
						<div class="checkbox">							
								<label>
									<input name="remember" type="checkbox" 
									value="Remember Me">{{ Lang::get('login.remember') }}
								</label>
						</div>
						<!-- Change this to a button or input when using this as a form -->
					  <!--  <a href="{{ url ('') }}" class="btn btn-lg btn-success btn-block">Login</a> -->
					  <button type="submit" class="login-button btn btn-primary  btn-lg btn-success btn-block"
								style="margin-right: 15px;">
							{{ Lang::get('login.login') }}
					   </button>
					</fieldset>
				</form>
                   
                @endsection
                @include('widgets.panel', array('as'=>'login', 'header'=>true))
            </div>
        </div>
    </div>
@stop
