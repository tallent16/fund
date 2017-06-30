@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/admin-investor-withdrawalview.js') }}" type="text/javascript"></script>
	<script>		
		var	baseUrl	=	"{{url('')}}"	
	</script>
@endsection
@section('page_heading',Lang::get('Backer Withdrawals') )
@section('section') 
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$screenMode	=	"admin"
@else
	@var	$screenMode	=	"investor"
@endif

@var $editclass = ""
@var $addclass  = ""
@var $viewclass = ""
@if($adminInvWithDrawListMod->processbuttontype == "edit")
	@var $editclass = "disabled"
@elseif($adminInvWithDrawListMod->processbuttontype == "add")		
	@var $addclass  = "disabled"
@else
	@var $viewclass = "disabled"
@endif
@if($adminInvWithDrawListMod->status	==	INVESTOR_BANK_TRANS_STATUS_VERIFIED)
	@var $viewclass = "disabled"
@endif 

<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container" id="investor-withdrawal">
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Enter the Withdrawal Request')}}</span> 
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
						value="{{$adminInvWithDrawListMod->trans_id}}"/>	
				<input  type="hidden" 
						name="payment_id" 	
						value="{{$adminInvWithDrawListMod->payment_id}}"	/>			
				<input  type="hidden" 
						name="avail_bal" 
						id="avail_bal" 	
						value="{{number_format($adminInvWithDrawListMod->avail_bal,2,'.',',')}}"	/>			
				<input  type="hidden" 
						name="isSaveButton" 
						id="isSaveButton" 
						value=""/>
				<input  type="hidden" 
						name="submitType" 
						id="submitType" 
						value=""/>
				<input type="hidden" id="screen_mode" value="{{$screenMode}}">
				@if(Auth::user()->usertype	==	USER_TYPE_INVESTOR)
					<input  type="hidden" 
							name="investor_id" 
							id="investor_id" 
							value="{{$adminInvWithDrawListMod->investorId}}"/>
				@endif
			<fieldset {{$viewclass}} {{$editclass}} >
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<div class="row"><!-- Row 1 -->					
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>
								{{ Lang::get('Backer Name')}}
							</label>
						</div>								
						<div class="col-xs-12 col-sm-7 col-lg-3">
							@if($editclass || $viewclass)
								{{ Form::select('investor_id', $adminInvWithDrawListMod->allactiveinvestList, $adminInvWithDrawListMod->allactiveinvestvalue,  ["class" => "selectpicker disabled",
															"id"=>"investor_id" ,
															"data-live-search"=>true ] )  }} 
							@else
								{{ Form::select('investor_id', $adminInvWithDrawListMod->allactiveinvestList, $adminInvWithDrawListMod->allactiveinvestvalue, ["class" => "selectpicker",
																				"id"=>"investor_id",
																				"data-live-search"=>true ]) }} 
							@endif
						</div>							
					</div> <!-- Row 1 -->
					</fieldset>
					<fieldset {{$viewclass}}>
					<div class="row"><!-- Row 2 -->					
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>
								{{ Lang::get('Available Balance')}}
							</label>
						</div>								
						<div class="col-xs-12 col-sm-7 col-lg-3">
							<input 	id="avail_bal" 
										type="text" 
										class="avail_bal form-control text-right" 
										name="avail_bal"									
										value="{{number_format($adminInvWithDrawListMod->avail_bal,2,'.',',')}}" 
										disabled />		
						</div>
					</div> <!-- Row 2 -->
				@endif
				<div class="row"><!-- Row 3 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Request Date') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3 controls"  id="request_date_parent">
						<div class="input-group">
							<input 	id="request_date" 
									type="text" 
									class="request_date form-control" 
									name="request_date"									
									value="{{$adminInvWithDrawListMod->request_date}}" 
									readonly />

							<label for="request_date" class="input-group-addon btn">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Settlement Date') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3 controls">
						<div class="input-group">
							<input 	id="settlement_date" 
									type="text" 
									class="settlement_date form-control" 
									name="settlement_date"									
									value="{{$adminInvWithDrawListMod->settlement_date}}"
									readonly  />

							<label for="settlement_date" class="input-group-addon btn">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>
					</div>						
				</div> <!-- Row 3 -->
				
				<div class="row"><!-- Row 4 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Withdrawal Amount') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="withdrawal_amount_parent">					
							<input 	id="withdrawal_amount" 
									type="text" 
									class="withdrawal_amount form-control text-right amount-align" 
									name="withdrawal_amount"
									decimal=2									
									value="{{number_format($adminInvWithDrawListMod->withdrawal_amount,2,'.',',')}}" 
									/>						
					</div>							
				</div> <!-- Row 4 -->
							
				
				<div class="row"><!-- Row 5 -->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Transcation Reference No') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-5" id="trans_ref_parent">					
							<input 	id="trans_ref_no" 
									type="text" 
									class="trans_ref_no form-control" 
									name="trans_ref_no"									
									value="{{$adminInvWithDrawListMod->trans_ref_no}}" 
									/>						
					</div>
				</div> <!-- Row 5-->
				
				<div class="row"><!-- Row 6-->	
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Remarks')}}
						</label>
					</div>								
					<div class="col-xs-12 col-sm-7 col-lg-5">
						<textarea 	rows="3" 
									class="form-control"
									name="remarks">{{$adminInvWithDrawListMod->remarks}}</textarea>	
					</div>	
				</div> <!-- Row 6 -->
			</fieldset>
				@if($adminInvWithDrawListMod->processbuttontype != "view")
					<div class="row">
						<div class="col-lg-12 space-around">
							<div class="form-group">
								@if( ($adminInvWithDrawListMod->status	==	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED) 
									|| ($adminInvWithDrawListMod->processbuttontype	==	"add"))
									<button class="btn verification-button"
											id="save_button"											
											{{$viewclass}} >
										{{ Lang::get('Save')}}
									</button>
									@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
										@permission('approve.admin.investorswithdrawal')	
											<button class="btn verification-button" 
													id="approve_button"													
													{{$viewclass}} >
												{{ Lang::get('Approve')}}
											</button>
										@endpermission
									@endif
								@endif
								@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
									@if($adminInvWithDrawListMod->status	==	INVESTOR_BANK_TRANS_STATUS_VERIFIED)
										@permission('unapprove.admin.investorswithdrawal')	
											<button class="btn verification-button" 
													id="unapprove_button"													
													>
												{{ Lang::get('UnApprove')}}
											</button>
										@endpermission
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
