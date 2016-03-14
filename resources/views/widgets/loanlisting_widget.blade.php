<div class="row loan-list-container">
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
				<span class="sr-only">{{$loanRow->perc_funded}}% Complete</span>
				</div>
			</div>

			<div class="table-responsive"><!---table start-->
				<table class="table">		
					<tbody>
						<tr>
							<th style="font-size:0.7em" >{{ Lang::get("Funded")}}</td>
							<th style="font-size:0.7em" >{{ Lang::get("Loan amount")}}</td>	
							<th style="font-size:0.7em" >{{ Lang::get("Interest")}}</td>		
							<th style="font-size:0.7em" >{{ Lang::get("Days to go")}}</td>	
							<th style="font-size:0.7em" >{{ Lang::get("Grade")}}</td>			
						</tr>
						<tr>
							<td style="font-size:0.7em" class="panel-subhead">
								{{$loanRow->perc_funded}}</td>
							<td style="font-size:0.7em" class="panel-subhead">	
								S${{$loanRow->apply_amount}}
							</td>	
							<td style="font-size:0.7em" class="panel-subhead">
								{{$loanRow->target_interest}}%
							</td>	
							<td style="font-size:0.7em" class="panel-subhead">
								{{$loanRow->days_to_go}}
							</td>	
							<td style="font-size:0.7em" class="panel-subhead">
								{{$loanRow->borrower_risk_grade}}
							</td>				
						</tr>
					</tbody>
				</table>	
			</div>											
		</div>	<!--row- panel white-->
		<div class="row panel-footer">
			<div class="text-center" style="font-size:0.90em">Type of Repayment: 
				<span class="panel-subhead" style="font-size:0.90em">Monthly Installments</span>
			</div>									
		</div><!--row-->																							
	</div><!--col-8-->
</div>
