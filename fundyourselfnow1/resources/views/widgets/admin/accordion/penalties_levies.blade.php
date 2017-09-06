
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('MONTH/YEAR')}}</th>
				<th class="tab-head text-left">{{Lang::get('PENALTY INTEREST')}}</th>
				<th class="tab-head text-left">{{Lang::get('PENALTY Charges')}}</th>
			</tr>
		</thead>
		<tbody>
			@foreach($panelBody as $tableRow) 
				<tr>
					<td>{{$tableRow->month_year}}</td>
					<td>{{$tableRow->penalty_interest}}</td>
					<td>{{$tableRow->penalty_charges}}</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

