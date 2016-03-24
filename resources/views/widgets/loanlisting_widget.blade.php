@var $loanurl = $loanListing->typePrefix."/myloans/".base64_encode($loanRow->loan_id)
@var $loanurl = url($loanurl)
<div class="row loan-list-container" onclick="redirecturl('{{ $loanurl }}')">
	<div class="col-sm-12 col-lg-4 tab-head loan-list-image"> 	
		@if ($loanRow->isfeatured == 1)
			<div class="imageoverlap">
				{{ Html::image('img/featured.png', '', array('class' => 'img-responsive')) }}
			</div>
		@endif
		
		<img alt="" class="thumbnail" src="{{url()."/".$loanRow->company_image_thumbnail}}">
	</div>
							 
	<div class="col-sm-12 col-lg-8 tab-head"> 	
		<div class="row">
			<div class="col-sm-12 col-xs-12 col-lg-12 title-loanlist">
				<div class="bidders-value col-sm-10 col-xs-10 col-lg-10">
					{{$loanRow->business_name}}
				</div>
				<div class="col-sm-2 col-xs-2 col-lg-2">
					<i class="fa fa-caret-right"></i>
				</div>
				<div class="col-sm-12 col-xs-12 col-lg-12">
					<span>{{$loanRow->industry}}, {{$loanRow->purpose_singleline}}</span>
				</div>
			</div>
		</div>				
								
		<div class="row panel-white">
			<div class="progress">
				<div style="width:{{$loanRow->perc_funded}}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar progress-bar-danger">
				<span class="sr-only">{{$loanRow->perc_funded}}% {{ Lang::get('borrower-loanlisting.complete') }}</span>
				</div>
			</div>

			<div class="table-responsive"><!---table start-->
				<table class="table">		
					<tbody>
						<tr>
							<th>{{ Lang::get('borrower-loanlisting.funded') }}</td>
							<th>{{ Lang::get('borrower-loanlisting.loan_amount') }}</td>	
							<th>{{ Lang::get('borrower-loanlisting.interest') }}</td>		
							<th>{{ Lang::get('borrower-loanlisting.days') }}</td>	
							<th>{{ Lang::get('borrower-loanlisting.grade') }}</td>			
						</tr>
						<tr>
							<td class="panel-subhead">
								{{$loanRow->perc_funded}}</td>
							<td class="panel-subhead">	
								S${{$loanRow->apply_amount}}
							</td>	
							<td class="panel-subhead">
								{{$loanRow->target_interest}}%
							</td>	
							<td class="panel-subhead">
								{{$loanRow->days_to_go}}
							</td>	
							<td class="panel-subhead">
								{{$loanRow->borrower_risk_grade}}
							</td>				
						</tr>
					</tbody>
				</table>	
			</div>											
		</div>	<!--row- panel white-->
		<div class="row panel-footer">
			<div class="text-center">{{ Lang::get('borrower-loanlisting.repayment_type') }}: 
				<span class="panel-subhead">{{ Lang::get('borrower-loanlisting.monthly_install') }}</span>
			</div>									
		</div><!--row-->																							
	</div><!--col-8-->
</div>
