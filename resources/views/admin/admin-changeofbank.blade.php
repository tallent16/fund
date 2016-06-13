@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Change of Bank Requests'))
@section('section')  
@var $bank_list = $adminbanklistModel->bank_lists;
<div class="col-sm-12 space-around">	
	<div class="panel panel-primary panel-container borrower-admin">						
		<form 	method="post" 
				action=""
				id="form-changeofbank">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			
			<div class="table-responsive">
				<table class="table tab-fontsize text-left">
					<thead>
						<tr>
							<th class="tab-head text-left col-sm-2">									
								{{Lang::get('User Type')}}</th>	
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Name')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Bank Name')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Bank Code')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Branch Code')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Account Number')}}</th>
						</tr>
					</thead>
					<tbody>
						
						@foreach($bank_list as $row)
						<tr>
							<td>{{$row->borrower_bankid}}</td>
							<td>{{$row->type}}</td>
							<td>{{$row->bank_code}}</td>
							<td>{{$row->bank_name}}</td>
							<td>{{$row->branch_code}}</td>
							<td>{{$row->bank_account_number}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</form>
	
	</div>
</div>
	@endsection  
@stop
