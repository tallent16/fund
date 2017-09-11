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
  
  <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/style.css') }}" />
<link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/jquery-ui.css') }}" />

   
        <link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/font-awesome.css') }}" />

    <!--    <link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/main.css') }}" /> -->
         <link rel="stylesheet"  type="text/css" href="{{ asset('assets/lib/metismenu/metisMenu.css') }}" />
           <link rel="stylesheet"  type="text/css" href="{{ asset('assets/lib/onoffcanvas/onoffcanvas.css') }}" />
              <link rel="stylesheet"  type="text/css" href="{{ asset('assets/summernote/summernote.css') }}">
  <link rel="stylesheet"  type="text/css" href="{{ asset('assets/lib/animate.css/animate.css') }}" />
<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-select.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ url('css/bootstrap-datetimepicker.css') }}">
 <link rel="stylesheet"  type="text/css" href="{{ asset('assets/lib/metismenu/countrySelect.scss') }}" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />    
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"></script>

 
  @yield('styles')
  @yield('scripts')
</head>
<body>

  @yield('body') 
  
  


  <script src="{{ url('assets/js/bootstrap.js') }}" type="text/javascript"></script>
 
  <script src="{{ url('js/jquery.confirm.js') }}" type="text/javascript"></script>  
  <script src="{{ url('js/jquery-ui.js') }}" type="text/javascript"></script> 
  <script src="{{ url('js/numeral.min.js') }}" type="text/javascript"></script> 
  
   <script src="{{URL('/')}}/js/loan-details.js"></script> 
  
 <!--
<script src="{{ url('js/bootstrap-select.min.js') }}" type="text/javascript"></script>  
-->
<script src="{{ url('js/selectpicker/bootstrap-select.js') }}" type="text/javascript"></script> 
@if(Auth::check())
<script>
var usertype = "<?php echo Auth::user()->usertype ?>";

</script>
@else

<script>

	var usertype = '';

</script>
@endif

<script>

var baseUrl = "http://52.74.139.176/fundslive/";

	

  $(document).ready(function (){ 
 $('#language').change(function(){

    var locale = $(this).val();
    var _token = $("input[name=_token]").val();
    $.ajax({
     url:baseUrl+"language",
     type:"post",
     data:{'locale':locale,'_token':_token},
     datatype:'json',
     succes:function(data){

     },
     error:function(data){

     },
     beforeSend:function(){

     },
     complete:function(data){
     window.location.reload(true);
     }

    })

   });

     $('[data-toggle="tooltip"]').tooltip();
     $('.notification_btn').click(function(event){
      $(this).toggleClass('active');
      event.stopPropagation();
     });
  });
  $(window).click(function(e) {
     $('.notification_btn').removeClass('active');
});

</script>
  <script src="{{ url('js/common.js') }}" type="text/javascript"></script>  
   <!--  <script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script> -->
  @yield('bottomscripts')

  

</body>

</html>
