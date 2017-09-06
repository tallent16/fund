@extends('layouts.dashboard_admin')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/passwordstrength.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/admin-change-password.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Change Password') )
@section('section')  


<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container" id="change-password">
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Enter the Change Password')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
			
			<form method="post" id="form-change-password">
				<input  type="hidden" 
						name="_token"
						id="hidden_token"
						value="{{ csrf_token() }}" />
				<input  type="hidden" 
						name="userType"
						value="{{$adminChanPassMod->userType}}" />	
				<input  type="hidden" 
						name="selected_user_id" 
						value="{{$adminChanPassMod->user_id}}"/>	
			
				<div class="row"><!-- Row 2 -->				
					<div class="col-xs-12 col-sm-5 col-lg-4">
						<label>
							{{ Lang::get('Enter your Password') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-5 col-lg-3 form-group">
						<div class="form-material form-material-success">
							<input 	id="current_user_password" 
									type="password" 
									class="form-control" 
									name="current_user_password"									
									value="" 
									/>
						</div>
					</div>
				</div> <!-- Row 2 -->
				
				<div class="row"><!-- Row 3 -->				
					<div class="col-xs-12 col-sm-5 col-lg-4">
						<label>
							{{ Lang::get('Enter New Password for ') }}
							<strong>{{$adminChanPassMod->selected_user_name}}</strong>
						</label>
					</div>	
					<div class="col-xs-12 col-sm-5 col-lg-3  form-group">	
						<div class="form-material form-material-success">				
							<input 	id="new_password" 
									data-val	="true"
									type="password" 
									class="form-control" 
									name="new_password"	
									value="" />			
						</div>			
					</div>
				</div> <!-- Row 3 -->
							
				
				<div class="row"><!-- Row 4 -->				
					<div class="col-xs-12 col-sm-5 col-lg-4">
						<label>
							{{ Lang::get('Confirm Password') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-5 col-lg-3 form-group"  id="trans_ref_parent">	
						<div class="form-material form-material-success">					
							<input 	id="confirm_password" 
									type="password" 
									class="form-control " 
									name="confirm_password"									
									value="" 
									  />	
						</div>					
					</div>
				</div> <!-- Row 4 -->
				
				<div class="row">
					<div class="col-lg-12 space-around">
						<div class="form-group">
							<button class="btn verification-button"
									id="change_password_button">
									{{ Lang::get('Change Password')}}
							</button>
							<button class="btn verification-button" 
									type ="button"
									data-action="{{$adminChanPassMod->returnBackUrl}}"
									id="cancel_button" >
								{{ Lang::get('Cancel')}}
							</button>
						</div>
					</div>
				</div>			
		</div>
		
	</div>				


@endsection  
@stop
