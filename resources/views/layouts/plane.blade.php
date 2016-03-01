<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
	<meta charset="utf-8"/>
	<title>MoneyMatch</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<meta content="" name="description"/>
	<meta content="" name="author"/>
	
	<link rel="stylesheet" href="{{ asset("assets/stylesheets/styles.css") }}" />
	@yield('styles')
	@yield('scripts')
</head>
<body>
	@yield('body') 
	@yield('bottomscripts')
</body>
<script src="{{ url('js/bootstrap-select.min.js') }}" type="text/javascript"></script>	
<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.min.css') }}">
</html>
