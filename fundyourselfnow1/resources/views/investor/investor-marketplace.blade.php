@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	<style>
	textarea{
		margin-top:7px;
	}
	</style>
	<style>
		.top-statistics {
			background-image: linear-gradient(to bottom, #ececf0, #f7f7f9), linear-gradient(#589cff, #589cff), linear-gradient(#ffffff, #ffffff);
			box-shadow: 0 7px 8px 0 #ccc;
			padding: 7px 15px;
		}
		
		.price-table{
			border-righ:1px solid #ccc;
		}
		.price-table table tr td:last-child {
			color: #3c9b00;
		}
		.market_change_negative {
			color:rgba(230, 90, 90, 0.6) !important;
		}
		h4 {
			font-size: 18px;
		}
		.annoucement-msg{
   			background-color: #8B170A !important;
		}
		
	</style>
@endsection
@section('body')
 <div class="bg-dark dk" id="wrap">
    <div id="top">
    <!-- .navbar -->
    	@include('header')
        <!-- /.navbar -->       
            <header class="head">                   
            <!-- /.search-bar -->
                <div class="main-bar">
                	<h3><i class="fa fa-external-link fa-fw"></i>&nbsp; {{Lang::get('marketplace.page_heading')}}</h3>
                </div>
                <!-- /.main-bar -->
            </header>
            <!-- /.head -->
    </div>
</div>
<div id="content">
    <div class="outer">
      <div class="inner1 bg-light lter">
	   <div class="row">  
		<div class="col-sm-12 space-around">
<div class="annoucement-msg-container">
		<div class="alert alert-success annoucement-msg">
			<h4>{{Lang::get('marketplace.note')}}</h4>	
		</div>
	</div>

<div class="top-statistics">
	<div class="row">
		<div class="col-md-2 col-sm-4 col-xs-6">
			<h5>{{Lang::get('marketplace.Market')}}</h5>
			<p class="market-name">{{$tokens['MLN'][0]}}</p>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<h5>{{Lang::get('marketplace.last_price')}}</h5>
			<p  class="market-price">{{$tokens['MLN'][1]}}</p>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 stat-volume">
			<h5>{{Lang::get('marketplace.volume')}}</h5>
			<p class="text-nowrap">
				<span class="market-volume">{{ str_replace(" BTC","",$tokens['MLN'][2])}}</span>
			<span class="volume-currency">BTC</span></p>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 stat-highest">
			<h5>{{Lang::get('marketplace.highest_hr')}}</h5>
			<p  class="market-highest-24">{{$tokens['MLN'][3]}}</p>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 stat-lowest">
			<h5>{{Lang::get('marketplace.lowest')}}</h5>
			<p  class="market-lowest-24">{{$tokens['MLN'][4]}}</p>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6 stat-change">
			<h5>{{Lang::get('marketplace.change')}}</h5>
			<p   class="market-change-24 market_change_negative">{{$tokens['MLN'][5]}}</p>
		</div>
	</div>

</div>  
<div class="col-sm-12 space-around" style="background-color:#fff;">
	<div class="row">
		<div class="col-md-4 col-xs-12 price-table">
			<h3>{{Lang::get('marketplace.Markets')}}</h3>
			<div class="table-responsive">
			<table fixed-header="" style="z-index:999;position:relative;" class="table table-hover markets-table">
				<thead style="display: block;">
					<tr>
						<th style="width: 102px;">{{Lang::get('marketplace.Coin')}}</th>
						<th style="width: 101px;">{{Lang::get('marketplace.Price')}}</th>
						<th ng-click="marketFilter='Volume';marketFilterDirection ? marketFilterDirection = false : marketFilterDirection = true" class="market-filter market-volume" role="button" tabindex="0" style="width: 72px;">
							<i ng-class="marketFilter == 'Change' || !marketFilterDirection ? 'hidden' : ''" aria-hidden="true" class="ion-chevron-down"></i>
							<i ng-class="marketFilter == 'Change' || marketFilterDirection ? 'hidden' : ''" aria-hidden="true" class="ion-chevron-up hidden"></i>
              
							{{Lang::get('marketplace.Volume')}}
						</th>
						<th ng-click="marketFilter='Change';marketFilterDirection ? marketFilterDirection = false : marketFilterDirection = true" class="market-filter market-change" role="button" tabindex="0" style="width: 70px;">
							<i ng-class="marketFilter  == 'Volume' || !marketFilterDirection ? 'hidden' : ''" aria-hidden="true" class="ion-chevron-down hidden"></i>           
							<i ng-class="marketFilter  == 'Volume' || marketFilterDirection  ? 'hidden' : ''" aria-hidden="true" class="ion-chevron-up hidden"></i>
							<span>{{Lang::get('marketplace.Change')}}</span>
						</th>
					</tr>
				</thead>
				<tbody style="display: block; height: inherit; overflow: auto;">
					<tr class="market market-27 market-active" 
						data-ng-click="setPair(ticker.PairId,$event)" 
						data-ng-repeat="ticker in tickers | orderObjectBy: marketFilter :marketFilterDirection " role="button" tabindex="0" style=""
						onclick="setMarketPlaceValues('MLN')">
						<td style="width: 102px;">MLN
						</td>
						<td style="width: 101px;">{{$tokens['MLN'][1]}}</td>
						<td style="width: 72px;">{{ str_replace(" BTC","",$tokens['MLN'][2])}}</td>
						<td data-symbol="" ng-class="{'change-negative' : ticker.Symbol == undefined}" class="change-negative" style="width: 70px;">{{$tokens['MLN'][5]}}</td>
					</tr>
					<tr class="market market-28" data-ng-click="setPair(ticker.PairId,$event)" data-ng-repeat="ticker in tickers | orderObjectBy: marketFilter :marketFilterDirection " role="button" tabindex="0" style=""
					onclick="setMarketPlaceValues('TIME')">
						<td style="width: 90px;">{{Lang::get('marketplace.TIME')}}
						</td>
						<td style="width: 91px;">{{$tokens['TIME'][1]}}</td>
						<td style="width: 62px;">{{ str_replace(" BTC","",$tokens['TIME'][2])}}</td>
						<td data-symbol="" ng-class="{'change-negative' : ticker.Symbol == undefined}" class="change-negative" style="width: 60px;">{{$tokens['TIME'][5]}}</td>
					</tr>
					<tr class="market market-1" data-ng-click="setPair(ticker.PairId,$event)" data-ng-repeat="ticker in tickers | orderObjectBy: marketFilter :marketFilterDirection " role="button" tabindex="0" style="" onclick="setMarketPlaceValues('LTC')">
						<td style="width: 90px;">LTC
						</td>
						<td style="width: 91px;">{{$tokens['LTC'][1]}}</td>
						<td style="width: 62px;">{{ str_replace(" BTC","",$tokens['LTC'][2])}}</td>
						<td data-symbol="+" ng-class="{'change-negative' : ticker.Symbol == undefined}" class="" style="width: 60px;">{{$tokens['LTC'][5]}}</td>
					</tr>
					<tr class="market market-11" data-ng-click="setPair(ticker.PairId,$event)" data-ng-repeat="ticker in tickers | orderObjectBy: marketFilter :marketFilterDirection " role="button" tabindex="0" style="" onclick="setMarketPlaceValues('ETH')">
						<td style="width: 90px;">ETH
						</td>
						<td style="width: 91px;">{{$tokens['ETH'][1]}}</td>
						<td style="width: 62px;">{{ str_replace(" BTC","",$tokens['ETH'][2])}}</td>
						<td data-symbol="+" ng-class="{'change-negative' : ticker.Symbol == undefined}" class="" style="width: 60px;">{{$tokens['ETH'][5]}}</td>
					</tr><!----><!---->
				</tbody>
			</table>
			</div>
		</div>
		<div style="padding-left:0px;border: 1px solid #ececf0;" class="col-md-8 col-xs-12">
			{{ Html::image('img/graph.png') }}
		</div>
		<div class="offer-block">

		<div style="padding-left:0px;padding-right:0px;float:right;" class="col-md-8 col-xs-12"> 
			<div class="col-md-6 col-xs-6 offer-form">
				<div style="margin-top:20px" class="block-header group">
					<h3>Buy <span class="current_token">MLN</span></h3>
					<div class="purse-amount wallet-before">
						<span> BTC</span>
					</div>
				</div>
				<div class="offer">
					<p>
						<span class="offer-label">{{Lang::get('marketplace.lowest_ask')}}</span>
						<span 	ng-click="lowestAskClick()" 
								class="offer-value pointer lowest_ask" 
								role="button" 
								tabindex="0">{{$tokens['MLN'][6]}}</span> BTC
					</p>
					<p ng-click="setBuyMaxAmount()" role="button" tabindex="0">
						<span class="offer-label">{{Lang::get('marketplace.max_ammount')}}</span>
						<span class="offer-value pointer"> BTC</span>
					</p>
				</div>
				
				<form name="buyForm" class="uniform-form ng-pristine ng-valid" data-ng-submit="createOrder('buy')">
					<div class="offer-group">
						<label class="input-label textbox-price">{{Lang::get('marketplace.Price')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setBuyTotalOrAmount()" data-ng-model="BuyOrder.Price" name="price" class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" decimal="2" aria-invalid="false"
						id="buy_price_input">
						<span class="input-currency textbox-currency">BTC</span>
					</div>
					<div class="offer-group">
						<label class="input-label textbox-price">{{Lang::get('marketplace.Amount')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setBuyTotal()" data-ng-model="BuyOrder.Amount" class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" decimal="2" aria-invalid="false"
						id="buy_amount_input">
						<span class="input-currency textbox-currency current_token">MLN</span>
					</div>
					<div class="offer-group">
						<label class="input-label">{{Lang::get('marketplace.total')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setBuyAmount()" data-ng-model="BuyOrder.Total" 
						class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" 
						decimal="2"
						aria-invalid="false"
						id="buy_total_input">
						<span class="input-currency">BTC</span>
					</div>
					<button type="submit" class="button full-width" id="buy"><span>{{Lang::get('marketplace.Buy')}}</span>
						<div style="display:none" id="buyLoading" class="spinner">
						  <div class="rect1"></div>
						  <div class="rect2"></div>
						  <div class="rect3"></div>
						  <div class="rect4"></div>
						  <div class="rect5"></div>
						</div>
					</button>
				</form>
				<p>{{Lang::get('marketplace.service')}} 0.25% ( <span class="buy_fee">0.00000000</span> <span class="current_token">MLN</span>)</p>
				<!---->
			</div>
			<div class="col-md-6 col-xs-6 offer-form">
				<div class="block-header group" style="margin-top:20px">
					<h3>Sell <span class="current_token">MLN</span></h3>
					<div class="purse-amount wallet-before">
						<span  class="current_token"> MLN</span>
					</div>
				</div>
				<div class="offer">
					<p>
						<span class="offer-label">{{Lang::get('marketplace.highest_bid')}}</span>
						<span 	ng-click="higestBidClick()" 
								class="offer-value pointer highest_bid" 
								role="button" 
								tabindex="0">{{$tokens['MLN'][7]}}</span> BTC
					</p>
					<p ng-click="SellOrder.Amount = BaseBalance.Value;setSellTotal()" role="button" tabindex="0">
						<span class="offer-label">{{Lang::get('marketplace.max_ammount')}}</span>
						<span class="offer-value pointer current_token"> MLN</span>
					</p>
				</div>
				<form class="uniform-form ng-pristine ng-valid" data-ng-submit="createOrder('sell')">
					<div class="offer-group">
						<label class="input-label">{{Lang::get('marketplace.Price')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setSellTotal()" data-ng-model="SellOrder.Price" class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" decimal=2 aria-invalid="false" id="sell_price_input">
						<span class="input-currency">BTC</span>
					</div>
					<div class="offer-group">
						<label class="input-label">{{Lang::get('marketplace.Amount')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setSellTotal()" data-ng-model="SellOrder.Amount" class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" decimal="2" aria-invalid="false" id="sell_amount_input">
						<span class="input-currency current_token">MLN</span>
					</div>
					<div class="offer-group">
						<label class="input-label">{{Lang::get('marketplace.total')}}</label>
						<input type="text" input-decimal-separator="8" ng-change="setSellAmount()" data-ng-model="SellOrder.Total" class="form-control trade-input ng-pristine ng-untouched ng-valid ng-empty amount-align" decimal="2" aria-invalid="false" id="sell_total_input">
						<span class="input-currency">BTC</span>
					</div>
					<button type="submit" class="button full-width" id="sell"><span>{{Lang::get('marketplace.Sell')}}</span>
					  <div style="display:none" id="sellLoading" class="spinner">
						  <div class="rect1"></div>
						  <div class="rect2"></div>
						  <div class="rect3"></div>
						  <div class="rect4"></div>
						  <div class="rect5"></div>
						</div>
					  </button>
				</form>
				<p>{{Lang::get('marketplace.service')}} 0.25% ( <span class="sell_fee">0.00000000</span> BTC)</p>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</div>

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
	<script> 
	var	tokens	=	{{json_encode($tokens)}};
	
	 $(document).ready(function(){ 
	// date picker
	$('.date-picker').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 

	}); 
	
	$(".amount-align").on("focus", function() {
		onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	});
	
	
	$("#buy_price_input").on("change", function() {
		calculateBuyFunc();
	})

	$("#buy_amount_input").on("change", function() {
		calculateBuyFunc()
	});
	
	$("#sell_price_input").on("change", function() {
		calculateSellFunc();
	})

	$("#sell_amount_input").on("change", function() {
		calculateSellFunc()
	});
}); 

function setMarketPlaceValues(token) {
	
	switch(token) {
		case 'MLN':
			var	obj		=	tokens.MLN;
			var objcl	=	"market-27";
			break;
		case 'TIME':
			var	obj		=	tokens.TIME;
			var objcl	=	"market-28";
			break;
		case 'LTC':
			var	obj		=	tokens.LTC;
			var objcl	=	"market-1";
			break;
		case 'ETH':
			var	obj		=	tokens.ETH;
			var objcl	=	"market-11";
			break;
	}
	putMarketPlaceValues(obj,objcl);
	changeCurrentTokenLabel(token);
}

function putMarketPlaceValues(obj,objcl) {
	
	$(".market-active").removeClass("market-active");
	$("."+objcl).addClass("market-active");
	
	var	market	=	obj[0];
	var	price	=	obj[1];
	var	volume	=	obj[2];
	var	high_24	=	obj[3];
	var	low_24	=	obj[4];
	var	chg_24	=	obj[5];
	var	lowest_ask	=	obj[6];
	var	highest_bid	=	obj[7];
	
	$("p.market-name").html(market);
	$("p.market-price").html(price);
	$("span.market-volume").html(volume.replace(" BTC",""));
	$("p.market-highest-24").html(high_24);
	$("p.market-lowest-24").html(low_24);
	$("p.market-change-24").html(chg_24);
	$(".lowest_ask").html(lowest_ask);
	$(".highest_bid").html(highest_bid);
	
	if( chg_24.indexOf('+') != -1 ){
		$(".market-change-24").removeClass("market_change_negative");
	}else{
		$(".market-change-24").addClass("market_change_negative");	
	}
}

function changeCurrentTokenLabel(token) {
	$(".current_token").html(token);
}

function calculateBuyFunc() {
	var	buy_price	=	numeral($("#buy_price_input").val()).value();
	var	buy_amt		=	numeral($("#buy_amount_input").val()).value();
	var	tot_buy	=	buy_price	*	buy_amt;
	$("#buy_total_input").val(tot_buy);
	var percent	=	((25/100)	*	(1/100)) * buy_amt;
	$("span.buy_fee").html(percent.toFixed(8));
}

function calculateSellFunc() {
	
	var	sell_price	=	numeral($("#sell_price_input").val()).value();
	var	sell_amt	=	numeral($("#sell_amount_input").val()).value();
	var	tot_sell	=	sell_price	*	sell_amt;
	$("#sell_total_input").val(tot_sell);
	var percent	=	((25/100)	*	(1/100)) * sell_amt;
	$("span.sell_fee").html(percent.toFixed(8));
}
function showTransDetailPopupFunc(data) {
	$("#span_loan_ref_no").html(data.row.loan_ref_no);
	$("#span_bid_close_date").html(data.row.bid_close_date);
	$("#span_sanctioned_amount").html(data.row.sanctioned_amount);
	$("#span_interest_rate").html(data.row.interest_rate);
	$("#span_balance_outstanding").html(data.row.balance_outstanding);
	$('#transaction_detail').modal('show');
}


</script> 
@endsection
@stop
