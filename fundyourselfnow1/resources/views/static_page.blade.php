@extends ('layouts.plane')
@section('styles')
	
@endsection 
@section('bottomscripts') 
	
@endsection
@section ('body')
@include('header',array('class'=>'',))
<!-- Register Content -->
<div class="inner_page">
	<!-- start ico calendar area here -->
	<section class="ico_calendar">
		<div class="container">
        <div class="row" style="margin-top: 20px">
        	{{$data}} 
        </div>
    	</div>
    </section>
</div>	

<footer class="footer">
@include('footer')
</footer>
@endsection
@stop