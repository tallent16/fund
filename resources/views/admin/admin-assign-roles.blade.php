@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-userroles-listing.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('User Roles Management'))
@section('section')  

<div class="col-sm-12 space-around">
	<div class="row">
		<div class="col-sm-12 col-lg-3">	
			<div class="form-group" id="parent_role_name">			
				<strong>User</strong>	
					{{ 
						Form::select('user_filter',$adminAssRolModel->usersList, 
										$adminAssRolModel->filterUserValue,
										[	"class" => "selectpicker",
											"id" => "user_filter"]) 
					}} 	
			</div>
		</div>
		<div class="col-sm-12 col-lg-3 space-around">			
				<button class="btn verification-button" 
						type="button"
						id="change_user">
					Apply Filter			
				</button>				
		</div>	
	</div>
	
	<div class="row">
		
		<div class="col-sm-12 col-lg-5">
			<div class="panel panel-primary panel-container borrower-admin space-around">					
					
				<form method="post" id="form-user-roles" action="{{url('admin/assign-roles')}}">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="user_id" id="user_id" value="">
					
					<div class="table-responsive">
						<table class="table tab-fontsize text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">
										{{Lang::get('Role Name')}}
									</th>
									<th class="tab-head text-left">
										{{Lang::get('Action')}}
									</th>
													
								</tr>
							</thead>
							<tbody>
								@if (count($adminAssRolModel->roleList) > 0)	
									@foreach($adminAssRolModel->roleList as $roleRow)
										<tr>
											
											<td>
												{{$roleRow->name}}
											</td>
											<td class="text-left">
												@if($roleRow->isChecked !="")
													<input 	type="hidden" 
														value="{{$roleRow->id}}" 
														name="set_role_{{$roleRow->id}}">
												@endif
												<input 	type="checkbox" 
														value="{{$roleRow->id}}"
														class="select_role_id" 
														{{$roleRow->isChecked}}
														name="role_ids[]">
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>					
					</div>		
				</form>			
			</div>	<!---panel-->
		</div>
	</div>
	<div class="row">
		<div class="col-sm-6">							
			<button type="button" class="btn verification-button" id="save_permission">
				{{ Lang::get('Save')}}
			</button>
			<a href="{{url('admin/user')}}" class="btn verification-button">
				{{ Lang::get('Close')}}
			</a>
		</div>										
	</div>
</div>
	@endsection  
@stop
