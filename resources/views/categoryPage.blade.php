@extends('layouts.plane')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />	
@endsection 
@section('body')
@include('header',array('class'=>'',))

<div>&nbsp;</div>
<div class="container-flex">
	
	<div class="row" style="font-size:12px;">
			
	
	<div class=" col-sm-12">
		<h4 class="col-xs-12"><strong><i class="fa fa-bars" aria-hidden="true"></i> Explore Categories</strong>
				<span class="col-sm-offset-7 col-xs-offset-8 pull-right">
					<span style="font-size:12px;">
						@var $excitingurl = "/explorecategories/"
											
					</span>
				</span>
			</h4>
	@foreach ($home-> filterIndustryList as $loanRow)
		<div class="col-sm-3">
			<div class="col-sm-12 thumb-image text-center">
				
					@var $caturl = "/explorecategories/".base64_encode($loanRow->codelist_value)
					@var $caturl = url($caturl)
				
				<a onclick="redirecturl('{{ $caturl }}')">
					{{ Html::image($loanRow->expression,'',['class' => 'img-responsive']) }}
				</a> 
				
				<div class="caption">
					<span class="icon-cat"><a onclick="redirecturl('{{ $caturl }}')"><i class="fa fa-expand" aria-hidden="true"></i></a></span>
					<h4><a onclick="redirecturl('{{ $caturl }}')" style="color:#fff;">{{$loanRow->codelist_value}}</a></h4>
				</div>
			</div>
		</div>       
		@endforeach							   
	</div>  
		   
</div>  
	</div>
	<div>&nbsp;</div>
@include('footer',array('class'=>'',))
@endsection
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>
 /*Redirect the url to respected loandetails page*/
	function redirecturl(caturl)
	{
		window.location=caturl;
	}
</script>
@endsection


@stop
