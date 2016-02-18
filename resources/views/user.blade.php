@extends('layouts.dashboard')
@section('styles')

	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}
	{{ Html::style('css/bootstrap-datetimepicker.min.css') }}
	{{ Html::style('css/itrackStyle.css') }}
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
	}
		table.dataTable thead th, table.dataTable tr td a.user_edit_master  {
			color: #333333;
	}
		table.dataTable thead th, table.dataTable tr td a.user_edit_master:hover  {
			text-decoration:none;
	}
	</style>
@stop
@section('scripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script>
		var public_path	=	"{{ url ('')}}";
	</script>
	
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}
	{{ Html::script('js/bootstrap-datetimepicker.js') }}
	{{ Html::script('js/user/moneymatch-user.js') }}
	
@stop
@section('section')
	<div class="table-responsive">
		<table class="table table-bordered" id="user">
			<thead>
				<th><input type="checkbox" id="select_all_list"></th>
				<th>User Name</th>
				<th>Email</th>
				<th>User Type</th>
				<th>Status</th>
			</thead>
		</table>
	</div>
	<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
 @endsection  
@stop
