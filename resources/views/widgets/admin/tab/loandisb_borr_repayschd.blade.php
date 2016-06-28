<div id="borr_repay_schd" class="tab-pane fade">  	
	<div class="panel panel-default borr_repay_schd"> 						
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered .tab-fontsize" id="bidsummary">	
					<tr>	
					@if ($bidsModel->loan_status == LOAN_STATUS_BIDS_ACCEPTED) 
						<th class="tab-head col-sm-1 text-left">
							Inst Number
						</th>
							
						<th class="tab-head col-sm-1 text-left">
							Schd Date
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Principal
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Interest
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Total
						</th>
					@else
						<th class="tab-head col-sm-1 text-left">
							Inst Number
						</th>
						
						<th class="tab-head col-sm-1 text-left">
							Schd Date
						</th>
						
						<th class="tab-head col-sm-1 text-left">
							Actual Date
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Principal
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Interest
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Penalty Fees
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Penalty Int
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Total
						</th>
						
						<th class="tab-head col-sm-1 text-left">
							Status
						</th>
					@endif
					
					</tr>
					
				</table>
			</div>			
		</div>
	</div>
</div>


