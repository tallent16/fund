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
				@var	$url	=	url('admin/loanview').'/'.base64_encode($tableRow->loan_id)
				<tr>
					<td>
						<a href="{{$url}}">
							{{$tableRow->loan_reference_number}}
						</a>
					</td>
					<td>
						<a href="{{$url}}">
							{{$tableRow->borrower_name}}
						</a>
					</td>
					<td>
						<a href="{{$url}}">
							{{$tableRow->due_date}}
						</a>
					</td>
					<td>
						<a href="{{$url}}">
							{{$tableRow->inst_amount}}
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
