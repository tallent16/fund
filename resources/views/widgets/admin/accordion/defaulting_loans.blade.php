<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('LOAN REF NO')}}</th>
				<th class="tab-head text-left">{{Lang::get('BORROWER NAME')}}</th>
				<th class="tab-head text-right">{{Lang::get('DUE DATE')}}</th>
				<th class="tab-head text-right">{{Lang::get('INST AMOUNT')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($panelBody as $tableRow) 
				<tr>
					<td>{{$tableRow->loan_reference_number}}</td>
					<td>{{$tableRow->borrower_name}}</td>
					<td>{{$tableRow->due_date}}</td>
					<td>{{$tableRow->inst_amount}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
