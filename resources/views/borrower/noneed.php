@extends('layouts.profile-dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','Profile')
@section('section')          

        <div class="col-sm-12"> 
			<div class="pull-right">	
				<button type="submit" class="status-button"><i class="fa pull-right"></i>STATUS</button>
             </div>
        </div>            
        
		<div class="col-sm-12"> 			
			<div class="row">				
				<div class="col-lg-12 col-md-6">
					<div class="panel-primary panel-container">
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-sm-3">
									<span class="pull-left">COMPANY INFO</span> 
								</div>
								<div class="col-sm-9">
									<span class="pull-left">DIRECTORS INFO</span> 
								</div>															
							</div>														
						</div>	<!--end panel head-->							
					</div>
					
					<div class="panel panel-default directorinfo"> 
						<div class="panel-body">
							</br>
							<div class="col-sm-5">
								<span class="pull-left">Detailed Company Profile <i class="fa fa-edit fa-fw"></i></span>
								</br></br>
								<form role="form">
									<div class="form-group">
										<textarea class="form-control" rows="10" id="comment">Leap Networks is a telecommunication systems engineering and systems integration company that provides high availabilty dedicated Telecommunication Networks Infrastructure for mission critical industrial environments and operationally demanding applications such as Oil & Gas Mining, Petrochemical and Transport Industries.</textarea>
									</div>
								</form>															
							</div>
								
							<div class="col-sm-7">	</br>		
								<form class="form-inline">	
									<div class="row">		
											<div class="col-xs-3">											
												<label>Add Director</label>												
											</div>
																		
											<div class="col-xs-6">													
												<input type="text" class="form-control select-width" id="director">												
											</div>
											
											<div class="col-xs-3">												
												<input type="button" value="Add" class="add-director-button select-width">												
											</div>
									</div></br>
									
									<div class="row">	
										<div class="col-xs-3">																				
											<label>Select:</label>											
										 </div>	
										 									 
										<div class="col-xs-9">										  
											<select class="form-control select-width" id="sel1">
											<option>Please Select Directors</option>
											<option>2</option>
											<option>3</option>
											<option>4</option>
											</select>											
										</div>										
									</div>
								</form>		
								</br></br>
								<div class="row">	
									<div class="col-xs-12">
										
										<div class="panel-primary panel-container">
											<div class="panel-heading panel-headsection"><!--panel head-->
												<div class="row">
													<div class="col-sm-12">
														<span class="pull-left"><i class="fa fa-times fa-fw"></i></span> 
													</div>																
												</div>							
											</div>
										</div>
										
										<div class="table-responsive"><!---table start-->
											<table class="table table-bordered .tab-fontsize text-left">		
												<tbody>
													<tr>
														<td class="col-md-3">Director's Information</td>
														<td class="col-md-3"><div class="col-xs-10">Tarek brings him more than 25years of solid experience managing global telecoms engineering projects.</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>
													<tr>
														<td class="col-md-3">Director's Name</td>
														<td class="col-md-3"><div class="col-xs-10">Tarek Nuvali</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>
													<tr>
														<td class="col-md-3">Age</td>
														<td class="col-md-3"><div class="col-xs-10">28</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>
														<tr>
														<td class="col-md-3">Period since in this business</td>
														<td class="col-md-3"><div class="col-xs-10">2008</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>
														<tr>
														<td class="col-md-3">Overall experience in years</td>
														<td class="col-md-3"><div class="col-xs-10">8 Years</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>
														<tr>
														<td class="col-md-3">Accomplishments/Other info</td>
														<td class="col-md-3"><div class="col-xs-10">Business awards</br>DP SME 1000 2015</div><div class="col-xs-2"><i class="fa fa-edit fa-fw"></i></div></td>		
													</tr>													
												</tbody>
											</table>
											
											<div class="text-center">
												<ul class="pagination">
													<li><a href="#"><i class="fa fa-chevron-circle-left"></i></a></li>
													<li><a href="#"><i class="fa fa-chevron-circle-right"></i></a></a></li>	
												</ul>
											</div>
											
										</div>
									</div>
								</div>
								
								
							</div>	
						</div>
					</div>
					
					<div class="row">							
						<div class="col-sm-12"> 
							<div class="pull-right">	
								<button type="submit" class="verification-button"><i class="fa pull-right"></i>Submit for verification</button>
							</div>
						</div>
					</div>
				</div>
                </div>  
                
				<div class="row annoucement-msg-container">
					<div class="alert alert-danger annoucement-msg">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						Comments/Remarks:Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					</div>
				</div>
    @endsection  
@stop
