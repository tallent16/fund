@extends ('layouts.plane')
@section ('body')
	<div class="container">       
		<div class="row">
			
			<div class="col-md-6 col-md-offset-3 register-style">
				<div class="row header-register">
						FORGOT PASSWORD
				</div>
				
				<div class="row col-md-offset-3">
					<a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a> 
				</div>
				
				<form class="form-vertical" role="form" method="POST" action="<?=URL::to('forgot'); ?>"> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<fieldset>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4" for="pwd">Security Question</label>
								<div class="col-sm-8"> 
									<input type="text" class="form-control" id="pwd" placeholder="Security Question" disabled>
								</div>
							</div>
							<div class="col-sm-12 form-group">
								<label class="control-label col-sm-4">Answer</label>
								<div class="col-sm-8"> 
									<input type="text" class="form-control" id="pwd" placeholder="Answer">
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
