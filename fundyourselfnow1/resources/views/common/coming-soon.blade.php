@extends('layouts.dashboard')
@section('page_heading',Lang::get($pageheading))
@section('bottomscripts') 
	<!-- <script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script> -->

@section('body')
<div class="bg-dark dk" id="wrap">
                <div id="top">

 @include('header',array('class'=>'',))

                </div>
<div class="col-sm-12">
	<div class="row">
		<div class="col-sm-12 text-center space-around">
			<div class="annoucement-msg-container">
				 {{ Html::image('img/LOGO.jpg','',['class' => 'shape-image']) }}
				<h3>
					We are working hard on this new feature. This feature will be unveiled in the next release
				</h3>
			</div>				
		</div>
	</div>
</div>
</div>
 @endsection
@stop
