<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
	
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('BORROWER NAME')}}</th>
				<th class="tab-head text-left">{{Lang::get('Approval Date')}}</th>
				<th class="tab-head text-left">{{Lang::get('Active Loans')}}</th>
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
							{{$tableRow->approve_date}}
						</td>
						<td>
							{{$tableRow->loan_list}}
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
