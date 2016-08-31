@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/jquery.tabletojson.js') }}" type="text/javascript"></script>
	<script>
		function convert2json() {
			var reportJson 	= $('.table').tableToJSON(); // Convert the table into a javascript object
			$obj				=	JSON.stringify(reportJson);
			$fromDate			=	$("#fromdate").val();
			$toDate				=	$("#todate").val();
			
			$("#hidden_from_date").val($fromDate);
			$("#hidden_to_date").val($toDate);
			$("#report_json").val($obj);
			if(reportJson.length > 0) {
				$("#excel_export").submit();
			}else{
				showDialog("","No Data avilable to Export");
			}
			
		}
	</script>
	@endsection
@section('page_heading',Lang::get('Investor Activity Report') )
@section('section')  
	@var	$invFilter	=	$adminInvActRepMod->invFilterValue;
	@var	$fromDate	=	$adminInvActRepMod->fromDateFilterValue;
	@var	$toDate		=	$adminInvActRepMod->toDateFilterValue;
	@var	$invList	=	$adminInvActRepMod->allactiveinvestList;
	
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post">
	<input  type="hidden" 
		name="_token"
		id="hidden_token"
		value="{{ csrf_token() }}" />
	<div class="row">		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Investor Name') }}</strong><br>							
					{{ Form::select('investor_filter[]', $invList,$invFilter,
												[	"class" => "selectpicker",
													"multiple" => "multiple",
													"id"=>"investor_filter",
													"data-size"=>5,
													"data-selected-text-format"=>"count>3",
													"data-actions-box"=>"true",
													"filter_field" => "Yes" ,
													"data-live-search"=>true ]) }} 
			</div>		
		</div>		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input 	id="fromdate" 
						name="fromDate_filter" 
						value="{{$fromDate}}" 
						filter_field="Yes"
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input 	id="todate" 
						name="toDate_filter" 
						value="{{$toDate}}"
						type="text" 
						filter_field="Yes"
						class="date-picker form-control" />
			</div>	
		</div>
		
	</div>
</div>

<div class="row">	
	<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
		<div class="form-group">	
			<button type="submit" class="btn verification-button">
				{{ Lang::get('Apply Filter')}}
			</button>
		</div>
	</div>
</form>	
<form 	class="form-horizontal" 
		id="excel_export" 
		method="post"
		action="{{url('admin/investor-activity-report/download')}}">
		<input  type="hidden" 
				name="_token"
				id="hidden_token"
				value="{{ csrf_token() }}" />
		<input type="hidden" id="report_json" name="report_json" />
		<input type="hidden" id="hidden_from_date" name="from_date" />
		<input type="hidden" id="hidden_to_date" name="to_date" />
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
	
</div><!-----First row----->
@var	$showInvestName	=	false
@if(count($invFilter) > 1)
	@var	$showInvestName	=	true
@endif
@include('widgets.admin.investor-activity', array(	"class"=>"",
													"invFilter"=>$invFilter,
													"invList"=>$invList,
													"showInvestName"=>$showInvestName))



</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
$(document).ready(function(){ 
	// date picker
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 

	}); 
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 

	});         
	
}); 
</script>  
@endsection  
@stop

