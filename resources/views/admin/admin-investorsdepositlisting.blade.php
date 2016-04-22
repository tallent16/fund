@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>		
	$(document).ready(function(){ 
	// date picker
	$('.fromdate').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
		}); 
	$('.todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd-mm-yyyy' 
	}); 
	}); 
	</script>
	@endsection
@section('page_heading',Lang::get('Investor Deposits') )
@section('section')  
<div class="col-sm-12 space-around">
	
	<div class="row">	
		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('Filter Status')}}</strong><br>	
				 <select class="form-control" >
					<option>All</option>
					<option>Approved</option>
					<option>UnApproved</option>
				 </select>
			</div>	
		</div>
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="" 
						type="text" class="fromdate form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date') }}</strong><br>							
				<input id="todate" name="todate" value=""
						type="text" class="todate form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group space-around">
				<button class="btn verification-button">
							{{ Lang::get('Apply Filter')}}
				</button>
			</div>
		</div>
		
	</div>
	
	
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">	
						<button class="btn verification-button">
							{{ Lang::get('Approve Selected')}}
						</button>
						<button class="btn verification-button">
							{{ Lang::get('UnApprove Selected')}}
						</button>
						<button class="btn verification-button">
							{{ Lang::get('New Deposit')}}
						</button>
						<button class="btn verification-button">
							{{ Lang::get('Delete Selected')}}
						</button>
					</div>
				</div>
			</div>
			
			<div class="panel panel-primary panel-container borrower-admin">						
					
				<div class="table-responsive">
					<table class="table tab-fontsize text-left">
						<thead>
							<tr>
								<th class="tab-head text-center">									
										<label>
											<input 	type="checkbox" 
													name="id"
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
								<th class="tab-head text-left">
									{{Lang::get('Actions')}}</th>
							</tr>
						</thead>
						<body>
							<tr>
								<td class="text-center">									
									<label>
										<input 	type="checkbox" 
												name="id"
												class="select"											
												value="">
									</label>									
								</td>
								<td>
									{{Lang::get('Investor 1')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('999,99.00')}}
								</td>
								<td>
									{{Lang::get('Not Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Add Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View Deposit') }}
													</a>
												</li> 
											</ul>
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="text-center">									
									<label>
										<input 	type="checkbox" 
												name="id"
												class="select"											
												value="">
									</label>									
								</td>
								<td>
									{{Lang::get('Investor 1')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('999,99.00')}}
								</td>
								<td>
									{{Lang::get('Not Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Add Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View Deposit') }}
													</a>
												</li> 
											</ul>
										</li>
									</ul>
								</td>
							</tr>
							<tr>
								<td class="text-center">									
									<label>
										<input 	type="checkbox" 
												name="id"
												class="select"											
												value="">
									</label>									
								</td>
								<td>
									{{Lang::get('Investor 1')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('999,99.00')}}
								</td>
								<td>
									{{Lang::get('Not Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Add Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit Deposit') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View Deposit') }}
													</a>
												</li> 
											</ul>
										</li>
									</ul>
								</td>
							</tr>
						</body>
					</table>					
				</div>					
			</div>	<!---panel-->

</div>
	@endsection  
@stop
