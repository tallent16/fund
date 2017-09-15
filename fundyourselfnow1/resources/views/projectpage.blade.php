@extends('layouts.plane')
@section('body')

@include('header',array('class'=>'',))
<div class="inner_page">
	
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
	
	

	<section class="project_area">
		<div class="container">
		<h3>{{$title}}</h3>
			@if($home->recommendedList || $home->loanList || $home->projectList)
	
	@else
	
	<div id="filter_area">
	<form>
		<div class="row">
			<div class="col-lg-1 col-sm-2"> 	
				 <label>{{ Lang::get('project_detail.filter_by') }}</label>	
			</div>
			<div class="col-lg-4 col-sm-3"> 																			
				<div class="form-group">	
					{{ Form::select('tenure_filter', $home->filterProCatList, $home->filterProCatValue,
						 ["class" => "selectpicker","filter_field" => "Yes"]) }} 					
				</div>							
			</div>
			<div class="col-lg-1 col-sm-2"> 	
				 <label>{{ Lang::get('project_detail.sort_by') }}</label>
			</div>			
			<div class="col-lg-4 col-sm-3"> 				
				<div class="form-group">		
					{{ Form::select('sortby', $home->sortbyList, $home->sortbyvalue,
						 ["class" => "selectpicker","filter_field" => "Yes"]) }} 
				</div>				
			</div>
			<div class="col-sm-2">
				<div class="form-group" id="apply_filter_div">	
					<button type="submit" class="btn verification-button btn-block yellow_btn" style="margin-top:0;">
						{{ Lang::get('borrower-loanlisting.apply_filter') }}			
					</button>	
				</div>	
			</div>
				
		</div>
	</form>	
	</div>
    @endif
		<div class="row">
			@if($loans)
			<article class="project_boxouter">
			@foreach ($loans as $loanRow)	
					@include('widgets.loanlisting_frontend', array('class'=>'', "loanRow"=>$loanRow))
			@endforeach
						</article>
			@else
					No Projects Found
			@endif
		</div>
	</div>
	</section>

</div>
<footer class="footer">
@include('footer')

</footer>
@endsection

@section('bottomscripts')

	<!-- <script src='{{ asset("assets/scripts/frontend.js") }}' type="text/javascript"></script> -->
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
