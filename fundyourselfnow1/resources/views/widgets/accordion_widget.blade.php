
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#{{$panel_group_id}}" href="#{{$panel_id}}">
				{{$panel_title}}
				<span class="pull-right">
				  <i class="fa fa-caret-down cursor-pointer"></i>
				</span>
			</a>
		</h4>
	</div>
	<div id="{{$panel_id}}" class="panel-collapse collapse {{$panel_collapse_class}}">
		<div class="panel-body">
			@include($panel_body_widget, array("panel_body_content"=>$panel_body_content))
		</div>
	</div>
</div>

