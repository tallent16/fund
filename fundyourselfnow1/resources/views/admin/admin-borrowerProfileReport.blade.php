@extends('layouts.dashboard_admin')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	
@stop
@section('page_heading',Lang::get('Creator Profile Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post" action="{{url('admin/creator-profiles/report')}}">
	<input  type="hidden" 
			name="_token"
			id="hidden_token"
			value="{{ csrf_token() }}" />

	<div class="row">		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Status') }}</strong><br>							
					{{ Form::select('approval_status', 
							$adminBorProRepMod->allAprovalStatus, 
							$adminBorProRepMod->filterStatusValue, 
							["class" => "selectpicker",
							"id" => "approval_status"]) }} 
			</div>		
		</div>	
	</div>
</div>

<div class="row">	
	<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
		<div class="form-group">	
			<button type="submit" id="filter_status" class="btn verification-button">
				{{ Lang::get('Apply Filter')}}
			</button>
		</div>
	</div>
</form>	
<form 	class="form-horizontal" 
		id="excel_export" 
		method="post"
		action="{{url('admin/creator-profiles-report/download')}}">
		<input  type="hidden" 
				name="_token"
				id="hidden_token"
				value="{{ csrf_token() }}" />
		<input type="hidden" id="report_json" name="report_json" />
		<div class="col-sm-4 col-lg-2">
			<div class="form-group">	
				<button  id="export_all"
						class="btn verification-button" 
						type="button"
						onclick="convert2json()">
					{{ Lang::get('Export')}}
				</button>
			</div>
		</div>	
</form>
	<!---<div class="col-sm-4 col-lg-2">
		<div class="form-group">	
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter')}}
			</button>
		</div>
	</div>	--->
	
</div><!-----First row----->
@if(!empty($adminBorProRepMod->borListInfo))
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table tab-fontsize table-border-custom text-left" id="adminloanlisting">
					<thead>
						<tr>
							<th class="tab-head text-left">{{ Lang::get('Creator Id') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Organization Name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Key Contact Person') }}</th>
							<th class="tab-head text-left">{{ Lang::get('CP Email') }}</th>
							<th class="tab-head text-left">{{ Lang::get('CP Mobile') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Paid up Capital') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Operation Since') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Projects Applied') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Projects Sanctioned') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($adminBorProRepMod->borListInfo as $listRow)
							<tr>
								<td class="text-left">{{$listRow->borrower_id}}</td>
								<td class="text-left">{{$listRow->business_name}}</td>
								<td class="text-left">{{$listRow->contact_person}}</td>
								<td class="text-left">{{$listRow->contact_person_email}}</td>
								<td class="text-left">{{$listRow->contact_person_mobile}}</td>
								<td class="text-right">{{$listRow->paid_up_capital}}</td>
								<td class="text-left">{{$listRow->operation_since}}</td>
								<td class="text-right">{{$listRow->tot_loan_applied}}</td>
								<td class="text-right">{{$listRow->tot_loan_sanctioned}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>							
		</div>
	</div>
@endif		
</div>
@endsection
@stop
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script> var baseUrl	=	"{{url('')}}" </script>

<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.tabletojson.js') }}" type="text/javascript"></script>
<script>
	function convert2json() {
		var reportJson 	= $('.table').tableToJSON(); // Convert the table into a javascript object
		$obj				=	JSON.stringify(reportJson);
	
		$("#report_json").val($obj);
		if(reportJson.length > 0) {
			$("#excel_export").submit();
		}else{
			showDialog("","No Data avilable to Export");
		}
		
	}
</script>	

<script>	/*
function hideShowFilter() {

	hideShow = $("#hide_show_filter").html();
	
	if (hideShow == "Hide Filter") {
		$("#apply_filter_div").hide();
		$("#filter_area").hide();
		$("#hide_show_filter").html("{{ Lang::get('Show Filter') }}")
	} else {
		$("#apply_filter_div").show();
		$("#filter_area").show();
		$("#hide_show_filter").html("{{ Lang::get('Hide Filter') }}")
	}

}	*/
$(document).ready(function(){ 
	// date picker
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd-mm-yyyy' 

	}); 
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd-mm-yyyy' 

	});         
}); 
</script>
@endsection  
