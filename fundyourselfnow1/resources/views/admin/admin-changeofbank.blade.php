@extends('layouts.dashboard_admin')
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
		table.dataTable.no-footer{
			border:none;
		}
	</style>
@stop

@section('page_heading',Lang::get('Change of Bank Requests'))
@section('section')  

<div class="col-sm-12 space-around">	

<!-----datatable starts---->
	<form 	method="post" action="" id="form-changeofbank">
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
			</div>
		</div>	
		<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">	
	</form>
	<!-----datatable ends---->
</div>
	@endsection  
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script> var baseUrl	=	"{{url('')}}" 
	$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})</script>
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}	
	{{ Html::script('js/customdatatable/adminchangebank.js') }}	
@endsection
