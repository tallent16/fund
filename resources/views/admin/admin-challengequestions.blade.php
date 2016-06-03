@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-challengequestion.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('User Security Questions') )
@section('section')  
		@var $security_list = $adminchallqueModel->securityque_list;
<div class="col-sm-12 space-around">
	<div class="row">		
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get('Questions') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<form method="post" id="form-challenge-questions" action="">
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="processType" id="processType" value="">
							
						<table class="table tab-fontsize text-left" id="security_table">
							<thead>
								<tr>									
									<th class="tab-head text-left col-sm-2">{{ Lang::get('S.No') }}</th>
									<th class="tab-head text-left col-sm-8">{{ Lang::get('Question') }}</th>
									<th class="tab-head text-left col-sm-2 text-center">
										<label>
											<input type="checkbox" id="select_all_list" value="Select All">
										</label>	
									</th>
								</tr>
							</thead>
							
							<tbody>	
								@foreach ($security_list as $queRow)
								<tr>
									<td>
										{{$queRow->codelist_code}}
									</td>
									<td>
										<input type="text" 
												value="{{$queRow->codelist_value}}"
												name=""
												id="questions[]"
												class="form-control"
										/>
									</td>										
									<td class="text-center">													
											<label>
												<input 	type="checkbox" 
														name="question_ids[]"
														class="select_question_id"																
														value="	{{$queRow->codelist_code}}">
											</label>													
									</td>
								</tr>
								
								@endforeach	
								<tr style="display:none">
									<td>
										@var $i=1;	
										{{$queRow->codelist_code}}			
										@if($i>1)						
											@var $newvalue = $queRow->codelist_code+1;										
											{{$newvalue}}
										@endif
										@var $i++;
									</td>
									<td>
										<input type="text" 
												value=""
												name=""
												id="new_questions"
												class="form-control"
										/>
									</td>
									<td class="text-center">
										<label>
												<input 	type="checkbox" 
														name="new_question_id"
														class="select_newquestion_id"																
														value="{{$queRow->codelist_code}}+1	">
											</label>
									</td>
								</tr>
							</tbody>
						</table>
						</form>		
					</div>
						
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">	
				<button type="button"
						id="new_question"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('New Questions')}}
				</button>
				<button type="button"
						id="delete_question"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Delete Selected')}}
				</button>
				<button type="button"
						id="update_question"
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						{{ Lang::get('Save')}}
				</button>
			</div>
	</div>
</div>

	@endsection  
@stop

