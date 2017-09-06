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
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  
<div class="col-sm-12 space-around">

	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">	
				<button class="btn verification-button"
						id="bulk_approve_button">
					{{ Lang::get('Approve Selected')}}
				</button>
			</div>
		</div>
	</div>
	<!-----datatable starts---->
	<form 	method="post" 
				action="{{url('admin/borrowersrepaylist/bulkapprove')}}"
				id="form-borrower-repayment">
		<div class="row">		
			<div class="col-lg-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-striped" id="adminrepaymentlisting">
						<thead>
							<tr>
								<th>														
									<label>
										<input type="checkbox" id="select_all_list" value="Select All">
									</label>											
								</th>
								<th>{{ Lang::get('Installment No') }}</th>
								<th>{{ Lang::get('Project Reference') }}</th>
								<th>{{ Lang::get('Scheduled Date') }}</th>
								<th>{{ Lang::get('Actual Date') }}</th>								
								<th>{{ Lang::get('Installment Amount') }}</th>
								<th>{{ Lang::get('Penalty') }}</th>
								<th>{{ Lang::get('Status') }}</th>
								<th>{{ Lang::get('Actions') }}</th>
								<th>{{ Lang::get('Hidden Status') }}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">			
				<input 	type="hidden" 
						id="default_unverified_applicable" 
						value="{{BORROWER_REPAYMENT_STATUS_UNVERIFIED}}">
			</div>
		</div>	
	</form>
	<!-----datatable ends---->
	
</div>
	@endsection  
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-borrower-repaylisting.js") }}" type="text/javascript"></script>	
	<script> var baseUrl	=	"{{url('')}}" 
	$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})
	</script>
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}
	{{ Html::script('js/bootstrap-datetimepicker.js') }}
	{{ Html::script('js/customdatatable/adminrepaymentlisting.js') }}	
@endsection
