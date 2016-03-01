@extends('layouts.bankdetails-dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Banking') 
@section('section')    
<div class="col-sm-12"> 			
	<div class="panel panel-primary panel-container">	
					
				<div class="panel-heading panel-headsection"><!--panel head-->
					<div class="row">
						<div class="col-xs-12">
							<span class="pull-left">Bank Details</span> 
						</div>													
					</div>							
				</div><!--end panel head-->
										
				<div class="table-responsive"><!---table start-->
					<table class="table table-loan text-left table-bordered .tab-fontsizebig">							
						<tbody>
							<tr>
								<td class="tab-left-head col-md-3"><span>Bank Code</span></td>
								<td class="col-md-9"><span>1000</span></td>
							</tr>
							<tr>
								<td class="tab-left-head">Bank Name</td>
								<td>OCBC Bank</td>
							</tr>
							<tr>
								<td class="tab-left-head">Branch Code</td>
								<td>501</td>
							</tr>
							<tr>
								<td class="tab-left-head">Bank Account Number</td>
								<td>5011234567</td>
							</tr>																
						</tbody>
					</table>							 
				</div><!---table end---> 
				</div>	
				<div class="row"> 
					<div class="col-sm-12">	
						<div class="pull-right">							
							<button type="submit" class="verification-button">EDIT ACCOUNT</button>	
						</div>
					</div>
				</div>		
			
	</div><!-------panel------>
</div><!-----col 12------->
@endsection  
@stop 
