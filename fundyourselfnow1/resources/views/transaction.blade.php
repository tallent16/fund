@extends('layouts.dashboard')
@section('bottomscripts') 

<script>
$(document).ready(function(){
     var contract_address = $('#eth').val();

 var jqueryarray = JSON.parse('<?php echo json_encode($loans); ?>');

  $('.dropdown-submenu a.dropdown-submenulink').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
  $(".mobile_search i").click(function(){
  	$(".mobile_search_box").show();
  });
  $(".close_btn").click(function(){
  	$(".mobile_search_box").hide();
  });
         //var contract_address = "0xddbd2b932c763ba5b1b7ae3b362eac3e8d40121a";
        var myurl =  "https://api.etherscan.io/api?module=account&action=txlist&address="+contract_address+"&startblock=0&endblock=99999999&page=1&offset=100&sort=asc&apikey=A29IKN94TG6K54MMXGFHD5PICRNY73G33I";

           $.ajax({
				type : 'GET', // define the type of HTTP verb we want to use (POST for our form)
				url : myurl , //Etherium api to get cuurent balance of smart contract adddress
				dataType    : 'json'
			}).done(function(data) {
          $('#loaders').css('display','none');

		        $.each(data.result, function(index, value){
		        var theDate = new Date(value['timeStamp'] * 1000);
           dateString = theDate.toGMTString();
             $timestamp =   timeSince(new Date(dateString));
             const magenicIndex = jqueryarray.findIndex(loan => loan.contract_address == value['to']);
             var i = 0;
             if(magenicIndex>0){
           var i = 1;
		  //if(value['to'] == contract_address){
		    	 var html="<tr>";
            html += "<td title="+value['hash']+"><a>" + value['hash'].substr(0, 10)+'...' + "</a></td><td>" +$timestamp + "</td><td>" +value['blockNumber'] + "</td><td  title="+value['from']+"><a>" + value['from'].substr(0, 10)+'...'+ "</a></td><td title="+value['to']+"><a>" +value['to'].substr(0, 10)+'...' + "</a></td><td>" + (parseInt(value['value'])/1000000000000000000) + " ETH</td><td>"+((parseInt(value['gasPrice'])*parseInt(value['gasUsed']))/1000000000000000000).toFixed(8);
              
             html += "</tr>";
                $('#myTable').append(html);
           //   }
              if( i == 0){
                 $('#myTable').html('<tr style="text-align: center; width: 100%;"><td></td><td></td><td style="width: 100% !important;"><h1>No Transaction Found.</h1><h1></h1></td></tr>');
              }
          }
        });
			}); 
});



function timeSince(date) {

  var seconds = Math.floor((new Date() - date) / 1000);

  var interval = Math.floor(seconds / 31536000);

  
  intervalday = Math.floor(seconds / 86400);
  
   intervalday + " days";
   var hourstotal = parseInt(intervalday)*24;
  intervalhour = Math.floor(seconds / 3600);

   intervalhour + " hours";
 var a =  parseInt(intervalhour)-parseInt(hourstotal);

  return intervalday + " days "+a + " hours";

}

/*var cur = "<?php echo gmdate('Y-m-d H:i:s',1497169077)?>";*/


</script>
@endsection
@section('body')

                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
                


<div class="inner_page">
<div id="loaders" class="loader">
<div class="loader_inner"><div class="loader_inner1">
<img src="{{ asset('assets/images/loader.gif') }}"></div></div></div>
	<!-- start ico calendar area here -->
	<section class="ico_calendar">
		<div class="container">
			<h3>Transaction History</h3>
			<div class="responsive-table">
				<table width="100%" cellspacing="0" cellpadding="0" class="table_area">
					<thead>
						<tr>
							<th width="10%" >TxHash</th>
                <th width="10%">Age</th>
							<th width="10%">Block</th>
							<th width="15%">from</th>
							<th width="15%">to</th>
							<th width="15%">value</th>
							<th width="15%">[TxFee]</th>
						</tr>
					</thead>
					<tbody id="myTable"> 
				  <input type="hidden" id="eth" value="{{Session::get('eth')}}"/>
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- end ico calendar area here -->
</div>




@endsection
@stop