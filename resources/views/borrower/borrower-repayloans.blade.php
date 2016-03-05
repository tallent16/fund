@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Repay Loans') 
@section('section')     
	<div class="col-sm-12 space-around"> 			
	
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection">
				<div class="row">
				   <div class="col-xs-12">
						REPAY LOANS
					</div>									
				</div>                           
			</div><!-------------end of---panel heading---------------------->	
					
			<div class="table-responsive">
				<table class="table tab-fontsize table-striped">
					<thead>
						<tr>
							<th class="tab-head">LOAN REFERENCE NUMBER</th>
							<th class="tab-head">DATE OF REPAYMENT</th>
							<th class="tab-head">PAYMENT REFERNCE NUMBER</th>
							<th class="tab-head">INSTALLMENT MONTH/YEAR</th>
							<th class="tab-head">PAYMENT TYPE</th>
							<th class="tab-head">PAYMENT AMOUNT</th>
							<th class="tab-head"></th>								
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1018</td>
							<td>26 Nov 2016</td>
							<td>xxxxxxx</td>
							<td>2016</td>
							<td>Installment</td>
							<td>$1,000.00</td>	
							<td>
								<button type="submit" class="button-orange">REPAY</button>	
							</td>								
						</tr>	
						<tr>
							<td>1018</td>
							<td>26 Nov 2016</td>
							<td>xxxxxxx</td>
							<td>2016</td>
							<td>Installment</td>
							<td>$1,000.00</td>	
							<td>
								<button type="submit" class="button-orange">REPAY</button>	
							</td>								
						</tr>	
						<tr>
							<td>1018</td>
							<td>26 Nov 2016</td>
							<td>xxxxxxx</td>
							<td>2016</td>
							<td>Installment</td>
							<td>$1,000.00</td>	
							<td>
								<button type="submit" class="button-orange">REPAY</button>	
							</td>								
						</tr>	
						<tr>
							<td>1018</td>
							<td>26 Nov 2016</td>
							<td>xxxxxxx</td>
							<td>2016</td>
							<td>Installment</td>
							<td>$1,000.00</td>	
							<td>
								<button type="submit" class="button-orange">REPAY</button>	
							</td>								
						</tr>										
					</tbody>
				</table>						
			</div><!-----table responsive--->	
		</div><!-----panel--->                      
   
</div><!-----col--12--->
	@endsection  
@stop
