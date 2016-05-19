@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-permission-listing.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('Role Management'))
@section('section')  
<div class="col-sm-12 space-around">
	<div class="row">
		<div class="col-sm-12 col-lg-3">	
			<div class="form-group" id="parent_role_name">			
				<strong>Role</strong>	
					@if($trantype	==	"add") 
					<br>
						<input 	type="text"
								name="role_name"
								id="role_name"
								class="form-control"
								 />
						<span 	class="control-label error label_role_name_error"
								style="display:none">
						</span>
					@else
						{{ 
							Form::select('role_filter',$adminRolesModel->filterRoleList, 
											$adminRolesModel->filterRoleValue,
											[	"class" => "selectpicker",
												"id" => "role_filter"]) 
						}} 	
					@endif							
			</div>
		</div>
		@if($trantype	==	"edit") 
			<div class="col-sm-12 col-lg-3 space-around">			
				<button class="btn verification-button" 
						type="button"
						id="change_role">
					Apply Filter			
				</button>				
			</div>	
		@endif
	</div>
	
	<div class="row">
		<div class="col-sm-12 col-lg-5">
			<strong>{{Lang::get('Role Screen')}}</strong>
			<div class="panel panel-primary panel-container borrower-admin space-around">
				<div class="table-responsive">
					<table class="table tab-fontsize text-left">
						<thead>
							<tr>
								<th class="tab-head text-left">
									{{Lang::get('Module')}}</th>
								
								<th class="tab-head text-left	">
									<span>
										<input 	type="checkbox" 
												value="" 
												id="select_all_modules" 
												name="select_all"
												checked>
									</span>
								</th>							
							</tr>
						</thead>
						<tbody>
							@foreach($adminRolesModel->moduleList as $key => $value)
									<tr>
										<td>
											{{$value}}
										</td>
										<td class="text-left">
											<input 	type="checkbox" 
													value="{{$key}}"
													class="modules" 
													checked />
										</td>
									</tr>
							@endforeach
						</tbody>
					</table>					
				</div>
			</div>		
		</div>
		<div class="col-sm-12 col-lg-7">
			<strong>{{Lang::get('Permissions')}}</strong>
			<div class="panel panel-primary panel-container borrower-admin space-around">					
					
				<form method="post" id="form-role-permission">
					<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="trantype" id="trantype" value="{{ $trantype }}">
					<input type="hidden" name="role_name" id="hidden_role_name" value="">
					<input type="hidden" name="role_filter" id="hidden_role_filter" value="">
					
					<div class="table-responsive">
						<table class="table tab-fontsize text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">
										{{Lang::get('Module')}}
									</th>
									<th class="tab-head text-left">
										{{Lang::get('Screen')}}
									</th>
									
									<th class="tab-head text-left	">
										Permission
									</th>							
								</tr>
							</thead>
							<tbody>
								@if (count($adminRolesModel->allPermissionList) > 0)	
									@foreach($adminRolesModel->allPermissionList as $permissionRow)
										@var	$mod	=	$adminRolesModel->moduleList[$permissionRow->module_id]
										<tr class="module_{{$permissionRow->module_id}} modules_privileges">
											<td>
												{{$mod}}
											</td>
											<td>
												{{$permissionRow->name}}
											</td>
											<td class="text-left">
												@if($permissionRow->isChecked !="")
													<input 	type="hidden" 
														value="{{$permissionRow->id}}" 
														name="set_permission_{{$permissionRow->id}}">
												@endif
												<input 	type="checkbox" 
														value="{{$permissionRow->id}}" 
														{{$permissionRow->isChecked}}
														class="select_permission_id" 
														name="permission_ids[]">
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
			<a href="{{url('admin/roles')}}" class="btn verification-button">
				{{ Lang::get('Close')}}
			</a>
		</div>										
	</div>
</div>
	@endsection  
@stop
