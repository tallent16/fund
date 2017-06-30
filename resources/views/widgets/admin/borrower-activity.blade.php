<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan borrower-admin"> 
							
			<table class="table tab-fontsize table-border-custom text-left">
				<thead style="display:none">
						<tr>
							<td class="tab-head text-left">{{ Lang::get('Date') }}</td>
							<td class="tab-head text-left">{{ Lang::get('Transaction Type') }}</td>
							<td class="tab-head text-left">{{ Lang::get('Reference Number') }}</td>
							<td class="tab-head text-left">{{ Lang::get('Details') }}</td>
							<td class="tab-head text-right">{{ Lang::get('Dr Amount') }}</td>
							<td class="tab-head text-right">{{ Lang::get('Cr Amount') }}</td>
							<td class="tab-head text-right">{{ Lang::get('Balance') }}</td>
						</tr>
				</thead>
				<tbody>	
					@foreach($borFilter as $borListRow)
						@var	$openBal	=	$adminBorActRepMod->openingBalance[$borListRow]
								@if($showBorrowerName)
									<tr>
										<td colspan="7" class="text-center">
											{{ "<strong>".Lang::get('Transaction Detail Report for Creator:').
												"</strong>".$borList[$borListRow]}}
										 </td>
									</tr>	
								@endif
								<tr>
									<td class="tab-head text-left">{{ Lang::get('Date') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Transaction Type') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Reference Number') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Details') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Dr Amount') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Cr Amount') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Balance OS') }}</td>
								</tr>
								<tr>
									<td class="text-left">&nbsp;</td>
									<td class="text-left">{{ Lang::get('Opening Balance – Principal OS') }}</td>
									<td class="text-left">&nbsp;</td>
									<td class="text-left">&nbsp;</td>
									<td class="text-right">&nbsp;</td>
									<td class="text-right">{{number_format($openBal,2,'.',',')}}</td>
									<td class="text-right">{{number_format($openBal,2,'.',',')}}</td>
								</tr>

							@if (count($adminBorActRepMod->borrowerActReport[$borListRow]) > 0)			
								@foreach($adminBorActRepMod->borrowerActReport[$borListRow] as $borrowerActReportRow)
									@var	$crAmt	=	$borrowerActReportRow->credit_amt;
									@var	$dbAmt	=	$borrowerActReportRow->debit_amt;
									@var	$bal	=	$borrowerActReportRow->balance;
									<tr>
										<td class="text-left">{{$borrowerActReportRow->rept_date}}</td>
										<td class="text-left">{{$borrowerActReportRow->trans_type}}</td>
										<td class="text-left">{{$borrowerActReportRow->ref_no}}</td>
										<td class="text-left">{{$borrowerActReportRow->details}}</td>
										<td class="text-right">
											@if(!empty($dbAmt))
												{{number_format($dbAmt,2,'.',',')}}
											@endif
										</td>
										<td class="text-right">
											@if(!empty($crAmt))
												{{number_format($crAmt,2,'.',',')}}
											@endif
										</td>
										<td class="text-right">
											@if($bal<0)
												@var $symbol	=	"Dr"
											@else
												@var $symbol	=	"Cr"
											@endif
											{{number_format(abs($bal),2,'.',',')}}({{$symbol}})
										</td>
									</tr>
								@endforeach
							@endif
						
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div><!------second row------>
