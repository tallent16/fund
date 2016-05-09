@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/admin-investor-depositview.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Investor Deposit') )
@section('section')  

@if($submitted)
	<div class="col-sm-12 space-around">
		<div class="annoucement-msg-container">
			<div class="alert alert-success">
				{{Lang::get('Investor Deposit Successfully Updated')}}
		</div>				
	</div>
@endif
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
		@if($adminInvDepViewMod->status	==	INVESTOR_BANK_TRANS_STATUS_VERIFIED)
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
			
			<form method="post" id="save_form_payment">
				<input  type="hidden" 
						name="_token"
						id="hidden_token"
						value="{{ csrf_token() }}" />
				<input  type="hidden" 
						name="tranType"
						value="{{$processtype}}" />	
				<input  type="hidden" 
						name="trans_id" 
						value="{{$adminInvDepViewMod->trans_id}}"/>	
				<input  type="hidden" 
						name="payment_id" 	
						value="{{$adminInvDepViewMod->payment_id}}"	/>	
				<input  type="hidden" 
						name="isSaveButton" 
						id="isSaveButton" 
						value=""/>
				<input  type="hidden" 
						name="submitType" 
						id="submitType" 
						value=""/>
				@if(Auth::user()->usertype	==	USER_TYPE_INVESTOR)
					<input  type="hidden" 
							name="investor_id" 
							id="investor_id" 
							value="{{$adminInvDepViewMod->investorId}}"/>
				@endif
				<fieldset {{$viewclass}}>
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<div class="row"><!-- Row 1 -->					
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>
								{{ Lang::get('Investor Name')}}
							</label>
						</div>								
						<div class="col-xs-12 col-sm-7 col-lg-3">
							@if($editclass || $viewclass)
									{{ Form::select('investor_id', $adminInvDepViewMod->allactiveinvestList, $adminInvDepViewMod->allactiveinvestvalue, ["class" => "selectpicker disabled" ] )  }} 
							@else
									{{ Form::select('investor_id', $adminInvDepViewMod->allactiveinvestList, $adminInvDepViewMod->allactiveinvestvalue, ["class" => "selectpicker" ]) }} 
					
							@endif				
						</div>
					</div> <!-- Row 1 -->
				@endif
				<div class="row"><!-- Row 2 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Deposit Date') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">
						<div class="controls">
						<div class="input-group">
							<input 	id="deposit_date" 
									type="text" 
									class="deposit_date form-control" 
									name="deposit_date"									
									value="{{$adminInvDepViewMod->deposit_date}}" 
									readonly />

							<label for="deposit_date" class="input-group-addon btn">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
							</div>
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
									class="deposit_amount form-control text-right amount-align" 
									name="deposit_amount"	
									decimal=2							
									value="{{number_format($adminInvDepViewMod->deposit_amount,2,'.',',')}}" 
									{{$viewclass}} />						
					</div>
				</div> <!-- Row 3 -->
							
				
				<div class="row"><!-- Row 4 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Transcation Reference No') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-5"  id="trans_ref_parent">					
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
									name="remarks"
									>{{$adminInvDepViewMod->remarks}}</textarea>	
					</div>	
				</div> <!-- Row 5 -->
				</fieldset>
				@if($adminInvDepViewMod->processbuttontype != "view")
					<div class="row">
						<div class="col-lg-12 space-around">
							<div class="form-group">
								@if( ($adminInvDepViewMod->status	==	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED) 
									|| ($adminInvDepViewMod->processbuttontype	==	"add"))
									<button class="btn verification-button"
											id="save_button"
											{{$viewclass}} >
										{{ Lang::get('Save')}}
									</button>
									@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
										<button class="btn verification-button" 
												id="approve_button"
												{{$viewclass}} >
											{{ Lang::get('Approve')}}
										</button>
									@endif
								@endif
								@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
									@if($adminInvDepViewMod->status	==	INVESTOR_BANK_TRANS_STATUS_VERIFIED)
										<button class="btn verification-button" 
												id="unapprove_button"
												>
											{{ Lang::get('UnApprove')}}
										</button>
									@endif
								@endif
							</div>
						</div>
					</div>			
				@endif
				
		</div>
		
	</div>				
</div>

@endsection  
@stop
