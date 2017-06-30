@extends('layouts.plane')
@section('body')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />
@endsection
@include('header',array('class'=>'',))
<div class="container-flex">
	

	<div class="row">
	
	@if($home->loanListing)
		@var $loans = $home->loanListing
		@var $title = "All Projects"
	@elseif($home->recommendedList)
		@var $loans = $home->recommendedList
		@var $title = "Featured Projects"	
	@elseif($home->loanList)
		@var $loans = $home->loanList
		@var $title = "Popular Projects"	
	@else		
		@var $loans = $home->projectList	
		@var $title = $home->filterProCatValue
	@endif			
	
	<h4><strong><i class="fa fa-bars" aria-hidden="true"></i> {{$title}}</strong></h4>
	
	@if($home->recommendedList || $home->loanList || $home->projectList)
	
	@else
	
	<div id="filter_area">
	<form>
		<div class="row text-right">	
			<div class="col-sm-2">
			</div>
			<div class="col-sm-1"> 	
				 <label><strong>{{ Lang::get('Filter by') }}</strong></label>	
			</div>
			<div class="col-sm-3"> 																			
				<div class="form-group">	
					{{ Form::select('tenure_filter', $home->filterProCatList, $home->filterProCatValue,
						 ["class" => "selectpicker","filter_field" => "Yes"]) }} 					
				</div>							
			</div>
			<div class="col-sm-1"> 	
				 <label><strong>{{ Lang::get('Sort by') }}</strong></label>
			</div>			
			<div class="col-sm-3"> 				
				<div class="form-group">		
					{{ Form::select('sortby', $home->sortbyList, $home->sortbyvalue,
						 ["class" => "selectpicker","filter_field" => "Yes"]) }} 
				</div>				
			</div>
			<div class="col-sm-2">
				<div class="form-group pull-right" id="apply_filter_div">	
					<button type="submit" class="btn verification-button">
						{{ Lang::get('borrower-loanlisting.apply_filter') }}			
					</button>	
				</div>	
			</div>
				
		</div>
	</form>	
	</div>
    @endif
	
	
	@if($loans)
	@foreach ($loans as $loanRow)	
			@include('widgets.loanlisting_frontend', array('class'=>'', "loanRow"=>$loanRow))
	@endforeach
	@else
			No Projects Found
	@endif
	</div>

</div>
</div>
@include('footer',array('class'=>'',))
@endsection

@section('bottomscripts')

	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
 /*Redirect the url to respected loandetails page*/
	function redirecturl(caturl)
	{
		window.location=caturl;
	}
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
} 
</script>
@endsection
@stop
