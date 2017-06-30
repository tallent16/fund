
@extends('layouts.dashboard')
@section('page_heading',Lang::get('Project Listing'))
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('section')


<div class="row">
	<div class="col-sm-12 space-around"> 
	
	<?php $firstBlock = true; ?>
		@if($home->recommendedList)
			@var $projects = $home->recommendedList;
		@elseif($home->loanList)
			@var $projects = $home->loanList;
		@else
			@var $projects = $home->projectList;
		@endif
		
		@foreach ($projects as $loanRow)	
	
		
			@if ($firstBlock) 
				<div class="row">
			@endif 
			
					<div class="col-sm-12 col-lg-6">
						<div class="panel-body">
							@include('widgets.projectlisting_widget', array('class'=>'', "loanRow"=>$loanRow))
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
<script>
 /*Redirect the url to respected loandetails page*/
	function redirecturl(loanurl)
	{
		window.location=loanurl;
	}
</script>
 @endsection
@stop
