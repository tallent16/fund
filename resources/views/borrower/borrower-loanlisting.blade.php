@extends('layouts.dashboard')
@section('page_heading','Test Loan Listing')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('section')

<div class="col-sm-12 space-around"> 
	<div class="row">
		<div class="col-sm-6">
			<div class="panel-body">
				@include('widgets.testloanlisting', array('class'=>'', "fieldNameValue"=>"chumma1"))
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="panel-body">
				@include('widgets.testloanlisting', array('class'=>'', 'fieldNameValue'=>'chumma2'))
			</div>
		</div>	
	</div>
</div>
 @endsection
@stop
