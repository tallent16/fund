@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	<style>
	textarea{
		margin-top:7px;
	}
	a{
		color:#337ab7;
	}
	.btn.verification-button {
  		margin-top: 0px !important;
	}
	</style>
@endsection

@section('bottomscripts') 
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDRAUL60x59Me2ISReMzt5UiOLHP8kDFUU&libraries=places'></script>
	<!-- <script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script> -->
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	 
	 <script src="{{ asset('assets/summernote/summernote.js')}}" type="text/javascript"></script>
	 
	<!-- <script src="{{ url('js/locationpicker.jquery.js') }}"></script> -->
	<script src="{{ url('js/jquery.geocomplete.js') }}"></script>
	
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>		
	
<!--
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>  
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  
-->
	<script>var	baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/apply-loan.js') }}"></script>  

@endsection
@section('body')

<div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
                </div>
           	<header class="head">
                                
                                <!-- /.search-bar -->
								
                            <div class="main-bar">
							<div class="container-fluid">
							<div class="row">
                 <div class="col-xs-6">
                                <h3>
              <i class="fa fa-google-wallet" aria-hidden="true"></i>
&nbsp;
            Wallet
          </h3>
		  </div>
                            </div>
                            <!-- /.main-bar -->

							</div>
							</div>
                        </header>
                        <!-- /.head -->
 </div>
<div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">

			<div class="row">  
				  		
					<div class="col-sm-12 space-around"> 
	<div class="row">
<div class="col-sm-12 space-around">
<div class="annoucement-msg-container">
	<div class="alert alert-success annoucement-msg">
		<h4>Note: This is a sample page! We are working hard to develop this function in our future release</h4>	
	</div>
</div>
<div class="row">
	
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan" > 
			<table class="table text-left table-striped table-border-custom">
				<thead>
					<tr>
						<th class="tab-head text-left" style="width:5%;padding: 15px"></th>
						<th class="tab-head text-left" style="width:10%;padding: 15px">{{ Lang::get('Label') }}</th>
						<th class="tab-head text-left" style="width:30%;padding: 15px">{{ Lang::get('Balance') }}</th>
						<th class="tab-head text-left"   style="width:5%;padding: 15px"></th>
						<th class="tab-head text-left" style="width:15%;padding: 15px">{{ Lang::get('Last Activity') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Wallet Address') }}</th>
					</tr>
				</thead>
				<tbody>
					<tr class="odd">
						<td class="text-left"><i class="fa fa-file-text fa-fw"></i></td>
						<td class="text-left"><b>BTC Wallet</b></td>
						<td class="text-left">0.130715583 BTC = 171.97 SGD</td>
						<td class="text-left">
							<button class="btn verification-button" 
									type="button"
									onclick="showPopupFunc();">Send Funds</button>
						</td>
						<td class="text-left">12 Days ago</td>
						<td class="text-left">
								eyJjaWQiOjgxLCJjb21wYW55VG9rZW4iOiJleUpoYkdjaU
								9pSklVekkxTmlKOS5leUoxYzJWeWFXUWlPaUowWlhOME4
						</td>
					</tr>
					<tr class="even">
						<td class="text-left"><i class="fa fa-file-text fa-fw"></i></td>
						<td class="text-left"><b>ETH Wallet</b></td>
						<td class="text-left">0.130715583 BTC = 171.97 SGD</td>
						<td class="text-left">
							<button class="btn verification-button" 
									type="button"
									onclick="showPopupFunc();">Send Funds</button>
						</td>
						<td class="text-left">12 Days ago</td>
						<td class="text-left">
								eyJjaWQiOjgxLCJjb21wYW55VG9rZW4iOiJleUpoYkdjaU
								9pSklVekkxTmlKOS5leUoxYzJWeWFXUWlPaUowWlhOME4
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="row">	
	<div class="col-sm-12">			
		<div class="pull-right">	
			<button class="btn verification-button" 
					id="save_button" 
					type="button"
					onclick="openNewwindow('https://shapeshift.io')">
				<i class="fa pull-right"></i>
				Convert from Other Coins
			</button>
												
			<button class="btn verification-button" 
					id="save_button" 
					type="button"
					onclick="openNewwindow('https://coinbase.com')">
				<i class="fa pull-right"></i>
				Buy BTC/ETH
			</button>
					
			<button id="submit_button" 
					style="" 
					class="btn verification-button" 
					type="button"
					onclick="openNewwindow('https://coinbase.com')">
				<i class="fa pull-right"></i>
				Convert Bitcoin/ETH To Cash
			</button>
		</div>	
	</div>			 
</div>


 @section ('popup-box_panel_title',Lang::get('Send Funds'))
	@section ('popup-box_panel_body')
	 <div class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-12 col-md-12">
				<span id="span_loan_ref_no">
					Recipient
				</span>
				<br>
				<input type="text" class="form-control" placeholder="address" >
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-12 col-md-12">
				<span id="span_loan_ref_no">
					Amount (ETH)
				</span>
				<br>
				<input type="text" placeholder="amount" class="form-control"  value="0.00" >
			</div>
			<div class="col-sm-12 col-md-12">
				<span class="text-left">
					Wallet
				</span>
				<span class="pull-right">
						5.456789(ETH)
				</span>
			</div>
		</div>
	
		<div class="form-group">
			<div class="col-sm-12 col-md-12">
				<span id="span_loan_ref_no">
					Note
				</span>
				<textarea cols="10" rows="5" class="form-control"></textarea>
			</div>
		</div>
	
	</div>
	@endsection
	@section ('popup-box_panel_footer')
		<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-5">
				&nbsp;&nbsp;
			</div>
			<div class="col-sm-2 ">
				<input 	type="button" onclick="HidePopupFunc()" 
						value="Send Funds" id="rwd_save" class="form-control btn verification-button">
			</div>
			<div class="col-sm-4">
			
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'send_funds',
												'aria_labelledby'=>'send_funds',
												'as'=>'popup-box',
												'class'=>'',
												'footerExists'=>"yes"
											))

<script>
	
function HidePopupFunc() {
	$('#send_funds').modal('hide');
} 
	
function openNewwindow(url) {
	window.open(url,"_blank");
} 
	
function showPopupFunc() {
	
	$('#send_funds').modal('show');
}


</script>  		
</div>
</div>
</div>	
</div>
 
	
    @endsection  
@stop

