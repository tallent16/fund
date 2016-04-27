@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>		
	$(document).ready(function(){ 
	// date picker
	$('.deposit_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
		}); 
	}); 
	</script>
@endsection
@section('page_heading',Lang::get('Investor Deposit') )
@section('section')  

<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container" id="investor-deposit">
		@var $editclass = ""
		@var $addclass  = ""
		@var $viewclass = ""
		@if($adminInvDepViewMod->processbuttontype == "edit")
					@var $editclass = "disabled"
		@elseif($adminInvDepViewMod->processbuttontype == "add")		
					@var $addclass  = "disabled"
		@else
					@var $viewclass = "disabled"
		@endif
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Enter the Investor Deposit')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
			
			<div class="row"><!-- Row 1 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Investor Name')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					@if($editclass || $viewclass)
							{{ Form::select('active_investors', $adminInvDepViewMod->allactiveinvestList, $adminInvDepViewMod->allactiveinvestvalue, ["class" => "selectpicker disabled" ] )  }} 
					@else
							{{ Form::select('active_investors', $adminInvDepViewMod->allactiveinvestList, $adminInvDepViewMod->allactiveinvestvalue, ["class" => "selectpicker" ]) }} 
			
					@endif
			
				</div>	
			
						
			</div> <!-- Row 1 -->
			
			<div class="row"><!-- Row 2 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Deposit Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="deposit_date" 
								type="text" 
								class="deposit_date form-control" 
								name="deposit_date"									
								value="{{$adminInvDepViewMod->deposit_date}}" 
								{{$viewclass}} />

						<label for="deposit_date" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>				
							
					
			</div> <!-- Row 2 -->
			
			<div class="row"><!-- Row 3 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Deposit Amount') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">					
						<input 	id="deposit_amount" 
								type="text" 
								class="deposit_amount form-control text-right " 
								name="deposit_amount"									
								value="{{$adminInvDepViewMod->deposit_amount}}" 
								{{$viewclass}} />						
				</div>
							
							
			</div> <!-- Row 3 -->
						
			
			<div class="row"><!-- Row 4 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Transcation Reference No') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-5">					
						<input 	id="trans_ref_no" 
								type="text" 
								class="trans_ref_no form-control " 
								name="trans_ref_no"									
								value="{{$adminInvDepViewMod->trans_ref_no}}" 
								{{$viewclass}}  />						
				</div>
			</div> <!-- Row 4 -->
			
			<div class="row"><!-- Row 5-->	
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Remarks')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-5">
					<textarea 	rows="3" 
								class="form-control " {{$viewclass}} 
								>{{$adminInvDepViewMod->remarks}}</textarea>	
				</div>	
			</div> <!-- Row 5 -->
			@if($adminInvDepViewMod->processbuttontype != "view")
				<div class="row">
					<div class="col-lg-12 space-around">
						<div class="form-group">	
							<button class="btn verification-button" {{$viewclass}} >
								{{ Lang::get('Save')}}
							</button>
							<button class="btn verification-button" {{$viewclass}} >
								{{ Lang::get('Approve')}}
							</button>
						</div>
					</div>
				</div>			
			@endif
		</div>
		
	</div>				
</div>

@endsection  
@stop
