@extends('layouts.dashboard')
@section('page_heading','Loan Listing')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('section')
<div class="col-sm-12">
<div class="row">
	<div class="col-sm-12 text-center space-around">
		<div class="annoucement-msg-container">
			<div class="alert alert-success annoucement-msg">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<h4>We are here to help you find the best loans to find.</h4>	
			</div>
		</div>				
	</div>
</div>
<div id="filter_area" style="display:none">
<form >
	<div class="row">	
		<!--<div class="col-sm-12"> -->
			<div class="col-sm-3"> 														
				<div class="form-group">	
					<strong>Interest Rate</strong><br>							
					{{ Form::select('intrate_filter', $loanListing->filterIntRateList, $loanListing->filterIntRateValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>
					
			<div class="col-sm-3"> 
				<div class="form-group">								
					<strong>Loan Amount</strong><br>							
					{{ Form::select('loanamt_filter', $loanListing->filterLoanAmtList, $loanListing->filterLoanAmtValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>

			<div class="col-sm-3"> 														
				<div class="form-group">							
					<strong>Tenure</strong><br>							
					{{ Form::select('tenure_filter', $loanListing->filterTenureList, $loanListing->filterTenureValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>

			<div class="col-sm-3"> 
				<div class="form-group">								
					<strong>Borrower Grade</strong><br>							
					{{ Form::select('grade_filter', $loanListing->filterGradeList, $loanListing->filterGradeValue, ["class" => "selectpicker"]) }} 

				</div>	
			</div>
		<!--</div>-->
	</div>
</div>

<div class="row">
	<!--<div class="col-sm-12" >-->
		<div class="col-sm-2" id="apply_filter_div" style="display:none">
			<button type="submit" class="btn verification-button">
				{{ Lang::get('Apply Filter') }}
			</button>
		</div>
</form>
		<div class="col-sm-2">
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter') }}
			</button>
		</div>
	<!--</div>-->
</div>

<div class="row">
	<div class="col-sm-12 space-around"> 
		

		<?php $firstBlock = true; ?>
		@foreach ($loanListing->loanList as $loanRow)
			@if ($firstBlock) 
				<div class="row">
			@endif 
			
					<div class="col-sm-6">
						<div class="panel-body">
							@include('widgets.loanlisting_widget', array('class'=>'', "loanRow"=>$loanRow))
						</div>
					</div>
				
			@if (!$firstBlock) 
				</div>
				<?php $firstBlock = true; ?>
			@else
				<?php $firstBlock = false; ?>		
			@endif
		@endforeach

	</div>
</div>
</div>
<script>
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

function chumma() {
	alert("chumma");
}
	
</script>
 @endsection
@stop
