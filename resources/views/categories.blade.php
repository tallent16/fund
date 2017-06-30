@extends('layouts.dashboard')
@section('page_heading',Lang::get('Categories'))
@section('styles')
<style>
.thumbnail {
	border: 0 none;
	box-shadow: none;
	margin:0;
	padding:0;
	width:230px;
	height:120px;
	overflow:hidden;	
}
.thumbnail{
	background-color:#222;
	margin-bottom:15px;		
}
.caption {
	width:100%;
	bottom: .3rem;
	position: absolute;
}
.caption h4 {
	color: #fff;
	-webkit-font-smoothing: antialiased;
}
.img-responsive{
	opacity:0.5;
}
.img-responsive:hover{
	opacity:1;		
}
.icon-cat{
	width:30px;
	height:30px;
	background-color:#fff;
	border-radius:20px;
	font-size:20px;
	display:inline-block;
}
.icon-cat a,.caption h4 a,.thumbnail a{
	color:#222;
	cursor:pointer;
	text-decoration:none;
}
</style>
@endsection
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('section')
<div>&nbsp;</div>
<div class="row">
	<div class=" col-sm-12">
	@foreach ($home-> filterIndustryList as $loanRow)
		<div class="col-sm-3">
			<div class="col-sm-12 thumbnail text-center">
				
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
<script>
 /*Redirect the url to respected loandetails page*/
	function redirecturl(caturl)
	{
		window.location=caturl;
	}
</script>
@endsection
@stop
