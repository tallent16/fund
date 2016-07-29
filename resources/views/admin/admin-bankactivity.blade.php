@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Bank Activty Report') )
@section('section')  
	@var	$bankActList	=	$adminBankActRepMod->bankActList;
	@var	$fromDate		=	$adminBankActRepMod->fromDateFilterValue;
	@var	$toDate			=	$adminBankActRepMod->toDateFilterValue;
	
	
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post">
	<input  type="hidden" 
		name="_token"
		id="hidden_token"
		value="{{ csrf_token() }}" />
	<div class="row">		
		
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

</div><!-----First row----->

@include('widgets.admin.bank-activity', array(	"class"=>"",
													"bankActList"=>$bankActList,
													))



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

