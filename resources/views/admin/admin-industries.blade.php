@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-industries.js") }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Categories') )
@section('section')  
@var $industry_list = $adminindustryModel->industry_list;
<div class="col-sm-12 space-around">

	<form method="post" id="form-industry" action="">
	<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">	
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get('Category Type') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<table class="table tab-fontsize text-left" id="admin_table">
							<thead>
								<tr>									
									<th class="tab-head text-left col-sm-2 text-center">{{ Lang::get('S.No') }}</th>
									<th class="tab-head text-left col-sm-8">{{ Lang::get('Categories') }}</th>
									<th class="tab-head text-left col-sm-2 text-center">
										<label>
											<input type="checkbox" id="select_all_list" value="Select All">
										</label>	
									</th>
								</tr>
							</thead>
							
							<tbody>	
								@foreach ($industry_list as $queRow)
								<tr>
									<td class="question text-center" >
										<span>{{$queRow->codelist_code}}</span>
										<input  type="hidden"
												name="industry[id][]"
												value="{{$queRow->codelist_code}}" />
									</td>
									<td>
										<input type="text" 
												value="{{$queRow->codelist_value}}"
												name="industry[industry_list][]"
												class="form-control"
										/>
									</td>										
									<td class="text-center">													
											<label>
												<input 	type="checkbox" 
														class="select_industry_id"	
														name="industry[selected][]"															
														value="{{$queRow->codelist_code}}">
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
						id="new_industry"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('New Category Type')}}
				</button>
				<button type="button"
						id="delete_industry"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Delete Selected')}}
				</button>
				<button type="submit"
						id="update_industry"
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
	<input type="hidden" id="industry_id" value= "{{$queRow->codelist_code}}" />
	<div>
		<table  >
		<tr id="industryTemplate">
			<td class="industry_id text-center">
				<span>XXX</span>
				<input  type="hidden"
						name="industry[id][]"
						value="0" />
			</td>
			<td>
				<input type="text" 
						value=""
						name="industry[industry_list][]"
						class="form-control"					
				/>
			</td>
			<td class="text-center">
				<label>
						<input 	type="checkbox" 
								class="select_industry_id"																
								value="	">
					</label>
			</td>
		</tr>
		</table>
	</div>
</div>
	@endsection  
@stop
