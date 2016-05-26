@var $borrowerDirectors = $modelBorPrf->director_details;

<div id="director_info" class="tab-pane fade">
	<div class="panel panel-default directorinfo applyloan"> 						
		<div class="panel-body">	
			<div class="col-sm-12 col-lg-7">	
				
							<div class="row">	
								<div class="col-xs-3">																				
									<label>{{ Lang::get('borrower-profile.select') }}:</label>											
								</div>																					 
								<div class="col-xs-9">										  
									<select class="selectpicker select-width" id="directorDropDown">  
									<!--
									<option value="">{{ Lang::get('borrower-profile.select_director') }}</option>
									-->
									{{ $modelBorPrf->directorSelectOptions }}
									</select>											
								</div>										
							</div><!--row-->
						</br>
							<div class="row" id="director_error_info" style="display:none">	
								<div class="col-xs-12">																				
									<label class="error"
											id="director_error_label">{{ Lang::get('There is error')}}</label>											
								</div>																					 
							</div><!--row-->
						</br>
						<div class="row">
						<div class="panel-primary panel-container">
							<div class="panel-heading panel-headsection"><!--panel head-->
								<div class="row">
									<div class="col-sm-12">
										<span class="pull-left"><i class="fa fa-trash  {{$modelBorPrf->viewStatus}}"></i></span> 														
									</div>																
								</div>					
							</div><!--panel head end-->
						</div><!--panel-->
								
						<div class="table-responsive"><!---table start-->
							<div class="divs">
								@var	$i	=	1
								@foreach($borrowerDirectors as $directorRow)
									<div  class="dir-list" id="{{ $directorRow['slno']}}" >
										<table class="table table-bordered .tab-fontsize text-left">		
											<tbody>
												<tr>
													<td class="col-md-3">
														<label class="input-required">
															{{ Lang::get('borrower-profile.director_name') }}
														</label>
													</td>
													<td class="col-md-3" id="name_{{$i}}_parent">
														<input  type="hidden"
																name="director_row[id][]"
																value="{{$directorRow['id'] }}" />
														<input 	type="text"  
																id="name_{{$i}}" 
																name="director_row[name][]"
																value="{{ $directorRow['name'] }}"
																class="form-control required"
																 {{$modelBorPrf->viewStatus}}/>
													</td>		
												</tr>
												<tr>
													<td class="col-md-3">
														<label class="input-required">
															{{ Lang::get('borrower-profile.director_info') }}
														</label>
													</td>
													<td class="col-md-3"  id="directors_profile_{{$i}}_parent">
														<textarea	id="directors_profile_{{$i}}" 
																	name="director_row[directors_profile][]"
																	class="form-control required"
																 {{$modelBorPrf->viewStatus}}
																 >{{ $directorRow['directors_profile'] }}</textarea>
													</td>		
												</tr>												
												<tr>
													<td class="col-md-3">
														{{ Lang::get('borrower-profile.age') }}
													</td>
													<td class="col-md-3">
														<input 	type="text" 
																id="age_{{$i}}" 
																name="director_row[age][]"
																value="{{ $directorRow['age']  }}"
																class="form-control text-right"
																 {{$modelBorPrf->viewStatus}} />
													</td>			
												</tr>
													<tr>
													<td class="col-md-3">
														{{ Lang::get('borrower-profile.period_since') }}
													</td>
													<td class="col-md-3">
														<input 	type="text" 
																id="period_in_this_business_{{$i}}" 
																name="director_row[period_in_this_business][]"
																value="{{ $directorRow['period_in_this_business']  }}"
																class="form-control text-right"
																 {{$modelBorPrf->viewStatus}} />
													</td>	
												</tr>
													<tr>
													<td class="col-md-3">
														{{ Lang::get('borrower-profile.overall_exp') }}
													</td>
													<td class="col-md-3">
														<input 	type="text" 
																id="overall_experience_{{$i}}" 
																name="director_row[overall_experience][]"
																value="{{ $directorRow['overall_experience']  }}"
																class="form-control text-right"
																 {{$modelBorPrf->viewStatus}} />
													</td>	
												</tr>
													<tr>
													<td class="col-md-3">
														{{ Lang::get('borrower-profile.accomplish') }}
													</td>
													<td class="col-md-3">
														<textarea	id="accomplishments_{{$i}}" 
																	name="director_row[accomplishments][]"
																	class="form-control"
																 {{$modelBorPrf->viewStatus}} 
																 >{{ $directorRow['accomplishments'] }}</textarea>
													</td>
												</tr>													
											</tbody>
										</table>
									</div>
									@var	$i++
								@endforeach
							</div>
								
														
						</div><!--table-->
						</div>
						<div class="row">	
							<div class="pull-left">											
								<button type="button"
										class="btn verification-button  {{$modelBorPrf->viewStatus}}"
										id="add-director">
									<i class="fa pull-right"></i>
									{{ Lang::get('borrower-profile.add') }}
								</button>											
							</div>
							<div class="text-center pull-right">
								<ul class="pagination">
									<li>
										<a href="javascript:void(0)" id="prev">
											<i class="fa fa-chevron-circle-left"></i>
										</a>
									</li>
									<li>
										<a href="javascript:void(0)" id="next">
											<i class="fa fa-chevron-circle-right"></i>
										</a>
									</li>	
								</ul>
							</div>				
								</br> 						
						</div><!--row-->						
			</div>	<!--col-7 end-->
		    
			<div class="col-lg-5"></div>		
	
		</div><!--panel body-->
	</div><!--panel------>	
</div><!--director tab-->
