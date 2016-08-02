@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
			border-bottom:none;
			font-size:12px;
		}
		table.dataTable thead > th {
			color: #fff;			
			text-decoration:none;			
		}		
		table.dataTable thead > tr{
			background-color:#333;
			color:#fff;
		}
		.dataTable td a{
			color:#333;
			text-decoration:none;		
		}
		.table-responsive{
			overflow:visible;
		}
		table.dataTable.no-footer{
			border:none;
		}
	</style>
@stop

@section('page_heading',Lang::get('Change of Bank Requests'))
@section('section')  
<!--
@var $bank_list = $adminbanklistModel->bank_lists;
-->
<div class="col-sm-12 space-around">	
<!--
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
						@if (count($bank_list) > 0)
							@foreach($bank_list as $row)
							@var	$editUrl	=	url('admin/approvechangeofbank').'/'.base64_encode($row->user_type).'/'.base64_encode($row->borrower_id).'/'.base64_encode($row->borrower_bankid)
							<tr>
								<td><a href="{{$editUrl}}">{{$row->user_type}}</a></td>
								<td><a href="{{$editUrl}}">{{$row->business_name}}</a></td>
								<td><a href="{{$editUrl}}">{{$row->bank_code}}</a></td>
								<td><a href="{{$editUrl}}">{{$row->bank_name}}</a></td>
								<td><a href="{{$editUrl}}">{{$row->branch_code}}</a></td>
								<td><a href="{{$editUrl}}">{{$row->bank_account_number}}</a></td>
								<input type="hidden" name="bank_statement_url" id="bank_statement_url" 
								value="{{$row->bank_statement_url}}">
							</tr>
							@endforeach
						@endif	
					</tbody>
				</table>
			</div>
		</form>
	
	</div>
-->

<!-----datatable starts---->
	
		<div class="row">		
			<div class="col-lg-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-striped" id="adminchangebank">
						<thead>
							<tr>								
								<th>{{ Lang::get('User Type') }}</th>
								<th>{{ Lang::get('Name') }}</th>
								<th>{{ Lang::get('Bank Name') }}</th>
								<th>{{ Lang::get('Bank Code') }}</th>
								<th>{{ Lang::get('Branch Code') }}</th>
								<th>{{ Lang::get('Account Number') }}</th>								
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">					
			</div>
		</div>	

	<!-----datatable ends---->
</div>
	@endsection  
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script> var baseUrl	=	"{{url('')}}" </script>
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}	
	{{ Html::script('js/customdatatable/adminchangebank.js') }}	
@endsection
