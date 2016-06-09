@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-loandoc.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Loan Documents') )
@section('section')  
@var $doc_list = $adminloandocModel->loandoc;
<div class="col-sm-12 space-around">

	<form method="post" id="form-loandocuments" action="">
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">	
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get('Loan Documents Required') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<table class="table tab-fontsize text-left" id="admin_table">
							<thead>
								<tr>									
									<th class="tab-head text-left col-sm-1 text-center">{{ Lang::get('S.No') }}</th>
									<th class="tab-head text-left col-sm-6">{{ Lang::get('Loan Documents') }}</th>
									<th class="tab-head text-left col-sm-2">{{ Lang::get('Is Mandatory') }}</th>
									<th class="tab-head text-left col-sm-2">{{ Lang::get('Is Active') }}</th>
									<th class="tab-head text-left col-sm-1 text-center">
										<label>
											<input type="checkbox" id="select_all_list" value="Select All">
										</label>	
									</th>
								</tr>
							</thead>
							
							<tbody>	
								@foreach ($doc_list as $queRow)
								<tr>
									<td class="text-center" >
										<span class="slno">{{$queRow->slno}}</span>
										<input  type="hidden"
												name="loandoc[id][]"
												value="{{$queRow->loan_doc_id}}" />
									</td>
									<td>
										<input type="text" 
												value="{{$queRow->doc_name}}"
												name="loandoc[loandoc_list][]"
												class="form-control"
										/>
									</td>	
									<td>
									{{ Form::select('loandoc[is_mandatory][]', array('1' => 'Yes', '0' => 'No'), 
														$queRow->is_mandatory,
															["class" => "selectpicker","id"=>"is_mandatory"]) }}
							
									</td>
									<td>
									{{ Form::select('loandoc[is_active][]', array('1' => 'Active', '0' => 'Inactive'), 
															$queRow->is_active,
																["class" => "selectpicker","id"=>"is_active"]) }}
									
									</td>										
									<td class="text-center">													
										<label>
											<input 	type="checkbox" 
													class="select_loandoc_id"	
													name="loandoc[selected][]"															
													value="{{$queRow->loan_doc_id}}">
										</label>													
									</td>
								</tr>								
								@endforeach								
							</tbody>
						</table>
					</div>
								
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">	
			<button type="button"
					id="new_doc"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('Add New Loan Documents')}}
			</button>
			<button type="button"
					id="delete_doc"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('Delete Documents')}}
			</button>
			<button type="submit"
					id="update_doc"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('Save')}}
			</button>
		</div>
	</div>
	</form>	
</div>
<div class="space-around">&nbsp;</div>
<div style="display:none;">
	<input type="hidden" id="loandoc_id" value="{{$queRow->slno}}" />
	<div>
		<table  >
		<tr id="loandocTemplate">
			<td class="loandoc_id text-center">
				<span class="slno">XXX</span>
				<input  type="hidden"
						name="loandoc[id][]"
						value="0" />
			</td>
			<td>
				<input type="text" 
						value=""
						name="loandoc[loandoc_list][]"
						class="form-control"					
				/>
			</td>
			<td>
				{{ Form::select('loandoc[is_mandatory][]', array('1' => 'Yes', '0' => 'No'),'1',["id"=>"is_mandatory_XXX"]) }}
			</td>
			<td>
				{{ Form::select('loandoc[is_active][]', array('1' => 'Active', '0' => 'Inactive'),'1',["id"=>"is_active_XXX"]) }}
			</td>
			<td class="text-center">
				<label>
						<input 	type="checkbox" 
								class="select_loandoc_id"																
								value="	">
					</label>
			</td>
		</tr>
		</table>
	</div>
</div>
	@endsection  
@stop
