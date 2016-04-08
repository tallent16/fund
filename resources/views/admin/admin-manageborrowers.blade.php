@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Manage Borrowers') )
@section('section')  
<div class="col-sm-12 space-around">
	<div class="row">
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="panel panel-primary panel-container">
				
					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-3">
								<span class="pull-left">{{ Lang::get('Borrowers List') }}</span> 
							</div>									
						</div>                           
					</div>				
					<div class="table-responsive">
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">																			
										<label><input type="checkbox" value="Select All">Select All</label>											
									</th>
									<th class="tab-head">{{ Lang::get('Email Id') }}</th>
									<th class="tab-head">{{ Lang::get('Business Name') }}</th>
									<th class="tab-head">{{ Lang::get('Contact Person') }}</th>
									<th class="tab-head">{{ Lang::get('Industry') }}</th>
									<th class="tab-head text-right">{{ Lang::get('Number of Active Loans') }}</th>
									<th class="tab-head text-right">{{ Lang::get('Total Balance Outstanding') }}</th>
									<th class="tab-head">{{ Lang::get('Status') }}</th>
									<th class="tab-head">{{ Lang::get('Actions') }}</th>									
								</tr>
							</thead>
							<tbody>							
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
									<tr>
										<td>
											<div class="checkbox">
												<label><input type="checkbox" value=""></label>
											</div>
										</td>
										<td>email@mail.com</td>
										<td>ABC</td>
										<td>Ashok</td>
										<td>Industry</td>
										<td class="text-right">5</td>
										<td class="text-right">5000</td>
										<td>Active</td>
										<td>
											<ul class="list-unstyled">
												<li class="dropdown">
													<a class="dropdown-toggle" data-toggle="dropdown" href="#">
														<i class="fa fa-edit fa-fw"></i> 
													</a>
													<ul class="dropdown-menu dropdown-user">
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Approve') }}</a>
														</li>  
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
														</li>
														<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('View/Edit') }}</a>
														</li>                     
													</ul>	
												</li>
											</ul>											
										</td>										
									</tr>	
							</tbody>
						</table>						
					</div><!-----third row end--->	
					
					
					
		
			</div>     
			<div class="row">
					<div class="col-sm-12">
						
						
								<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Approval')}}
								</button>
							<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Reject')}}
								</button>
								<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Delete')}}
								</button>
								<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('View/Edit')}}
								</button>
						</div>
										
					</div>		
		</div>
		</div>
	</div>
</div>


@endsection  
@stop
