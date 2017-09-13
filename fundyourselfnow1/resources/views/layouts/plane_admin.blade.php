<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>{{Lang::get('Fund Yourself')}}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	
	<link rel="stylesheet"  type="text/css" href="{{ asset('assets/stylesheets/styles.css') }}" />
	<link rel="stylesheet"  type="text/css" href="{{ url('css/jquery-ui.css') }}">
<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />	
	@yield('styles')
	@yield('scripts')
</head>
<body>
	@yield('body') 
	@yield('bottomscripts')
	<script src="{{ url('js/common.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/jquery.confirm.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/jquery-ui.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/numeral.min.js') }}" type="text/javascript"></script>	
	
	
</body>
<!--
<script src="{{ url('js/bootstrap-select.min.js') }}" type="text/javascript"></script>	
-->
<script src="{{ url('js/selectpicker/bootstrap-select.js') }}" type="text/javascript"></script>	
<script>

var baseUrl = "{{ url('/') }}";

	$(document).ready(function (){  
		 $('[data-toggle="tooltip"]').tooltip();
		 $('.submenu_drop').click(function(){
		 	$('.nav-second-level').slideUp('slow');
		 	if($(this).next('.nav-second-level').is(':visible')){
    		$(this).next('.nav-second-level').slideUp('slow');
    	}else{
    		$(this).next('.nav-second-level').slideDown('slow');
    	}
		 	
		 });
	});
</script>
<?php $image_baseurl = "https://s3-ap-southeast-1.amazonaws.com/devfyn/"; ?>

<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-datetimepicker.css') }}">
</html>
