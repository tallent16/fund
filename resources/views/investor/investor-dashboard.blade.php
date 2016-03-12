@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	
@endsection
@section('page_heading','Dashboard')
@section('section')
		<div class="col-sm-12 space-around"> 
			<!--First row--->
			<div class="row annoucement-msg-container">
				<div class="alert alert-danger annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>	
					Announcement section				
				</div>
			</div>
			<!--first row end-->
			
			<!--second row--->
			<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container table-border-custom">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-10 col-lg-11">
									<span class="pull-left">FEATURED LOANS</span> 
								</div>
								<div class="col-xs-2 col-lg-1">
									<i class="fa fa-caret-right cursor-pointer"></i>
								</div>								
							</div>							
						</div>	<!--end panel head-->
						
						<div class="panel-body"><!--panel body-->
								<input 	type="hidden" id="current_loan_index" 
										value="0" />
							   <div class="panel-subhead" id="cur_loan_subhead">
								 	MKM Car leasing Pte Ltd
								</div>
							   <div  id="cur_loan_content">
								   Borrower mainly conducts Visual Arts enrichment programs for playgroups,nursies and kindergartens. Business model has changed since 2010, it started out as a retail outlet selling children art and craft products like Modeling Clay.
								</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table table-loan .tab-fontsizebig text-left">								
								<tbody>
									<tr>
										<td  class="tab-left-head">
											Rate%
										</td> 
										<td >
											10%
										</td>										
									</tr>	
									<tr>
										<td class="tab-left-head" >
											Tenure
										</td> 
										<td >
											1 Year
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											Amount
										</td> 
										<td >
											$1,000
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											Type of Repayment
										</td> 
										<td>
											Montly Repayment
										</td>										
									</tr>
									<tr>
										<td class="tab-left-head">
											Bid Type
										</td> 
										<td >
											
										</td>										
									</tr>									
								</tbody>
							</table>							 
						</div> <!---table end--->   	
					</div>
				</div>
				<!-----first col end----->
				<!-----second col-------->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-default">
						<div class="panel-body">
							@section ('cchart4_panel_title',Lang::get('borrower-dashboard.bar_chart'))
							@section ('cchart4_panel_body')
							@include('widgets.charts.cbarchart')
							@endsection
							@include('widgets.panel', array('header'=>true, 'as'=>'cchart4'))
						</div>								
					</div>
					
							<div class="table-responsive">                         
									<table class="table tab-fontsizebig table-loan text-left" id="account-summary">
										<thead>
											<tr>
												<th class="tab-head">ACCOUNT SUMMARY</th>
												<th class="tab-head">Current</th>
												<th class="tab-head">Pending</th>										
											</tr>
										</thead>
										<tbody>
											<tr>
												<td class="text-left tab-left-head">Investments</td>
												<td class="text-center">90,000.00</td>
												<td class="text-center">10,000.00</td>										
											</tr>
											<tr>
												<td class="text-left tab-left-head">Withdrawals under process</td>
												<td class="text-center"></td>
												<td class="text-center"></td>										
											</tr>	
											<tr> 
												<td class="text-left tab-left-head">Deposit under process</td>
												<td class="text-center">10,000.00</td>
												<td class="text-center"></td>										
											</tr>
											<tr> 
												<td class="text-left tab-left-head">Investments under Bid</td>
												<td class="text-center">5,000.00</td>
												<td class="text-center"></td>										
											</tr>
											<tr>
												<td class="text-left tab-left-head">Total Balance</td>
												<td class="text-center">95,000.00</td>
												<td class="text-center"></td>										
											</tr>										
										</tbody>
									</table>                     
								</div>
					
					
				</div>			
			<!--second col end--->				
		</div>
		<!---third row---->
		<div class="row">
			 <div class="col-lg-12 col-md-12">
				 
				 <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
       <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"> FUNDS DEPLOYED 
          <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
        
						 <div class="panel panel-primary panel-container">
								
					<div class="table-responsive">
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">BORROWER'S NAME</th>
									<th class="tab-head">GRADE</th>
									<th class="tab-head">TOTAL AMOUNT OF LOAN</th>
									<th class="tab-head">AMOUNT INVESTED</th>
									<th class="tab-head">DATE OF INVESTMENT</th>
									<th class="tab-head">TENURE OF LOAN</th>
									<th class="tab-head">TYPE OF LOAN</th>
									<th class="tab-head">RATE OF INTEREST</th>
									<th class="tab-head">INTEREST PAID</th>
									<th class="tab-head">PRINCIPAL PAID</th>
								</tr>
							</thead>
							<tbody>
								
									<tr>
										<td>Name 1</td>
										<td>C</td>
										<td>s$1,000.00</td>
										<td>$1,000.00</td>
										<td>01 JAN 2016</td>
										<td>12</td>
										<td>Monthly Repayment</td>
										<td>10%</td>
										<td>$1,000.00</td>
										<td>$1,000.00</td>
									</tr>				
												
							</tbody>
						</table>						
					</div><!-----third row end--->	
                </div>              
        
        
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">INVESTMENTS UNDER BID
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        
         <div class="panel panel-primary panel-container">
							
					<div class="table-responsive">
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">BORROWER'S NAME</th>
									<th class="tab-head">GRADE</th>
									<th class="tab-head">TOTAL AMOUNT OF LOAN</th>
									<th class="tab-head">AMOUNT INVESTED</th>
									<th class="tab-head">DATE OF INVESTMENT</th>
									<th class="tab-head">BID CLOSE DATE</th>
									<th class="tab-head">TENURE OF LOAN</th>
									<th class="tab-head">TYPE OF LOAN</th>	
									<th class="tab-head"></th>	
									<th class="tab-head"></th>									
								</tr>
							</thead>
							<tbody>
								
									<tr>
										<td>Name 1</td>
										<td>C</td>
										<td>s$1,000.00</td>
										<td>$1,000.00</td>
										<td>01 JAN 2016</td>
										<td>31 JAN 2016</td>
										<td>12</td>
										<td>Monthly Repayment</td>	
										<td></td>
										<td></td>									
									</tr>				
												
							</tbody>
						</table>											
					</div><!-----third row end--->	
                </div>              
        
        
        
        
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">OVERDUE LOANS
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
        <div class="panel-body">
        
				 <div class="panel panel-primary panel-container">
					<div class="table-responsive"><!---table start-->	
					<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">BORROWER'S NAME</th>
									<th class="tab-head">GRADE</th>
									<th class="tab-head">TOTAL AMOUNT OF LOAN</th>
									<th class="tab-head">AMOUNT OVERDUE</th>
									<th class="tab-head">OVERDUE SINCE</th>
									<th class="tab-head">REMARKS</th>	
									<th class="tab-head"></th>
									<th class="tab-head"></th>
									<th class="tab-head"></th>
									<th class="tab-head"></th>																							
								</tr>
							</thead>
							<tbody>
								
									<tr>
										<td>Name 1</td>
										<td>C</td>
										<td>s$1,000.00</td>
										<td>$1,000.00</td>
										<td>25 JAN 2016</td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>																		
									</tr>				
												
							</tbody>
						</table>		
						</div>									
				</div><!-----third row end--->	
                </div>              
        
        </div>
      </div>
    </div>
  </div> 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				 
				
          @endsection  
@stop
