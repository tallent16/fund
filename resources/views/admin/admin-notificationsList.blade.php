@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
			border-bottom:none;
			font-size:12px;
		}
		table.dataTable thead > th {
			color: #fff;			
			text-decoration:none;
		}		
		table.dataTable tr{
			background-color:#333;
			color:#fff;
		}
		table.dataTable td{ 
			color:#333;
		} 
		table.dataTable td i{ 
			color:#333;
		} 
		table.dataTable.no-footer{
			border:none;
		} 
	</style>
@stop
@section('page_heading',Lang::get('Broadcast Notifications') )
@section('section') 
<div class="col-sm-12 space-around">

				<!-----datatable starts----> 
				<form method="post" id="form-manage-borrower" action="{{url('')}}">
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-striped" id="notifications">
									<thead>
										<tr>
											<th>														
												<label>
													<input type="checkbox" id="select_all_list" value="Select All">
												</label>
											</th> 
											<th>{{ Lang::get('Message') }}</th>
											<th>{{ Lang::get('Date') }}</th>
											<th>{{ Lang::get('Status') }}</th>						 
											<th>{{ Lang::get('Actions') }}</th> 
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">	 
						</div>
					</div>
				</form>	

				<!-----datatable ends---->
				
				<div class="row">
					<div class="col-sm-12">		 
							<a href="notifications" class="btn verification-button">
								 <i class="fa pull-right"></i>
								{{ Lang::get('Add Notification')}}
							</a> 
					</div>										
				</div> <!--------Button row---------------> 
		</div><!-------- col--------------->
	</div> <!-------- Second row--------------->
	
	<div id="receipientModal" class="modal fade" role="dialog">
		  <div class="modal-dialog">
			    <div class="modal-content">
						 <div class="modal-header">
							   <button type="button" class="close" data-dismiss="modal">&times;</button>
							   <h4 class="modal-title">Receipients</h4>
						 </div>
						 <div class="modal-body content" style="padding;10px"> 
						 </div>
						 <div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						 </div>
			    </div> 
		  </div>
	</div>
	
	
</div><!-------- col--------------->
@endsection 
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
		var baseUrl	=	"{{url('')}}"	
		$('.table-responsive').on('show.bs.dropdown', function () {
			$('.table-responsive').css( "overflow", "inherit" );
		});

		$('.table-responsive').on('hide.bs.dropdown', function () {
			$('.table-responsive').css( "overflow", "auto" );
		})
	</script>
	<script src="{{ url("js/admin-broadcast-notifications.js") }}" type="text/javascript"></script>
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}
	{{ Html::script('js/bootstrap-datetimepicker.js') }}
	{{ Html::script('js/customdatatable/adminnotifications.js') }}
	
@endsection
