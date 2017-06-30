@extends ('layouts.plane')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />	
	<style>

	</style>
@endsection 
@section('body')	
@include('header',array('class'=>'',)) 

	<div class="container-fluid" style="margin-top:120px;margin-bottom:120px;">       
		<div class="row">
			
			<div>&nbsp;</div>
			@if(session()->has('submit'))
			<div class="alert alert-success col-md-4 col-md-offset-4">
				{{session()->get('submit')}}
			</div>
			@endif	
			
			@if(session()->has('verified'))
			<div class="alert alert-success col-md-4 col-md-offset-4 text-center">
				{{session()->get('verified')}}
			</div>
			@endif	
					
			@if(session()->has('activation'))
			<div class="alert alert-info col-md-4 col-md-offset-4 text-center">
				{{session()->get('activation')}}
			</div>
			@endif
			 <div class="col-md-5 col-md-offset-4 register-style">	
				 You can login to our demo system by using the following information:
				 <div class="row">
					 <div class="col-md-12">
						<b style=" text-decoration: underline;">Project Creator</b>
					</div>	
					<div class="col-md-6">
						<span> Username: Creator100@gmail.com</span>
						<span> Password: Letmein12345!</span>
					</div>
				 </div>
				 <div class="row">
					 <div class="col-md-12">
						<b style=" text-decoration: underline;">Backer</b>
					</div>	
					<div class="col-md-6">
						<span> Username: backer500@gmail.com</span>
						<span>Password: Letmein12345!</span>
					</div>
				 </div>
			</div>
            <div class="col-md-4 col-md-offset-4 register-style">	
				
<!--
				<div class="row header-register">
					<div class="col-md-3"><h5 class="block-title">{{ Lang::get('login.login') }}</h5></div>  
					<div class="col-md-9 text-right"> <a href="{{ url ('register') }}">{{ Lang::get('login.back2register') }}</a></div>
				</div>	  
-->
				
<!--
				<div class="row col-md-offset-2">
					<a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a> 
				</div>
-->
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
				
               @section ('login_panel_title',Lang::get('login.sign_in'))
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
							<div class="text-right" style="font-size:85%">
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
					  <button type="submit" class="login-button btn btn-primary btn-success btn-block"
								style="margin-right: 15px;">
							{{ Lang::get('login.login') }}
					   </button>
					</fieldset>
				</form>
                   &nbsp;
                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="{{ url ('register') }}">
                                            Sign Up Here
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                @endsection
                @include('widgets.panel', array('as'=>'login', 'header'=>true))
            </div>
            <div class="col-md-5 col-md-offset-4 register-style">	
				<span>This is a demo system. Data will be deleted at the end of the day.</span> 
			</div>	 
			
        </div>
    </div>
    
    

    
    
    
    
@include('footer',array('class'=>'',))
@endsection  
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@stop
