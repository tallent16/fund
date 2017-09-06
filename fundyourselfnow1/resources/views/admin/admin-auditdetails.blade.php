@extends('layouts.dashboard_admin')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Audit Details') )
@section('section')  
<div class="col-sm-12 space-around">
	
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			Module
		</div>
		<div class="col-sm-4 col-xs-2">
			:
		</div>
		<div class="col-sm-4 col-xs-6">
			Value
		</div>
	</div>	
	<div class="row">&nbsp;</div>
	
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			Description
		</div>
		<div class="col-sm-4 col-xs-2">
			:
		</div>
		<div class="col-sm-4 col-xs-6">
			Value
		</div>
	</div>
	<div class="row">&nbsp;</div>
	
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			User
		</div>
		<div class="col-sm-4 col-xs-2">
			:
		</div>
		<div class="col-sm-4 col-xs-6">
			Value
		</div>
	</div>
	<div class="row">&nbsp;</div>
	
	<div class="row">
		<div class="col-sm-4 col-xs-4">
			Date-Time
		</div>
		<div class="col-sm-4 col-xs-2">
			:
		</div>
		<div class="col-sm-4 col-xs-6">
			Value
		</div>
	</div>
	<div class="row">&nbsp;</div>
	<div class="panel panel-primary panel-container">
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-4">
				 Fields
				</div>
				<div class="col-sm-4">
				  Before Operation
				</div>
				<div class="col-sm-4">
				  After Operation
				</div>
			</div>					
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-4">
				 Field Name 1
				</div>
				<div class="col-sm-4">
				 	<div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
				<div class="col-sm-4">
				  <div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-4">
				 Field Name 1
				</div>
				<div class="col-sm-4">
				 	<div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
				<div class="col-sm-4">
				  <div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-4">
				 Field Name 1
				</div>
				<div class="col-sm-4">
				 	<div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
				<div class="col-sm-4">
				  <div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-4">
				 Field Name 1
				</div>
				<div class="col-sm-4">
				 	<div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
				<div class="col-sm-4">
				  <div class="form-group">
						<input id="" name="" value="" 
							type="text" class="form-control" />
					</div>
				</div>
			</div>	
		</div>
	</div>
	
	
	
</div>
		@endsection  
@stop
