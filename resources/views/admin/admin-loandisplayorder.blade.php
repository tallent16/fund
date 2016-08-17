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
@section('page_heading',Lang::get('Loan Display Order') )
@section('section') 
<div class="col-sm-12 space-around">
	
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table table-striped" id="admindisplayorder">
					<thead>
						<tr>	
							<th></th>						
							<th>{{ Lang::get('Loan Reference No') }}</th>
							<th>{{ Lang::get('Borrower Organisation Name') }}</th>
							<th>{{ Lang::get('Loan Amt') }}</th>
							<th>{{ Lang::get('Bid Type') }}</th>
							<th>{{ Lang::get('Bid Close Date') }}</th>						
							<th>{{ Lang::get('Status') }}</th>						
							<th>{{ Lang::get('Featured') }}</th>
							<th>{{ Lang::get('Display Order') }}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>	
			<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">						
		</div>
	</div>
	
</div>
@endsection
@stop
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script> var baseUrl	=	"{{url('')}}"  </script>
{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
{{ Html::script('js/datatable/dataTables.editor.js') }}	
{{ Html::script('js/customdatatable/admindisplayorder.js') }} 
@endsection 
