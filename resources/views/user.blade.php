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
	#ToolTables_user_0,#ToolTables_user_1 {
		visibility:hidden;
	}
	div.DTED_Lightbox_Wrapper{
		z-index:9999;
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
@section('page_heading',Lang::get('Manage Users') )
@var	$userCanAdd		=	"no"
@var	$userCanEdit	=	"no"
@var	$userCanDelete	=	"no"

@permission("add.admin.manageusers")
	@var	$userCanAdd		=	"yes"
@endpermission
@permission("edit.admin.manageusers")
	@var	$userCanEdit	=	"yes"
@endpermission
@permission("delete.admin.manageusers")
	@var	$userCanDelete	=	"yes"
@endpermission
<div class="col-sm-12 space-around">
	<div class="row">		
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="table-responsive">
				<table class="table table-bordered" id="user">
					<thead>
						<th><input type="checkbox" id="select_all_list"></th>
						<th>User Name</th>
						<th>Email</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
				</table>
			</div>
			<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
			<input id="hidden_user_id" type="hidden" value="{{Auth::user()->user_id}}">
			<input id="userCanAdd" type="hidden" value="{{$userCanAdd}}">
			<input id="userCanEdit" type="hidden" value="{{$userCanEdit}}">
			<input id="userCanDelete" type="hidden" value="{{$userCanDelete}}">
		</div>
	</div>
</div>
 @endsection  
@stop
<!--
<script>
$( "div" ).hasClass( "DTED_Lightbox_Wrapper" )
$('div.DTED_Lightbox_Wrapper').css({"z-index":"9999"});
</script>
-->
