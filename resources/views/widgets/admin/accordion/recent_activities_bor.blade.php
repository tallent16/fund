<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
	
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('BORROWER NAME')}}</th>
				<th class="tab-head text-left">{{Lang::get('Activity')}}</th>
				<th class="tab-head text-left">{{Lang::get('Ref No')}}</th>
				<th class="tab-head text-left">{{Lang::get('Date')}}</th>
				<th class="tab-head text-left">{{Lang::get('Status')}}</th>
			</tr>
		</thead>
		<tbody>
			@if( is_array($panelBody) && count($panelBody)	>	0	)
				@foreach($panelBody as $tableRow) 
					
					<tr>
						<td>
							{{$tableRow->borrower_name}}
						</td>
						<td>
							{{$tableRow->activity}}
						</td>
						<td>
							{{$tableRow->loan_reference_number}}
						</td>
						<td>
							{{$tableRow->act_date}}
						</td>
						<td>
							{{$tableRow->statusTxt}}
						</td>
					
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
