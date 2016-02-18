@extends('layouts.applyloan-dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading','Apply Loan')
@section('section')     

		<div class="col-sm-12"> 			
			<div class="row">				
				<div class="col-lg-12 col-md-6">				
						
							<div class="row">
								 <ul class="nav nav-tabs">
									<li class="active"><a href="#loans_info">LOANS INFO</a></li>
									<li><a href="#documents_submitted">DOCUMENTS TO BE SUBMITTED</a></li>								
								</ul>					

							<div class="tab-content">
								<div id="loans_info" class="tab-pane fade in active">
									<div class="panel panel-default applyloan">   
										<div class="panel-body">
											<div class="text-center">
											<p>We are happy to help you to get a loan quickly.</p>
											<p>This process will take about 10mins to complete.</p>
											<hr>
											</div>
											
											<div class="row">
											   <div class="col-md-6">
												    <p>Purpose of Loan</p>
												   	<textarea id="txtEditor"></textarea> 
												   
											<form class="form-inline">	
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Loan Amount:</label>												
													</div>
																				
													<div class="col-xs-8">													
														<input type="text" class="form-control select-width" >												
													</div>
												</div>
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Tenure of Loan:</label>												
													</div>
																				
													<div class="col-xs-8">													
														<input type="text" class="form-control select-width" >												
													</div>
												</div>
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Target Interest%:</label>												
													</div>
																				
													<div class="col-xs-8">													
														<input type="text" class="form-control select-width" >												
													</div>
												</div>
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Bid Type:</label>												
													</div>
																				
													<div class="col-xs-8">													
														<select class="form-control select-width" id="sel1">
														<option>Please Select</option>
														<option>Bid type</option>
														<option>Bid type</option>
														<option>Bid type</option>
														</select>												
													</div>
												</div>
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Bid Close Date:</label>												
													</div>
																				
													<div class="col-xs-8">														 
														<div class="controls">
															<div class="input-group">
																<input id="date-picker-2" type="text" class="date-picker form-control" />
																<label for="date-picker-2" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
																</label>
															</div>
														</div>																			
													</div>
												</div>
												
											<div class="row">		
													<div class="col-xs-4">											
														<label>Accept Partial Subscription :</label>												
													</div>
																				
													<div class="col-xs-8">														 
														<label class="radio-inline"><input type="radio" name="optradio">Yes</label>
														<label class="radio-inline"><input type="radio" name="optradio">No</label>
														 														
													</div>
												</div>	
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Minimum limit for Accepting Partial Subscription :</label>												
													</div>
																				
													<div class="col-xs-8">														 
														<input type="text" class="form-control select-width" >	
														 														
													</div>
												</div>	
												
												<div class="row">		
													<div class="col-xs-4">											
														<label>Payment Type:</label>												
													</div>
																				
													<div class="col-xs-8">													
														<select class="form-control select-width" id="sel1">
														<option>Please Select</option>
														<option>Payment type</option>
														<option>Payment type</option>
														<option>Payment type</option>
														</select>												
													</div>
												</div>
												
											</form>											
											   </div>
											   
										<div class="col-md-6">
											 
										<div class="panel-primary panel-container">
											<div class="panel-heading panel-headsection"><!--panel head-->
												<div class="row">
													<div class="col-sm-12">
														<span class="pull-left">Applied Loan Summary:</span> 
													</div>																
												</div>							
											</div>
										</div>
													
										<div class="table-responsive"><!---table start-->
											<table class="table table-bordered .tab-fontsize text-left">		
												<tbody>
													<tr>
														<td class="col-md-3">Purpose of Loan:</td>
														<td class="col-md-3">To increase our current car fleet for personal and corporate services.</td>		
													</tr>
													<tr>
														<td class="col-md-3">Loan Amount:</td>
														<td class="col-md-3">$1,000,00</td>		
													</tr>
													<tr>
														<td class="col-md-3">Tensure of Loan:</td>
														<td class="col-md-3">12</td>		
													</tr>
														<tr>
														<td class="col-md-3">Targer Interest%:</td>
														<td class="col-md-3">10%</td>		
													</tr>
														<tr>
														<td class="col-md-3">Bid type:</td>
														<td class="col-md-3">Open bidding</td>		
													</tr>
														<tr>
														<td class="col-md-3">Bid Close date:</td>
														<td class="col-md-3">01 JAN 2016</td>		
													</tr>	
														<tr>
														<td class="col-md-3">Accept partial subscription:</td>
														<td class="col-md-3">YES</td>		
													</tr>	
													<tr>
														<td class="col-md-3">Minimum limit for accepting Partial Subscription:</td>
														<td class="col-md-3">$1,000,00</td>		
													</tr>
													<tr>
														<td class="col-md-3">Payment Type:</td>
														<td class="col-md-3">One Time or Bullet</td>		
													</tr>													
												</tbody>
											</table>
											</div>
											
											
											<div class="row">							
												<div class="col-sm-12"> 
													<div class="pull-right">	
														<button type="submit" class="add-director-button">Next</button>
													</div>
												</div>
											</div>
											   </div>
											   
											</div>
											
										</div>
									</div>
								</div>
							<div id="documents_submitted" class="tab-pane fade">
							  <div class="panel panel-default applyloan">   
								<div class="panel-body">
									</br>
									<div class="col-sm-12">
										<span class="pull-left"><strong>Documents to be Submitted:</strong></span>								
										</br><hr></br>
										<ol>	
											<div class="row">
												<li><div class="col-sm-9">
													Past 2 Years Financial Statements. Audited where applicable. [Full Set: P&L,Cashflow and Balance Sheet]. They must not be more than 1 Year from current date of submission.
												</div>
												<div class="col-sm-3">
													<input type="file" class="file-loading" >
												</div></li>
											</div>		
											<div class="row">															
												<li><div class="col-sm-9">
														All Company Bank Statements for the Past 6 months (backtracked from the current date of submission). 
													</div>
													<div class="col-sm-3">										
														 <input type="file" class="file-loading" >										
													</div>
												</li></div>
											<div class="row">		
											<li>
												<div class="col-sm-9">
													Corporate Bank Account Details
													<ol class="list-type">
														<li>
															With the account holder's name, local trading address and account number
														</li>
														<li>
															If local trading address is not available on the bank statements, please provide utility bill (dated within 6 months) in addition to the bank statements as proof pf local trading address.  
														</li>
													</ol>
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												Details of outstanding loans from other banks and its repayment track
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												A copy of Credit Bureau Singapore Report
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
												<li>
												<div class="col-sm-9">
													Proof of ID of Directors/Partners
													<ol class="list-type">											
														<li>Personal: SC/PR:IC</li>
														<li>Foreign: PP,EP,DP,SP</li>
													</ol>
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												M&AA/LLP Agreement (signed on first page)
												
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												Most Recent Income Tax Notice of Assessment of Guarantor
												
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												Lastest ACRA Biz File (or equivalent)
												
												</div>
												<div class="col-sm-3">										
													 <input type="file" class="file-loading" >										
												</div>
											</li></div>
											<div class="row">	
											<li>
												<div class="col-sm-9">
												Most Current Management Accounts						
												</div>
												<div class="col-sm-3">	
													<label class="btn btn-primary" for="my-file-selector">
    <input id="my-file-selector" type="file" style="display:none;">
    Button Text Here
</label>									
													 <input type="file" class="fileloading" value="File Attach" data-buttonText="Attach File" >										
												</div>
													
											</li></div>
										</ol>																		
									</div>
							
								<div class="col-sm-1 text-right">
									<input type="submit" name="" class="add-director-button select-width"  value="Submit">	
								</div>						
							
							</div>
						</div>                 
	
					</div>
				</div>
  												
	</div>	<!--end panel head-->							
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
	$(document).ready(function(){
		$(".nav-tabs a").click(function(){
			$(this).tab('show');
		});
		$('.nav-tabs a').on('shown.bs.tab', function(event){
			var x = $(event.target).text();         // active tab
			var y = $(event.relatedTarget).text();  // previous tab
			$(".act span").text(x);
			$(".prev span").text(y);
		});
		
		$(".date-picker").datepicker();

$(".date-picker").on("change", function () {
    var id = $(this).attr("id");
    var val = $("label[for='" + id + "']").text();
    $("#msg").text(val + " changed");
});
		
		$(":file").fileloading({buttonText: "Attach File"});
	});
</script>
    @endsection  
@stop
