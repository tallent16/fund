@extends ('layouts.plane')
@section ('body')
	<div class="container">       
		<div class="row">
			
			<div class="col-md-6 col-md-offset-3 register-style">
				<div class="row header-register">
						SET NEW PASSWORD
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
				<form class="form-vertical" role="form" method="POST" action="<?=URL::to(''); ?>"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<fieldset>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">Old Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="Old password" disabled>
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">New Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="New password" >
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">Confirm 
								Password</label>
								<div class="col-sm-8"> 
									<input type="password" class="form-control" id="pwd" placeholder="Confirm New password" >
								</div>
							</div>
							<div class="col-sm-12 form-group col-sm-offset-6">
								 <button type="submit" class="login-button btn btn-primary   btn-success"
									>
								{{ Lang::get('Confirm') }}
								</button>
								 <button type="submit" class="login-button btn btn-primary   btn-success"
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
