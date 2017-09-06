@extends('layouts.dashboard')
@section('page_heading',Lang::get($pageheading))

@section('section')
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-12 text-center space-around">
			<div class="annoucement-msg-container">
				<div class="navbar-brand navbar-brand-centered">
					  {{ Html::image('img/LOGO.jpg','',['class' => 'shape-image']) }}
				</div>
				<h3>
					We are working hard on this new feature. This feature will be unveiled in the next release
				</h3>
			</div>				
		</div>
	</div>
</div>
 @endsection
@stop
