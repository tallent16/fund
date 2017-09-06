	@var	$finacialInfo		=	$LoanDetMod->finacialInfo;
	@var	$directorInfo		=	$LoanDetMod->directorInfo;
	<div class="panel panel-primary panel-container">		
		<div class="panel-body">
					
			<div class="col-md-12">
								 
				@if(count($directorInfo)>0)
					@foreach($directorInfo as $directorRow)
						<div class="row">
							<div class="col-sm-3 panel-subhead"><strong>{{$directorRow['name']}}</strong></div>
							<div class="col-sm-3 panel-subhead"><strong>Age </strong>:{{$directorRow['age']}}</div> 
							<div class="col-sm-3 panel-subhead"><strong>Experience </strong>:{{$directorRow['overall_experience']}}</div>
						</div>
						<p></p>
						<div class="row">
							<div class="col-sm-3 panel-subhead"><strong>Team Info </strong></div>
						</div>
						{{$directorRow['directors_profile']}}
					
						@if($directorRow['accomplishments'])
							<div class="row">
								<div class="col-sm-3 panel-subhead"><strong>Accomplishments </strong></div>
							</div>
							{{$directorRow['accomplishments']}}
						@endif		
						<hr>		
					@endforeach
				@endif
								
			</div>	

		</div>
	</div>
