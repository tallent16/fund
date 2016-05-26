@var	$finacialRatioInfo	=	$modelBorPrf->finacialRatioInfo;
@var	$finacialInfo		=	$modelBorPrf->finacialInfo;

<div id="financial_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-12 col-lg-6">
					<div class="table-responsive"><!---table start-->
						<table class="table table-loan table-border-custom text-left">		
							<tbody>
								<tr>
									<th class="tab-head">{{ Lang::get('borrower-profile.financial_ratio') }}</th>
									<th class="tab-head">{{ Lang::get('borrower-profile.previous_year') }}</th>	
									<th class="tab-head">{{ Lang::get('borrower-profile.current_year') }}</th>				
								</tr>
								@if(count($finacialRatioInfo)>0)
									@var	$i	=1
									@foreach($finacialRatioInfo as $finRatioRow)
										<tr>
											<td class="tab-left-head col-sm-4">
												<label class="input-required">
													{{$finRatioRow['ratio_name']}}
												</label>
												<input 	type="hidden" 
														id="ratio_id_{{$i}}" 
														name="finacialRatio_row[borrower_financial_ratios_id][]"
														value="{{$finRatioRow['borrower_financial_ratios_id']}}"
														class="form-control text-right"
														/>
												<input 	type="hidden" 
														id="ratio_name_{{$i}}" 
														name="finacialRatio_row[ratio_name][]"
														value="{{$finRatioRow['ratio_name']}}"
														class="form-control text-right"
														{{ $modelBorPrf->viewStatus }}
														/>
											</td>
											<td id="previous_ratio_{{$i}}_parent" class="col-sm-4">
												<input 	type="text" 
														id="previous_ratio_{{$i}}" 
														name="finacialRatio_row[previous_ratio][]"
														value="{{$finRatioRow['previous_ratio']}}"
														class="form-control  amount-align required"
														decimal="2"
														{{ $modelBorPrf->viewStatus }} />
											</td>	
											<td id="current_ratio_{{$i}}_parent" class="col-sm-4">
												<input 	type="text" 
														id="current_ratio_{{$i}}" 
														name="finacialRatio_row[current_ratio][]"
														value="{{$finRatioRow['current_ratio']}}"
														class="form-control  amount-align  required"
														decimal="2"
														{{ $modelBorPrf->viewStatus }} />
											</td>	
										</tr>
										@var $i++			
									@endforeach
								@endif
							</tbody>
						</table>	
					</div>
				</div>
				
				<div class="col-sm-12 col-lg-6">			
					<div class="table-responsive"><!---table start-->
						<table class="table table-loan table-border-custom  text-left">		
							<tbody>
								<tr>
									<th class="tab-head" colspan="2">{{ Lang::get('Financials')}}</th>																	
								</tr>
								@if(count($finacialInfo)>0)
									@var	$i	=1
									@foreach($finacialInfo as $finacialRow)
										<tr>
											<td class="tab-left-head col-sm-6">
												<label class="input-required">
													{{$finacialRow['indicator_name']}}
												</label>
												<input 	type="hidden" 
														id="indicator_id_{{$i}}" 
														name="finacial_row[borrower_financial_info_id][]"
														value="{{$finacialRow['borrower_financial_info_id']}}"
														class="form-control"
														{{ $modelBorPrf->viewStatus }}
														/>
												<input 	type="hidden" 
														id="indicator_name_{{$i}}" 
														name="finacial_row[indicator_name][]"
														value="{{$finacialRow['indicator_name']}}"
														class="form-control"
														{{ $modelBorPrf->viewStatus }}
														/>
														
											</td>
											<td id="indicator_value_{{$i}}_parent" class="col-sm-6">
												<input 	type="text" 
														id="indicator_value_{{$i}}" 
														name="finacial_row[indicator_value][]"
														value="{{$finacialRow['indicator_value']}}"
														class="form-control  amount-align  required"
														decimal=2
														{{ $modelBorPrf->viewStatus }} />
											</td>										
										</tr>		
									@endforeach
								@endif			
							</tbody>
						</table>	
					</div><!----table responsive--->
				</div><!---col---->		
			</div><!---row---->	
		</div><!--panel body-->													
	</div><!--panel-->
</div><!--profile tab-->
