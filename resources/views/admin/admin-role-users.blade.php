@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-roles-listing.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('User with Role ')."'".$adminRolesModel->roleName."'")
@section('section')  
<div class="col-sm-12 space-around">
		<div class="panel panel-primary panel-container borrower-admin space-around">					
				
			<form method="post" id="form-investor-listing" action="{{url('admin/investordepositlist/bulkaction')}}">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			
			<div class="table-responsive">
				<table class="table tab-fontsize text-left">
					<thead>
						<tr>
							<th class="tab-head text-left">
								{{Lang::get('User Name')}}</th>
							<th class="tab-head text-left">
								{{Lang::get('Email')}}</th>
							<th class="tab-head text-left	">
								{{Lang::get('First Name')}}</th>							
							<th class="tab-head text-left">
								{{Lang::get('Last Name')}}</th>
						</tr>
					</thead>
					<tbody>
						@if (count($adminRolesModel->roleUsersList) > 0)	
							@foreach($adminRolesModel->roleUsersList as $roleUserRow)
								<tr>
									<td>
										{{$roleUserRow->username}}
									</td>
									<td>
										{{$roleUserRow->email}}
									</td>
									<td class="text-left">
										{{$roleUserRow->firstname}}
									</td>
									<td class="text-left">
										{{$roleUserRow->lastname}}
									</td>
								</tr>
							@endforeach
						@endif
					</tbody>
				</table>					
			</div>		
			</form>			
		</div>	<!---panel-->
	<div class="row">
		<div class="col-sm-12">							
			<a href="{{url('admin/roles')}}" class="btn verification-button">
				{{ Lang::get('Close')}}
			</a>
		</div>										
	</div>
</div>
	@endsection  
@stop
