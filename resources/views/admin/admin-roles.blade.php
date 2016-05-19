@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-roles-listing.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('Roles') )
@section('section')  
<div class="col-sm-12 space-around">
	<form method="get">
	<div class="row">	
		<div class="col-sm-4 col-lg-3"> 
			<div class="space-around">
				<a href="{{url('admin/role-permission/add/0')}}" class="btn verification-button">
							{{ Lang::get('Add Roles')}}
				</a>
			</div>
		</div>
		
	</div>
	</form>
	
		<div class="panel panel-primary panel-container borrower-admin space-around">					
				
			<form method="post" id="form-investor-listing" action="{{url('admin/investordepositlist/bulkaction')}}">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			
			<div class="table-responsive">
				<table class="table tab-fontsize text-left">
					<thead>
						<tr>
							<th class="tab-head text-left">
								{{Lang::get('Role Name')}}</th>
							<th class="tab-head text-left">
								{{Lang::get('Permission')}}</th>
							<th class="tab-head text-left	">
								{{Lang::get('Users')}}</th>							
							<th class="tab-head text-left">
								{{Lang::get('Actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@if (count($adminRolesModel->roleList) > 0)	
							@foreach($adminRolesModel->roleList as $roleRow)
								<tr>
									<td>
										{{$roleRow->name}}
									</td>
									<td>
										<a href="{{url('admin/role-permission/edit').'/'.$roleRow->id}}" >
											Permissions for {{$roleRow->name}}
										</a>
									</td>
									<td class="text-left">
										<a href="{{url('admin/role-users').'/'.$roleRow->id}}" >
											{{Lang::get('Users')}}
										</a>
									</td>
									<td class="text-left">
										{{Lang::get('Delete')}}
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
	@endsection  
@stop
