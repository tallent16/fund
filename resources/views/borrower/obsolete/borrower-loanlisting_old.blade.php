@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>		
@endsection
@section('page_heading','Loan Listing')
@section('section')     
<div class="col-sm-12 text-center space-around">
	<div class="annoucement-msg-container">
		<div class="alert alert-success annoucement-msg">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h4>We are here to help you find the best loans to find.</h4>	
		</div>
	</div>				
</div>
<div class="col-sm-12 loanlist-wrapper"> 			
	<div class="row">	
		
		<div class="row"> 
			<div class="col-sm-12"> 
				
			<div class="col-sm-12 col-lg-6"> 
					<div class="col-sm-6"> 														
						<div class="form-group">								
							<select class="selectpicker">
							<option>Interest Rate</option>
							<option>More than 18%</option>
							<option>More than 28%</option>
							<option>More than 38%</option>
							</select>
						</div>	
					</div>
				
					<div class="col-sm-6 col-xs-6 text-right"> 														
						<div class="form-group">								
							<select class="selectpicker">
							<option>Loan Amount</option>
							<option>Greater than $200,000</option>
							<option>Greater than $300,000</option>
							<option>Greater than $400,000</option>
							</select>
						</div>	
					</div>
				</div>
				<!-------first two dropdown--ends--->
				<div class="col-sm-12 col-lg-6"> 
					<div class="col-sm-6"> 														
						<div class="form-group">							
							<select class="selectpicker">
							<option>Loan Duration</option>
							<option>Less than 2 Year</option>
							<option>Less than 3 Year</option>
							<option>Less than 4 Year</option>
							</select>
						</div>	
					</div>
				
					<div class="col-sm-6 col-xs-6 text-right"> 														
						<div class="form-group">								
							<select class="selectpicker">
							<option>Credit Rating</option>
							<option>B</option>
							<option>C</option>
							<option>D</option>
							</select>
						</div>	
					</div>
				</div>
				
			</div><!----col--12--->
		</div><!---row-->
		<!------header ----dropdown----ends----->
		
		<div class="row"> 
			<div class="col-sm-12">						
				<!----left block tables--------------->				
				<div class="col-sm-12 col-lg-6"> 	
					
					<div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
									<div class="imageoverlap">
										{{ Html::image('img/featured.png', '', array('class' => 'img-responsive')) }}
									</div>
									
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>

							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>		
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>											
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					 
					 <!---second --row--->
					 
					<div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>
							 
							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>				
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>									
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					 <!---second ---row --end-->
		
						<!---third row--->					
					
					   <div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>
							 
							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>		
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>											
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					
					<!---end third row--->
					 
										
				</div><!---col--6-->
				<!--------left ---table ----ends------------------------->	
				<!--------right ---table ----starts------------------------->	
				<div class="col-sm-12 col-lg-6"> 	
					
					<div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>
							 
							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>		
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>										
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					
					<!---second row--->
					
					
					   <div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>
							 
							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>			
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>											
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					
					<!---end second row--->
					
						<!---third row--->
					
					
					   <div class="col-sm-12"> 
						<div class="row loan-list-container">
							
							<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
								{{ Html::image('img/thumbnail.png', '', array('class' => 'thumbnail')) }}
							</div>
							 
							<div class="col-sm-12 col-lg-8 tab-head"> 	
								<div class="row">
									<div class="col-sm-10 col-xs-10 col-lg-11 title-loanlist"><div class="bidders-value">MKM Car Leasing pte Ltd</div><span>Transport Industry, Business Expanison</span></div>
									<div class="col-sm-2 col-xs-2 col-lg-1"><i class="fa fa-caret-right"></i></div>
								</div>			
								<div class="row panel-white">
									<div class="progress">
										<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
										aria-valuemin="0" aria-valuemax="100" style="width:70%">
										<span class="sr-only">70% Complete</span>
										</div>
									</div>
									<div class="table-responsive"><!---table start-->
										<table class="table">		
										<tbody>
										<tr>
										<td class="panel-subhead">42%</td>
										<td class="panel-subhead">$8,500,00</td>	
										<td class="panel-subhead">10%</td>	
										<td class="panel-subhead">255</td>	
										<td class="panel-subhead">C</td>				
										</tr>
										<tr>
										<td>Funded</td>
										<td>Loan amount</td>	
										<td>Interest</td>		
										<td>Days to go</td>	
										<td>Grade</td>			
										</tr>
										</tbody>
										</table>	
									</div>											
								</div>	<!--row- panel white-->
								<div class="row panel-footer">
									<div class="text-center">Type of Repayment: <span class="panel-subhead">Monthly Installments</span></div>											
								</div><!--row-->																							
							</div><!--col-8-->
							
							
						</div><!--row-->								
					 </div><!---col-12--->	
					
					<!---end third row--->
					
					
					
				</div><!---col--6-->
		
		     <!---------tables ends---------->		
		
		
			</div><!----col--12--->			
			<!----------pagination--------------->
				<div class="col-sm-12">
					<div class="col-sm-6"></div>
						<div class="col-sm-6">
							<div class="pull-right">
						
								<ul class="pagination">
								<li>
									<a href="#" aria-label="Previous">
									<span aria-hidden="true"><i class="fa fa-caret-left"></i></span>
									</a>
								</li>
								<li><a href="#">1</a></li>
								<li class="active"><a href="#">2</a></li>
								<li><a href="#">3</a></li>
								<li><a href="#">4</a></li>
								<li><a href="#">5</a></li>
								<li>
									<a href="#" aria-label="Next">
									<span aria-hidden="true"><i class="fa fa-caret-right"></i></span>
									</a>
								</li>
								</ul>
							</div>
						</div>
				</div>
                <!----------------pagination ends------------->
		</div><!---row-->								
	</div><!----col--12--->
</div><!---row-->

    @endsection  
@stop
