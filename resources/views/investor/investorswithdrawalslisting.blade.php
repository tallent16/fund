@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function(){ 
			// date picker
			$('#fromdate').datetimepicker({
				autoclose: true, 
				minView: 2,
				format: 'dd-mm-yyyy' 
				}); 	
			$('#todate').datetimepicker({
				autoclose: true, 
				minView: 2,
				format: 'dd-mm-yyyy' 
				}); 
		}); 
		$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})
	</script>
@endsection
@section('page_heading',Lang::get('Investor Withdrawals') )
@section('section')  
<div class="col-sm-12 space-around">
	<form method="get">
	<div class="row">	
		
		<div class="col-sm-3 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('Filter Status')}}</strong><br>								
					{{ Form::select('filter_status', ['all' => 'All'] +$InvWithDrawListMod->allTransList, 
								$InvWithDrawListMod->filter_status, 
								["class" => "selectpicker",
								"filter_field" => "Yes"]) 
					}} 
			</div>	
		</div>
				
		<div class="col-sm-3 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$InvWithDrawListMod->fromDate}}" 
						type="text" filter_field = "Yes" class="fromdate form-control" />
			</div>	
		</div>

		<div class="col-sm-3 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$InvWithDrawListMod->toDate}}"
						type="text" filter_field = "Yes" class="todate form-control" />
			</div>	
		</div>

		<div class="col-sm-3 col-lg-3"> 
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
			@var	$Url	=	url('investor/withdrawal/')
			@var	$addUrl	=	$Url."/add/0"
			<a 	href="{{$addUrl}}"
				class="btn verification-button">
				{{ Lang::get('New Withdrawal')}}
			</a>
		</div>
	</div>		
	
	<div class="panel panel-primary panel-container borrower-admin space-around">						
	
		<form method="post" id="form-investor-listing">
			
			<div class="table-responsive">
				<table class="table tab-fontsize text-left">
					<thead>
						<tr>
							<th class="tab-head text-left">
								{{Lang::get('Request Date')}}</th>
							<th class="tab-head text-left">
								{{Lang::get('Settlement Date')}}</th>
							<th class="tab-head text-right">
								{{Lang::get('Amount')}}</th>							
							<th class="tab-head text-left">
								{{Lang::get('Status')}}</th>
							<th class="tab-head text-left">
								{{Lang::get('Actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@if (count($InvWithDrawListMod->withdrawListInfo) > 0)			
							@foreach($InvWithDrawListMod->withdrawListInfo as $withdrawListRow)
								@var	$invUrl	=	url('investor/withdrawal/')
								@var	$invaddUrl	=	$invUrl."/add/0"
							
								@var	$inveditUrl	=	$invUrl."/edit/".base64_encode($withdrawListRow->payment_id)
								
								@var	$invviewUrl	=	$invUrl."/view/".base64_encode($withdrawListRow->payment_id)
								
								<tr>
									<td>
										<a href="{{$inveditUrl}}">
											{{$withdrawListRow->entry_date}}
										</a>
									</td>
									<td>
										<a href="{{$inveditUrl}}">
											{{$withdrawListRow->trans_date}}
										</a>
									</td>
									<td class="text-right">
										<a href="{{$inveditUrl}}">
											{{number_format($withdrawListRow->trans_amount,2,'.',',')}}
										</a>
									</td>
									<td>
										<a href="{{$inveditUrl}}">
											{{$withdrawListRow->trans_status_name}}
										</a>
									</td>								
									<td>
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
															{{ Lang::get('Add Withdrawals') }}
														</a>
													</li> 
													<li>													
														<a href="{{$inveditUrl}}">
															<i class="fa fa-user fa-fw"></i>
															{{ Lang::get('Edit Withdrawals') }}
														</a>
													</li> 
													<li>													
														<a href="{{$invviewUrl}}">
															<i class="fa fa-user fa-fw"></i>
															{{ Lang::get('View Withdrawals') }}
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
