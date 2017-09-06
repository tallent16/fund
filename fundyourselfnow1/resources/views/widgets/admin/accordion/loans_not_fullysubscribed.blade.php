<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('REF NO')}}</th>
				<th class="tab-head text-left">{{Lang::get('CREATOR NAME')}}</th>
				<th class="tab-head text-right">{{Lang::get('PROJECT AMOUNT')}}</th>
				<th class="tab-head text-right">{{Lang::get('BID AMOUNT')}}</th>
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
							{{$tableRow->loan_amount}}
						</a>
					</td>
					<td>
						<a href="{{$url}}">
							{{$tableRow->bid_amt}}
						</a>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
