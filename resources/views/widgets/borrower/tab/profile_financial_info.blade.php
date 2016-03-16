@var	$finacialRatioInfo	=	$modelBorPrf->finacialRatioInfo;
@var	$finacialInfo		=	$modelBorPrf->finacialInfo;
<div id="financial_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-6">
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
											<td class="tab-left-head">
												{{$finRatioRow['ratio_name']}}
												<input 	type="hidden" 
														id="ratio_id_{{$i}}" 
														name="finacialRatio_row[ratio_id][]"
														value="{{$i}}"
														class="form-control text-right"
														/>
												<input 	type="hidden" 
														id="ratio_name_{{$i}}" 
														name="finacialRatio_row[ratio_name][]"
														value="{{$finRatioRow['ratio_name']}}"
														class="form-control text-right"
														/>
											</td>
											<td>
												<input 	type="text" 
														id="previous_ratio_{{$i}}" 
														name="finacialRatio_row[previous_ratio][]"
														value="{{$finRatioRow['previous_ratio']}}"
														class="form-control"
														{{ $modelBorPrf->viewStatus }} />
											</td>	
											<td>
												<input 	type="text" 
														id="current_ratio_{{$i}}" 
														name="finacialRatio_row[current_ratio][]"
														value="{{$finRatioRow['current_ratio']}}"
														class="form-control"
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
				
				<div class="col-sm-6">			
					<div class="table-responsive"><!---table start-->
						<table class="table table-loan table-border-custom  text-left">		
							<tbody>
								<tr>
									<th class="tab-head" colspan="2">Financials</th>																	
								</tr>
								@if(count($finacialInfo)>0)
									@var	$i	=1
									@foreach($finacialInfo as $finacialRow)
										<tr>
											<td class="tab-left-head">
												{{$finacialRow['indicator_name']}}
												<input 	type="hidden" 
														id="indicator_id_{{$i}}" 
														name="finacial_row[indicator_id][]"
														value="{{$i}}"
														class="form-control"
														/>
												<input 	type="hidden" 
														id="indicator_name_{{$i}}" 
														name="finacial_row[indicator_name][]"
														value="{{$finacialRow['indicator_name']}}"
														class="form-control"
														/>
														
											</td>
											<td>
												<input 	type="text" 
														id="indicator_value_{{$i}}" 
														name="finacial_row[indicator_value][]"
														value="{{$finacialRow['indicator_value']}}"
														class="form-control"
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
