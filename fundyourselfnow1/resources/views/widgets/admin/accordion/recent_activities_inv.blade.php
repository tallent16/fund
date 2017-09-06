<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
	
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('BACKER NAME')}}</th>
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
							@if($tableRow->activity	==	"Investments")
								@var	$url	=	url('admin/loanview')."/".base64_encode($tableRow->loan_id)
								<a href="{{$url}}">
									{{$tableRow->investor_name}}
								</a>
							@else	
								{{$tableRow->investor_name}}
							@endif
						</td>
						<td>
							@if($tableRow->activity	==	"Investments")
								@var	$url	=	url('admin/loanview')."/".base64_encode($tableRow->loan_id)
								<a href="{{$url}}">
									{{$tableRow->activity}}
								</a>
							@else	
								{{$tableRow->activity}}
							@endif
						</td>
						<td>
							@if($tableRow->activity	==	"Investments")
								@var	$url	=	url('admin/loanview')."/".base64_encode($tableRow->loan_id)
								<a href="{{$url}}">
									{{$tableRow->ref_no}}
								</a>
							@else	
								{{$tableRow->ref_no}}
							@endif
						</td>
						<td>
							@if($tableRow->activity	==	"Investments")
								@var	$url	=	url('admin/loanview')."/".base64_encode($tableRow->loan_id)
								<a href="{{$url}}">
									{{$tableRow->act_date}}
								</a>
							@else	
								{{$tableRow->act_date}}
							@endif
						</td>
						<td>
							@if($tableRow->activity	==	"Investments")
								@var	$url	=	url('admin/loanview')."/".base64_encode($tableRow->loan_id)
								<a href="{{$url}}">
									{{$tableRow->statusTxt}}
								</a>
							@else	
								{{$tableRow->statusTxt}}
							@endif
						</td>
					
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
