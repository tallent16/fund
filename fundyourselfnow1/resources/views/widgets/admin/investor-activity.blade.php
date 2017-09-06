<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan borrower-admin"> 
							
			<table class="table tab-fontsize table-border-custom text-left" id="investor_activity"> 
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
					@foreach($invFilter as $invListRow)
						@var	$openBal	=	$adminInvActRepMod->openingBalance[$invListRow]
								<tr>
										<td colspan="7" class="text-center">
											{{ "<strong>".Lang::get('Transaction Detail Report for Backer:').
												"</strong>".$invList[$invListRow]}}
										 </td>
									</tr>	
								<tr>
									<td class="tab-head text-left">{{ Lang::get('Date') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Transaction Type') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Reference Number') }}</td>
									<td class="tab-head text-left">{{ Lang::get('Details') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Dr Amount') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Cr Amount') }}</td>
									<td class="tab-head text-right">{{ Lang::get('Balance') }}</td>
								</tr>
								<tr>
									<td class="text-left">&nbsp;</td>
									<td class="text-left">{{ Lang::get('Opening Balance') }}</td>
									<td class="text-left">&nbsp;</td>
									<td class="text-left">&nbsp;</td>
									<td class="text-right">&nbsp;</td>
									<td class="text-right">{{number_format($openBal,2,'.',',')}}</td>
									<td class="text-right">{{number_format($openBal,2,'.',',')}}</td>
								</tr>

							@if (count($adminInvActRepMod->investActReport[$invListRow]) > 0)			
								@foreach($adminInvActRepMod->investActReport[$invListRow] as $investActReportRow)
									@var	$crAmt	=	$investActReportRow->credit_amt;
									@var	$dbAmt	=	$investActReportRow->debit_amt;
									@var	$bal	=	$investActReportRow->balance;
									<tr>
										<td class="text-left">{{$investActReportRow->rept_date}}</td>
										<td class="text-left">{{$investActReportRow->trans_type}}</td>
										<td class="text-left">{{$investActReportRow->ref_no}}</td>
										<td class="text-left">{{$investActReportRow->details}}</td>
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
