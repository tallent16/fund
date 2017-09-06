@extends('layouts.plane')

@section('page_heading',Lang::get('Crowd Funding'))  
@section('body')	   

@if(session()->has('success'))
	@include('partials/error', ['type' => 'success', 'message' => session('success')])
@endif
@if(session()->has('failure'))

	@include('partials/error', ['type' => 'failure', 'message' => session('failure')])
@endif	 
@include('header',array('class'=>'',))

	<div class="inner_page">
	<!-- start login area here -->
		<section class="form_area">
			<div class="container">
                               <div>&nbsp;</div>
			@if(session()->has('submit'))
			<div class="alert alert-success col-md-4 col-md-offset-4">
				{{session()->get('submit')}}
			</div>
			@endif	
			
			@if(session()->has('verified'))
			<div class="alert alert-success col-md-12 col-md-offset-12 text-center" style="margin:0px !important;">
				{{session()->get('verified')}}
			</div>
			@endif	
					
			@if(session()->has('activation'))
			<div class="alert alert-info col-md-4 col-md-offset-4 text-center">
				{{session()->get('activation')}}
			</div>
			@endif
				<div class="form_innerarea">
					<p>You can login to our demo system by using the following information:<br/>
						<b>Project Creator</b><br/>
						Username: Creator100@gmail.com Password: Letmein12345!<br/>
						<b>Backer</b><br/>
						Username: backer500@gmail.com Password: Letmein12345!
					</p>

					<div class="panel panel-default">
						<div class="panel-heading">

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
							<h3 class="panel-title">Sign In</h3>
						</div>

						<div class="panel-body">

							<form class="form" role="form" method="POST" action="<?=URL::to('/auth/login'); ?>"> 
                                                                 <input type="hidden" name="_token" value="{{ csrf_token() }}">
								<fieldset>
									<div class="form-group">
										<input class="form-control" placeholder="Email or Username" name="email" autofocus="" type="text">
									</div>
									<div class="form-group">
										<input class="form-control" placeholder="Password" name="password" value="" type="password">
										<div class="text-right" style="font-size:85%">
											Forgot or Change <a href="{{ url ('reset') }}">Password</a>?
										</div>
									</div>
									<div class="checkbox">							
											<label>
												<input name="remember" value="Remember Me" type="checkbox">{{ Lang::get('login.remember') }}
											</label>
									</div>
									<button type="submit" class="btn btn-block full_orange_btn animated_slow">Login</button>
								</fieldset>
							</form>
					        <p class="dont_account">Don't have an account! <a href="{{ url ('register') }}">Sign Up Here</a> </p>    
					    </div>
					</div>

					<p>This is a demo system. Data will be deleted at the end of the day.</p>
					
				</div>
			</div>
		</section>
	<!-- end login area here -->
</div>
    
    

    
    
    
    
<footer class="footer">
@include('footer')

</footer>
@endsection
@stop
