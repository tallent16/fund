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
				<h4>{{ Lang::get('borrower-loanlisting.alert_msg_text') }}</h4>	
			</div>
		</div>				
	</div>
</div>
<div id="filter_area" style="display:none">
<form >
	<div class="row">	
		<!--<div class="col-sm-12"> -->
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group">	
					<strong>{{ Lang::get('borrower-loanlisting.interest_rate') }}</strong><br>							
					{{ Form::select('intrate_filter', $loanListing->filterIntRateList, $loanListing->filterIntRateValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>
					
			<div class="col-sm-12 col-lg-3"> 
				<div class="form-group">								
					<strong>{{ Lang::get('borrower-loanlisting.loan_amount') }}</strong><br>							
					{{ Form::select('loanamt_filter', $loanListing->filterLoanAmtList, $loanListing->filterLoanAmtValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>

			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group">							
					<strong>{{ Lang::get('borrower-loanlisting.tenure') }}</strong><br>							
					{{ Form::select('tenure_filter', $loanListing->filterTenureList, $loanListing->filterTenureValue, ["class" => "selectpicker"]) }} 
				</div>	
			</div>

			<div class="col-sm-12 col-lg-3"> 
				<div class="form-group">								
					<strong>{{ Lang::get('borrower-loanlisting.grade') }}</strong><br>							
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
			{{ Lang::get('borrower-loanlisting.apply_filter') }}			
		</button>
	</div>
	<div class="col-sm-2">
		<button type="button"  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
			{{ Lang::get('borrower-loanlisting.show_filter') }}			
		</button>
	</div>

</form>
	<!--</div>-->
</div>

<div class="row">
	<div class="col-sm-12 space-around"> 

	<?php $firstBlock = true; ?>
		@foreach ($loanListing->loanList as $loanRow)
			@if ($firstBlock) 
				<div class="row">
			@endif 
			
					<div class="col-sm-12 col-lg-6">
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
/*Redirect the url to respected loandetails page*/
function redirecturl(loanurl)
{
	window.location=loanurl;
}
</script>
 @endsection
@stop
