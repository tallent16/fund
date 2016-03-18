@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Banking') 
@section('status_button')						
		<!--------Status Button Section---->		
			  <h4><span class="label label-default status-label">Status</span></h3>														
@endsection
@section('section')    
<div class="col-sm-12 space-around bank-details"> 			
		<div class="panel panel-primary panel-container">	
					
				<div class="panel-heading panel-headsection"><!--panel head-->
					<div class="row">
						<div class="col-xs-12">
							<span class="pull-left">Bank Details</span> 
						</div>													
					</div>							
				</div><!--end panel head-->
				
				
										
				<div class="table-responsive"><!---table start-->
					<div class="bank-list" id="" >
						<table class="table table-loan text-left .tab-fontsizebig">							
							<tbody>
								<tr>
									<td class="tab-left-head col-md-3"><span>Bank Code</span></td>
									<td class="col-md-3">
										<input type="text" name="bank_code" value="1000" class="form-control">
									</td>
									<td class="col-md-6"></td>
								</tr>
								<tr>
									<td class="tab-left-head">Bank Name</td>
									<td><input type="text" name="bank_name" value="OCBC Bank"  class="form-control"></td>
									<td border="0"></td>
								</tr>
								<tr>
									<td class="tab-left-head">Branch Code</td>
									<td><input type="text" name="bank_code" value="501"  class="form-control"></td>
									<td></td>
								</tr>
								<tr>
									<td class="tab-left-head">Bank Account Number</td>
									<td><input type="text" name="bank_account_number" value="5011234567"  class="form-control"></td>
									<td></td>
								</tr>	
								<tr>
									<td class="tab-left-head">Active Status</td>
									<td>Inactive</td>
									<td></td>
								</tr>
								<tr>
									<td class="tab-left-head">Verified Status</td>
									<td>Verified</td>
									<td></td>
								</tr>															
							</tbody>
						</table>	
					</div>
				</div><!---table end---> 
				
				<div class="pull-left">
					<ul class="pagination">
						<li>
							<a href="javascript:void(0)" id="prev">
								<i class="fa fa-chevron-circle-left"></i>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" id="next">
								<i class="fa fa-chevron-circle-right"></i>
								</a>
						</li>	
					</ul>
				</div>	
				
			</div><!-------panel------>	
				
			<div class="row"> 
					
				<div class="col-sm-12">	
					<div class="pull-right">							
						<button type="submit" class="btn button-orange">ADD</button>	
					</div>
					
				</div>
			</div>		
			
	
</div><!-----col 12------->
@endsection  
@stop 
