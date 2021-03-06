<!--
@var	$finacialRatioInfo	=	$modelBorPrf->finacialRatioInfo;
@var	$finacialInfo		=	$modelBorPrf->finacialInfo;

<div id="financial_info" class="tab-pane fade">  	
	<div class="panel panel-default directorinfo"> 						
		<div class="panel-body">
			<div class="row">
				<div class="col-sm-12 col-lg-1">
				</div>
				<div class="col-sm-12 col-lg-10">			
					<div class="table-responsive">
						<table class="table table-loan table-border-custom  text-left">		
							<tbody>
								<tr>
									<th class="tab-head" colspan="2">&nbsp;</th>																	
								</tr>
								@if(count($finacialInfo)>0)
									
									@foreach($finacialInfo as $finacialRow)
									@var	$i	=	$finacialRow['codelist_code'];
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
												@var	$readOnly	=	""
												@if($finacialRow['expression']	!=	"")
													@var	$readOnly	=	"readonly"
												@endif
												<input 	type="text" 
														id="indicator_value_{{$i}}" 
														name="finacial_row[indicator_value][]"
														value="{{$finacialRow['indicator_value']}}"
														class="form-control  text-right amount-align  required finacial_row"
														decimal=2
														{{$readOnly}}
														data-expression = "{{$finacialRow['expression']}}"
														{{ $modelBorPrf->viewStatus }} />
												<input 	type="hidden" 
														name="finacial_row[ref_codelist_code][]"
														value="{{$i}}"
														class="form-control"
														/>
											</td>										
										</tr>		
									@endforeach
								@endif			
							</tbody>
						</table>	
					</div><!----table responsive--->
<!--
				</div><!---col---->		

<!--
				<div class="col-sm-12 col-lg-1">
-->
<!--
				</div>
-->
<!--
			</div><!---row---->	

<!--
		</div><!--panel body-->													

<!--
	</div><!--panel-->

<!--
</div><!--profile tab-->

