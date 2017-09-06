	@var	$finacialInfo		=	$LoanDetMod->finacialInfo;
	@var	$directorInfo		=	$LoanDetMod->directorInfo;
	<div class="panel panel-primary panel-container">		
		<div class="panel-body">
				
			<div class="col-md-12">	
				<div class="panel-subhead">
					{{$LoanDetMod->company_name}}
				</div>
				<span>{{$LoanDetMod->industry}}, {{$LoanDetMod->purpose_singleline}}</span>	
				<P>{{$LoanDetMod->company_profile}}</P>		
			</div>

			<div class="col-md-12">
				<div class="panel-subhead">
				{{ Lang::get('borrower-myloans.directory_summary')}}
				</div>
				@if(count($directorInfo)>0)
					@foreach($directorInfo as $directorRow)
						<p><strong>{{$directorRow['name']}}</strong></p>
						<p>{{$directorRow['accomplishments']}}</p>
						<p>{{$directorRow['directors_profile']}}</p>
					@endforeach
				@endif
			</div>
	
			<div class="col-md-12">
				<div class="panel-subhead">
					{{ Lang::get('borrower-myloans.rich_snapshot')}}
				</div>
				<div class="row">
					<div class="col-md-2"><p>{{ Lang::get('borrower-myloans.industry')}}:</p></div>
					<div class="col-md-10">
						<p>{{$LoanDetMod->risk_industry}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"><p>{{ Lang::get('borrower-myloans.strength')}}:</p></div>
					<div class="col-md-10">
						<p>{{$LoanDetMod->risk_strength}}</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2"><p>{{ Lang::get('borrower-myloans.weakness')}}:</p></div>
					<div class="col-md-10">
						<p>{{$LoanDetMod->risk_weakness}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
