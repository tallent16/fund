<div id="borr_repay_schd" class="tab-pane fade">  	
	<div class="panel panel-default borr_repay_schd"> 						
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered .tab-fontsize" id="bidsummary">		
					<tbody>
						<tr id="brt_header">
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Inst Number')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Schd Date')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Actual Date')}}</th>								
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Principal')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Interest')}}</th>
							<th class="tab-head col-sm-2 text-right">
								{{Lang::get('Penalty Fees')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Penalty Int.')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Total')}}</th>
							<th class="tab-head col-sm-2 text-left">
								{{Lang::get('Status')}}</th>
						</tr>
						@foreach($bidsModel->loanInvestors as $loanbidRow)
						<tr>
							<td class="col-sm-2 text-left">
								{{$loanbidRow->username}}
							</td>
							<td class="col-sm-2 text-left">
								{{$loanbidRow->bid_datetime}}
							</td>
							<td class="text-right">
								{{number_format($loanbidRow->bid_amount, 2, ".", ",")}}
							</td>								
							<td class="text-right">
								{{number_format($loanbidRow->bid_interest_rate, 2, ".", ",")}}
							</td>										
							<td class="text-right">
								{{number_format($loanbidRow->accepted_amount, 2, '.',',')}}											
							</td>	
							<td class="text-right">
								{{number_format($loanbidRow->totalrepaid, 2, '.',',')}}											
							</td>	
							<td>
								<button type="button" 
										class="btn verification-button repayment_schedule" 
										data-investor-id="{{$loanbidRow->investor_id}}"
										data-loan-id="{{$bidsModel->loan_id}}"
										>
									{{ Lang::get('Show Repayments')}}
								</button>
							</td>	
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>			
		</div>
	</div>
</div>

<script>

var disbursedColTitles["Inst Number", "Schd Date", "Actual Date", "Principal", "Interest", 
						"Penalty Fees", "Penalty Int", "Total", "Status"];
						
var acceptedColTitles["Inst Number", "Schd Date", "Principal", "Interest", "Total"];
						
var	disbursedColNames['inst_number', 'repayment_schedule_date', 'repayment_actual_date', 
						'principal_component', 'interest_component', 'repayment_penalty_charges',
						'repayment_penalty_interest', 'repayment_status']
						
						
function createHeaderDisbursed() {
	// To create the header row for the Payment Schedule when status is Disbursed or Repaid
	
}

function createHeaderAccepted() {
	
}

function createTabRowDisbursed() {
	
}

function createTabRowAccepted() {
	
}

function createRepayTable(instArray) {
	// To build the table rows
	
	
}


</script>
