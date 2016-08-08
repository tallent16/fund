<div id="borr_repay_schd" class="tab-pane fade">  	
	<div class="panel panel-default borr_repay_schd"> 						
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="bidsummary">	
					<tr>	
					@if ($bidsModel->loan_status == LOAN_STATUS_BIDS_ACCEPTED) 
						<th class="tab-head col-sm-1 text-left">
							Inst-No
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
							Inst-No
						</th>
						
						<th class="tab-head col-sm-1 text-left">
							Schd / Actual Date
						</th>
						
						<th class="tab-head col-sm-1 text-left">
							New Schd Date
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Principal
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Interest
						</th>
						
						<th class="tab-head col-sm-1 text-right">
							Penalty
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
						<th class="tab-head col-sm-1 text-left">
							
						</th>
					@endif
					
					</tr>
					
				</table>
			</div>			
		</div>
	</div>
</div>


