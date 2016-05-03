@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-investor-listing.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('Investor Deposit') )
@section('section')  
<div class="col-sm-12 space-around">
	<form method="get">
	<div class="row">	
		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('Filter Status')}}</strong><br>								
					{{ Form::select('filter_status', $adminInvDepListMod->allTransList, 
													$adminInvDepListMod->filter_status, 
													["class" => "selectpicker"]) 
					}} 
			</div>	
		</div>
				
		<div class="col-sm-4 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$adminInvDepListMod->fromDate}}" 
						type="text" class="fromdate form-control" />
			</div>	
		</div>

		<div class="col-sm-4 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$adminInvDepListMod->toDate}}"
						type="text" class="todate form-control" />
			</div>	
		</div>

		<div class="col-sm-4 col-lg-3"> 
			<div class="form-group space-around">
				<button class="btn verification-button">
							{{ Lang::get('Apply Filter')}}
				</button>
			</div>
		</div>
		
	</div>
	</form>
	
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">	
						<button class="btn verification-button"
								id="bulk_approve_button">
							{{ Lang::get('Approve Selected')}}
						</button>
						<button class="btn verification-button"
								id="bulk_unapprove_button">
							{{ Lang::get('UnApprove Selected')}}
						</button>
						@var	$Url	=	url('admin/investordepositview/')
						@var	$addUrl	=	$Url."/add/0/0/"
						<button class="btn verification-button"
								data-url="{{$addUrl}}"
								id="new_button">
							{{ Lang::get('New Deposit')}}
						</button>
						<button class="btn verification-button"
								id="bulk_delete_button">
							{{ Lang::get('Delete Selected')}}
						</button>
					</div>
				</div>
			</div>
			
			<div class="panel panel-primary panel-container borrower-admin">					
					
				<form method="post" id="form-investor-listing" action="{{url('admin/investordepositlist/bulkaction')}}">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="processType" id="processType" value="">				
				<input 	type="hidden" 
						name="default_verified_applicable" 
						id="default_verified_applicable" 
						value="{{INVESTOR_BANK_TRANS_STATUS_VERIFIED}}">				
				<input 	type="hidden" 
						name="default_unverified_applicable" 
						id="default_unverified_applicable" 
						value="{{INVESTOR_BANK_TRANS_STATUS_UNVERIFIED}}">				
				
				<div class="table-responsive">
					<table class="table tab-fontsize text-left">
						<thead>
							<tr>
								<th class="tab-head text-center">									
										<label>
											<input 	type="checkbox" 
													id="select_all_list"
													class="select"											
													value="">
										</label>										
								</th>
								<th class="tab-head text-left">
									{{Lang::get('Investor Name')}}</th>
								<th class="tab-head text-left">
									{{Lang::get('Deposit Date')}}</th>
								<th class="tab-head text-right">
									{{Lang::get('Deposit Amount')}}</th>							
								<th class="tab-head text-left">
									{{Lang::get('Status')}}</th>
								<th class="tab-head text-center">
									{{Lang::get('Actions')}}</th>
							</tr>
						</thead>
						<tbody>
							@if (count($adminInvDepListMod->depositListInfo) > 0)			
								@foreach($adminInvDepListMod->depositListInfo as $depositListRow)
								
									@var	$invUrl	=	url('admin/investordepositview/')
									@var	$invaddUrl	=	$invUrl."/add/0/".base64_encode($depositListRow->investor_id)
									@var	$inveditUrl	=	$invUrl."/edit/".base64_encode($depositListRow->payment_id)."/"
									@var	$inveditUrl	=	$inveditUrl.base64_encode($depositListRow->investor_id)
									@var	$invviewUrl	=	$invUrl."/view/".base64_encode($depositListRow->payment_id)."/"
									@var	$invviewUrl	=	$invviewUrl.base64_encode($depositListRow->investor_id)
									<tr>
										<td class="text-center">									
												<input 	type="checkbox" 
														name="transaction_id[]"
														class="select_investor_deposit"											
														data-investor-name="{{$depositListRow->firstname}}"
														data-depositDate="{{$depositListRow->trans_date}}"
														data-depositAmount="{{$depositListRow->trans_amount}}"
														data-status="{{$depositListRow->status}}"
														value="{{$depositListRow->trans_id}}" />
											</label>									
										</td>
										<td>
											<a href="{{$inveditUrl}}">
												{{$depositListRow->firstname}}
											</a>
										</td>
										<td>
											<a href="{{$inveditUrl}}">
												{{$depositListRow->trans_date}}
											</a>
										</td>
										<td class="text-right">
											<a href="{{$inveditUrl}}">
												{{number_format($depositListRow->trans_amount,2,'.',',')}}
											</a>
										</td>
										<td>
											<a href="{{$inveditUrl}}">
												{{$depositListRow->trans_status_name}}
											</a>
										</td>								
										<td class="text-center">
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" 
														data-toggle="dropdown" href="#">
														<i class="fa fa-caret-down fa-fw action-style"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li>													
															<a href="{{$invaddUrl}}">
																<i class="fa fa-user fa-fw"></i>
																{{ Lang::get('Add Deposit') }}
															</a>
														</li> 
														<li>													
															<a href="{{$inveditUrl}}">
																<i class="fa fa-user fa-fw"></i>
																{{ Lang::get('Edit Deposit') }}
															</a>
														</li> 
														<li>													
															<a href="{{$invviewUrl}}">
																<i class="fa fa-user fa-fw"></i>
																{{ Lang::get('View Deposit') }}
															</a>
														</li> 
													</ul>
												</li>
											</ul>
										</td>
									</tr>
								@endforeach
							@endif	
						</tbody>
					</table>					
				</div>		
				</form>			
			</div>	<!---panel-->

</div>
	@endsection  
@stop
