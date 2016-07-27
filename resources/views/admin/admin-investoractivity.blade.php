@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Investor Activty Report') )
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
													"data-actions-box"=>"true"]) }} 
			</div>		
		</div>		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input 	id="fromdate" 
						name="fromDate_filter" 
						value="{{$fromDate}}" 
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
	<!---<div class="col-sm-4 col-lg-2">
		<div class="form-group">	
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter')}}
			</button>
		</div>
	</div>	--->
	
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

