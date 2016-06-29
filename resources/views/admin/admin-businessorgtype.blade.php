@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-businessorgtype.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Business Organisation Type') )
@section('section')  
@var $businessorgtype_list = $adminbusinessorgModel->businessorg_list;
<div class="col-sm-12 space-around">	
	
	<form method="post" id="form-businessorgtype" action="">
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">	
	<input type="hidden" name="delete_check" id="delete_check" value="0">	
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get('Organisation Types') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<table class="table tab-fontsize text-left" id="admin_table">
							<thead>
								<tr>									
									<th class="tab-head text-left col-sm-2 text-center">{{ Lang::get('S.No') }}</th>
									<th class="tab-head text-left col-sm-6">{{ Lang::get('Business Organisation Type') }}</th>
									<th class="tab-head text-left col-sm-2">{{ Lang::get('Lending Allowed') }}</th>
									<th class="tab-head text-left col-sm-2 text-center">
										<label>
											<input type="checkbox" id="select_all_list" value="Select All">
										</label>	
									</th>
								</tr>
							</thead>
							
							<tbody>	
								@foreach ($businessorgtype_list as $queRow)								
								<tr>
									<td class="text-center" >	
										<span class="slno">{{$queRow->slno}}</span>								
										<input  type="hidden"
												name="business[id][]"
												value="{{$queRow->bo_id}}" />
									</td>
									<td>
										<input type="text" 
												value="{{$queRow->bo_name}}"
												name="business[business_org_type][]"
												class="form-control"
										/>
									</td>	
									<td>
										{{ Form::select('business[lending_allowed][]', array('1' => 'Yes', '0' => 'No'), 
																$queRow->bo_borrowing_allowed,
																	["class" => "selectpicker","id"=>"lending_allowed_".$queRow->slno]) }}
									
									</td>										
									<td class="text-center">													
										<label>
											<input 	type="checkbox" 
													class="select_businessorgtype_id"	
													name="business[selected][]"															
													value="{{$queRow->bo_id}}">
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
	@permission('edit_organisation_type.admin.settings')	
		<div class="row">
			<div class="col-sm-12">	
				<button type="button"
						id="new_businessorgtype"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('New Business Org Type')}}
				</button>
				<button type="button"
						id="delete_businessorgtype"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Delete Selected')}}
				</button>
				<button type="submit"
						id="update_businessorgtype"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Save')}}
				</button>
			</div>
		</div>
	@endpermission
	</form>	
</div>

<div class="space-around">&nbsp;</div>
<div style="display:none;">
	<input type="hidden" id="business_org_type_id" value= "{{$queRow->slno}}" />	
	<div>
		<table  >
		<tr id="businessOrgTypeTemplate">
			<td class="text-center">
				<span class="slno">XXX</span>
				<input  type="hidden"
						name="business[id][]"
						value="0" />
			</td>
			<td>
				<input type="text" 						
						name="business[business_org_type][]"
						class="form-control"	
						value=""					
				/>
			</td>
			<td>
				{{ Form::select('business[lending_allowed][]', array('1' => 'Yes', '0' => 'No'),'1',["id"=>"lending_allowed_XXX"]) }}
			</td>
			<td class="text-center">
				<label>
					<input 	type="checkbox" 
							class="select_businessorgtype_id"																
							value="	">
				</label>
			</td>
		</tr>
		</table>
	</div>
</div>
	@endsection  
@stop

