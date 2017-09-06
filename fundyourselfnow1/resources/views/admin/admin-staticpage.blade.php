@extends('layouts.dashboard_admin')
@section('bottomscripts')
	<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/summernote/summernote.js') }}" type="text/javascript"></script>
	<script>
		$('textarea.tinyTextArea').summernote({height:400});
	</script>
@endsection
@section('styles')
	<link href='http://142.4.10.93/~vooap/fundslive/assets/summernote/summernote.css' rel="stylesheet">
@endsection
@section('page_heading',Lang::get('borrower-dashboard.page_heading') )
@section('section')         
<!-- Register Content -->
<div class="col-sm-12 space-around"> 
	<div class="row">		
				<form action="{{url('admin/update')}}/{{$title}}" method="post">					
				<input type="hidden" value="{{$title}}" name="page">
				<textarea name="project_purpose" id="project_purpose" class="tinyTextArea" rows="10"> {{$data}}</textarea>
				<input type="submit" name="save" value="Save">
				</form>
	</div>	
</div>	
@endsection
@stop