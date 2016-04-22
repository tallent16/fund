@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	@endsection
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  
<div class="col-sm-12 space-around">
	
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">	
						<button class="btn verification-button">
							{{ Lang::get('Approve Selected')}}
						</button>
					</div>
				</div>
			</div>
			
			<div class="panel panel-primary panel-container borrower-admin">						
					
				<div class="table-responsive">
					<table class="table tab-fontsize text-left">
						<thead>
							<tr>
								<th class="tab-head text-center col-sm-1">									
										<label>
											<input 	type="checkbox" 
													name="id"
													class="select"											
													value="">
										</label>										
								</th>
								<th class="tab-head text-left col-sm-2">
									{{Lang::get('Loan Reference')}}</th>
								<th class="tab-head text-left col-sm-2">
									{{Lang::get('Scheduled Date')}}</th>
								<th class="tab-head text-left col-sm-2">
									{{Lang::get('Actual Date')}}</th>
								<th class="tab-head text-right col-sm-2">
									{{Lang::get('Installment Amount')}}</th>
								<th class="tab-head text-right col-sm-1">
									{{Lang::get('Penalty')}}</th>
								<th class="tab-head text-left col-sm-1">
									{{Lang::get('Status')}}</th>
								<th class="tab-head text-left col-sm-1">
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
									{{Lang::get('L-2016-28')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('12,345.00')}}
								</td>
								<td class="text-right">
									{{Lang::get('2,500.00')}}
								</td>
								<td>
									{{Lang::get('Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit/Approve') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Approve Selected') }}
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
									{{Lang::get('L-2016-28')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('12,345.00')}}
								</td>
								<td class="text-right">
									{{Lang::get('2,500.00')}}
								</td>
								<td>
									{{Lang::get('Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit/Approve') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Approve Selected') }}
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
									{{Lang::get('L-2016-28')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td>
									{{Lang::get('01-04-2016')}}
								</td>
								<td class="text-right">
									{{Lang::get('12,345.00')}}
								</td>
								<td class="text-right">
									{{Lang::get('2,500.00')}}
								</td>
								<td>
									{{Lang::get('Approved')}}
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
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Edit/Approve') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('View') }}
													</a>
												</li> 
												<li>													
													<a href="">
														<i class="fa fa-user fa-fw"></i>
														{{ Lang::get('Approve Selected') }}
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
			</div>	<!--panel-->

</div>
	@endsection  
@stop
