	@var	$finacialInfo		=	$LoanDetMod->finacialInfo;
	@var	$directorInfo		=	$LoanDetMod->directorInfo;
	<div class="panel panel-primary panel-container">		
		<div class="panel-body">
				
			<div class="row">
				<div class="col-md-12">
					<div class="pull-right">
						<i class="fa fa-exclamation-circle"></i>
					</div>
				</div>
			</div>
		
		
			<div class="col-md-12">	
				<div class="panel-subhead">
					{{$LoanDetMod->company_name}}
				</div>
				<span>{{$LoanDetMod->industry}}, {{$LoanDetMod->purpose_singleline}}</span>	
				<P>{{$LoanDetMod->company_profile}}</P>		
			</div>

			<div class="col-md-12">
				<div class="panel-subhead">
				{{ Lang::get('borrower-myloans.directory_summary')}}
				</div>
				@if(count($directorInfo)>0)
					@foreach($directorInfo as $directorRow)
						<p><strong>{{$directorRow['name']}}</strong></p>
						<p>{{$directorRow['accomplishments']}}</p>
						<p>{{$directorRow['directors_profile']}}</p>
					@endforeach
				@endif
			</div>
	
			<div class="col-md-12">
				<div class="panel-subhead">
					{{ Lang::get('borrower-myloans.rich_snapshot')}}
				</div>
				<div class="row">
					<div class="col-md-2">{{ Lang::get('borrower-myloans.industry')}}:</div>
					<div class="col-md-10">
						{{$LoanDetMod->risk_industry}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">{{ Lang::get('borrower-myloans.strength')}}:</div>
					<div class="col-md-10">
						{{$LoanDetMod->risk_strength}}
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">{{ Lang::get('borrower-myloans.weakness')}}:</div>
					<div class="col-md-10">
						{{$LoanDetMod->risk_weakness}}
					</div>
				</div>
			</div>
	
	
			<div class="col-md-12 space-around">				
				<!--<div class="col-md-6">
					<div class="table-responsive"><!---table start-->
					<!--	<table class="table table-loan">		
							<tbody>
								<tr>
									<th class="tab-head" colspan="2">FACT SHEET</th>																	
								</tr>
								<tr>
									<td class="tab-left-head">Month</td>
									<td>1</td>										
								</tr>		
								<tr>
									<td class="tab-left-head">Principal</td>
									<td>$2,252</td>									
								</tr>
								<tr>
									<td class="tab-left-head">Interest</td>
									<td>$250.00</td>									
								</tr>	
								<tr>
									<td class="tab-left-head">Fee</td>
									<td>$0.00</td>								
								</tr>
									<tr>
									<td class="tab-left-head">Total</td>
									<td>$3,583.33</td>								
								</tr>												
							</tbody>
						</table>	
					</div><!---table responsive---->
				<!--</div><!-----col-------->
				
				<div class="col-md-6  col-xs-12 col-lg-offset-3">			
					<div class="table-responsive"><!---table start-->
						<table class="table table-loan">		
							<tbody>
								<tr>
									<th class="tab-head" colspan="2">{{ Lang::get('borrower-myloans.financials')}}</th>																	
								</tr>
								@if(count($finacialInfo)>0)
									@foreach($finacialInfo as $finacialRow)
										<tr>
											<td class="tab-left-head">{{$finacialRow['indicator_name']}}</td>
											<td>{{$finacialRow['indicator_value']}}</td>										
										</tr>		
									@endforeach
								@endif			
							</tbody>
						</table>	
					</div><!----table responsive--->
				</div><!---col---->				
			</div><!---col-12---->
				

		</div>
	</div>
