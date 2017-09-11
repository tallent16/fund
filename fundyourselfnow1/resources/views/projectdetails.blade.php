@extends('layouts.plane')
 
@section('body')	
@include('header',array('class'=>'',)) 

@var	$pos 			= 	strpos(base64_decode($loan_id), "bids"); 
	@var	$finacialRatioInfo	=	$LoanDetMod->finacialRatioInfo;
	@var	$desitinationPath	=	$LoanDetMod->loan_image_url;	
	@var	$loan_video_url		=	$LoanDetMod->loanEmbedvideoUrl;
	@var	$bidInfo		=	$LoanDetMod->bidInfo;
	@var	$bidInfoCnt		=	count($bidInfo);	

<div class="inner_page">
<?php  //echo '<pre>'; print_r($investors); die;?>
	<!-- start project image/video area here-->
		<section class="top_projectarea">
			<div class="container">
				<div class="row">
					<aside class="col-sm-12">
						<h1>{{$LoanDetMod->loan_title}}</h1>
						<h4>{{$LoanDetMod->purpose_singleline}}</h4>
					</aside>
					<aside class="col-sm-8">
				@if(!empty($loan_video_url))
					{{$loan_video_url}}
				@else
					{{ Html::image($LoanDetMod->getImagePath($desitinationPath),"",['class' => '']) }}
				@endif
					</aside>
					<aside class="col-sm-4">
							@include('widgets.common.projectsummary_frontend')
					</aside>
				</div>
			</div>
		</section>
	<!-- end project image/video area here-->

	<!-- start project tab area here -->
		<section class="project_tabs">
			<div class="tabs_area">
				<div class="container">
					<ul class="nav nav-tabs" role="tablist">
					    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Project Info</a></li>
					    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Company Info</a></li>
					    <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">Latest News</a></li>
					  </ul>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<aside class="col-sm-8">
						<div class="tab-content">
						    <div role="tabpanel" class="tab-pane project_info active" id="tab1">
						    	
						   	@include('widgets.common.tab.projectdetails_frontend')  	
						    
						    </div>
						    <div role="tabpanel" class="tab-pane" id="tab2">
						 
						    @foreach($LoanDetMod->directorInfo as $cinfo)
						    	<div class="team_box">
						    		<div class="owner_imagebox">
						    			<img src="images/user.jpg" alt="" class="img-circle" />
						    			<h4 style="color: #000;">{{$cinfo['name']}}</h4>
						    			<h5>Age: {{$cinfo['age']}}</h5>
						    			<h5>Experience :{{$cinfo['overall_experience']}}</h5>
						    		</div>
						    		<h4>Team Info</h4>
						    		<p>{{$cinfo['directors_profile']}}</p>
						    	</div>

						    	@endforeach
						    	
						    
						    </div>
						    <div role="tabpanel" class="tab-pane" id="tab3">
						    	<article class="updates_box">
                    <h5 class="text-uppercase"><span><img src="{{ url('assets/images/icon_f.png') }}" alt="" /></span>project updates</h5>
                    <ul>
                     @if(!empty($project_update))
                     @foreach($project_update as $pu)
                      <li>
                        <img src="{{url().'/'.$LoanDetMod->loan_image_url}}" alt="" class="updates_userimg" />
                        <p>{{$pu->update_description}}</p>
                        <span class="update_date"><a>Posted on <?php   echo date("M j, Y", strtotime($pu->date)); ?></a></span>
                      </li>
                      @endforeach
                     @endif
                     
                    </ul>
                  </article>

                  <article class="updates_box twitter_updates_box">
                    <h5 class="text-uppercase"><span><i style="color:#1da1f2; font-size:18px;" class="fa fa-twitter" aria-hidden="true"></i></span>Twitter</h5>
                     <div id=all_tweets></div>
                   
                  </article>

                  <article class="updates_box twitter_updates_box">
                    <h5 class="text-uppercase"><span><i style="color:#3b5998; font-size:18px;" class="fa fa-facebook-square" aria-hidden="true"></i></span>Facebook</h5>
                    <ul id="fb">
                    
                    </ul>
                  </article>
						    </div>
						</div>
					</aside>


						
				<aside class="col-sm-4 project_right_side">
						
						<!-- <h4 class="sidebar_title">Social Links</h4>
						@if($all_links)
						<div class="sidebar_box">
						<ul>
						@foreach($all_links as $val)
						
							<li><a href="<?php echo $val->link; ?>" target="_blank">{{$val->name}}</a></li>
                          @endforeach	 
                        </ul>
                        </div>	
				 @else	<div class="row text-center"style="border:1px solid #ccc;padding:5px;">
						No Links Found
					</div>
				@endif

			<div> </div> -->

						<h4 class="sidebar_title">Rewards</h4>
						@if($BorModLoan->reward_details)
						@foreach($BorModLoan->reward_details as $val)
						<div class="sidebar_box">
							<h4>{{$val['token_title']}}<span><i class="fa fa-tag" aria-hidden="true"></i> {{ Round($val['token_cost'],0)}} tokens required</span></h4>
							<p>You will receive:</p>
							<ul>
								{{$val['token_description']}}
							</ul>

							<div class="sidebar_hover">
								<a href="#">
									<div class="table_box">
										<div class="table_inner">
											<i class="fa fa-link" aria-hidden="true"></i><br/><br/>Select Reward
										</div>
									</div>	
								</a>
							</div>

						</div>
                        @endforeach		
				@else	<div class="row text-center"style="border:1px solid #ccc;padding:5px;">
						No Rewards Found
					</div>
				@endif

              </aside> -->
				</div>
			</div>
		</section>
	<!-- end project tab area here -->
</div>
<?php //echo '<pre>'; print_r(Auth::user());  echo '</pre>';die; ?>
<!-- start footer here-->
	<footer class="footer">
@include('footer')

</footer>
<!-- end footer here-->
@section ('popup-box_panel_title',Lang::get('Fund Yourself Now'))
@section ('popup-box_panel_body')
@include('widgets.modal_box.bid_information')
@endsection

@include('widgets.modal_box.panel', array(	'id'=>'bid_information',
										'aria_labelledby'=>'bid_information',
										'as'=>'popup-box',
										'class'=>'',
									))


<!--Warning Token Popup Block -->
@section ('warning-popup-box_panel_title',Lang::get('Fund Yourself Now'))
	@section ('warning-popup-box_panel_body')
		<label>
	 You can not bid for Project Reference Number:
					<span id="modal_loan_number">{{$LoanDetMod->loan_reference_number}}</span>
		</label>
		<div class="form-group">
	<label>
		Once your account is approved by the admin you will be able  to bid.
	</label>
</div>
	@endsection
	@section ('warning-popup-box_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'></div>
			<div class='col-sm-2'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='Ok' 
						id="buttonid"
						
						>
			</div>
			
			
				<input 	type='hidden' 
						id='warning_item_type' 
						value="" 
						>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'warning_token_popup',
												'aria_labelledby'=>'warning_token_popup',
												'as'=>'warning-popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))
@section ('warning-popup-box1_panel_title',Lang::get('Fund Yourself Now'))
	@section ('warning-popup-box1_panel_body')
		<label>
	 You can not bid for Project Reference Number:
					<span id="modal_loan_number">{{$LoanDetMod->loan_reference_number}}</span>
		</label>
		<div class="form-group">
	<label>
		Your country is restricted for this project
	</label>
</div>
	@endsection
	@section ('warning-popup-box1_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'></div>
			<div class='col-sm-2'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='Ok' 
						id="buttonid1"
						
						>
			</div>
			
			
				<input 	type='hidden' 
						id='warning_item_type' 
						value="" 
						>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'warning_token_popup1',
												'aria_labelledby'=>'warning_token_popup1',
												'as'=>'warning-popup-box1',
												'class'=>'',
												'footerExists'=>'yes'
											))

@section('bottomscripts')

	<script>
		var baseUrl			=	"{{url()}}"
		var replyUrl		=	baseUrl+'/ajax/investor/send_reply'
		var	jsonBidMessage	=	{{$LoanDetMod->bidSystemMessageInfo}}
		
		$(document).ready(function (){

$.fn.exists = function(callback) {
  var args = [].slice.call(arguments, 1);

  if (this.length) {
    callback.call(this, args);
  }

  return this;
};

	$('#backed_message').exists(function() {
				$('#backed_message').modal();
			});
		});
		
		function redirecturl(loanurl)
		{
			window.location=loanurl;
		}
		
	$('.modal-body').on('hidden.bs.modal', function () {
		$('video').each(function() {
		  this.player.pause();
		});
	})
	$(document).ready(function(){
	var contract_address = "<?php echo $LoanDetMod->wallet_address ?>"; 
	   // var contract_address = "0xB1021477444C6566509e1b80d2C99E9603A31C47";
	    var eth_bal = "<?php echo $LoanDetMod->eth_baalance ?>";
		// 
           $.ajax({
				type : 'GET', // define the type of HTTP verb we want to use (POST for our form)
				url : "https://api.etherscan.io/api?module=account&action=balance&address="+contract_address+"&tag=latest&apikey=A29IKN94TG6K54MMXGFHD5PICRNY73G33I" , //Etherium api to get cuurent balance of smart contract adddress
				dataType    : 'json'
			}).done(function(data) {
				if(eth_bal==''){ 
					eth_bal = 0;
				}
			
            if(data.result=='Error!'){
			   	data.result = 0;
			   }
			 
				var eth1 = parseFloat(eth_bal);
				var eth2 = (parseFloat(data.result)/1000000000000000000).toFixed(8);
            	  
				var total_eth = parseFloat(eth1)+parseFloat(eth2);
				$('.eth').html(total_eth + ' ETH');
                              
                    var total_fund = "<?php echo $LoanDetMod->apply_amount ?>";
                     var percent = total_eth/total_fund;
                                   
                     var final_per = percent*100;
                     //alert(final_per);
             
                $('.bar').html('<div style="width:'+final_per+'%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar progress-bar-danger"><span class="sr-only">'+final_per+'% Complete</span></div>')

			});
         if(contract_address != ''){
       var link =   "https://etherscan.io/address/"+contract_address;
        $('.link').html("<a href="+link+" target='_blank'>Varify your smart contract address</a>");
           }
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
});
	</script>	
	<script type="text/javascript">
$(document).ready(function(){
var date = new Date(" Tue Aug 29 2017 05:30:00 GMT+0530 (IST)");

   var fblink = "<?php echo $fblink ?>";

  if(fblink){
var numberPattern = /\d+/g;
var value = fblink.match( numberPattern ).join([]);
   $.ajax({
        type : 'GET', // define the type of HTTP verb we want to use (POST for our form)
        url : "https://graph.facebook.com/"+value+"/posts?fields=id,description,name,message,picture,created_time,actions,from,type,status_type&access_token=EAACeol6lGhsBADsFQ6RcLZBmJiHsFtehZCr7LIVopZCA6uemALQqdCLSCP4BxvApAV9SuPGON7rcZBmcwQAmelTKMJwULgsERhXK86ACyQL1tPclgZCJSGvjaNPK8lFRaU2ZAfrtHskigQz7aq6OAY2xY3EHnFCJcZD&limit=5" , 
        dataType:'json',
      success : function(result) {
           $.each(result.data, function(index, value){
          
         
         
                 var str = value.created_time.split('T');
                 var dates =  new Date(str[0]);

               var mydates =  dates.toDateString();
              
            if(value.type=='status'){
              var message = value.message;
            }
            if(value.type=='photo'){
           var message = '<div class="media"><img src="'+value.picture+'"></div>';
            }
             $('#fb').append( '<li> <img src="{{ url('assets/images/fb.png') }}" alt="" class="updates_userimg" /><p>'+message+'</p> <span class="update_date"><a>Posted on '+mydates+'</span></a> </li>');
            }); 
          
        }
      });
   }
 });

var twitterlink = "<?php echo $twiterlink ?>";
var mySplitResult = twitterlink.split("/");
var twitername = mySplitResult[mySplitResult.length - 1];


/*********************************************************************
*  #### Twitter Post Fetcher v17.0.2 ####
*  Coded by Jason Mayes 2015. A present to all the developers out there.
*  www.jasonmayes.com
*  Please keep this disclaimer with my code if you use it. Thanks. :-)
*  Got feedback or questions, ask here:
*  http://www.jasonmayes.com/projects/twitterApi/
*  Github: https://github.com/jasonmayes/Twitter-Post-Fetcher
*  Updates will be posted to this site.
*********************************************************************/
(function(root,factory){
	
  if(typeof define==='function'&&define.amd){
    define([],factory);
  }else if(typeof exports==='object'){
    module.exports=factory();
  }else{
    factory();
  }}(this,function(){
    var domNode='';var maxTweets=20;var parseLinks=true;var queue=[];var inProgress=false;var printTime=true;var printUser=true;var formatterFunction=null;var supportsClassName=true;var showRts=true;var customCallbackFunction=null;var showInteractionLinks=true;var showImages=false;var useEmoji=false;var targetBlank=true;var lang='en';var permalinks=true;var dataOnly=false;var script=null;var scriptAdded=false;
    function handleTweets(tweets){
      if(customCallbackFunction===null){var x=tweets.length;var n=0;var element=document.getElementById(domNode);var html='<ul>';while(n<x){html+='<li>'+tweets[n]+'</li>';n++;}
html+='</ul>';element.innerHTML=html;}else{customCallbackFunction(tweets);
}
}
function strip(data){return data.replace(/<b[^>]*>(.*?)<\/b>/gi,function(a,s){return s;}).replace(/class="(?!(tco-hidden|tco-display|tco-ellipsis))+.*?"|data-query-source=".*?"|dir=".*?"|rel=".*?"/gi,'');}
function targetLinksToNewWindow(el){var links=el.getElementsByTagName('a');for(var i=links.length-1;i>=0;i--){links[i].setAttribute('target','_blank');}}
function getElementsByClassName(node,classname){var a=[];var regex=new RegExp('(^| )'+classname+'( |$)');var elems=node.getElementsByTagName('*');for(var i=0,j=elems.length;i<j;i++){if(regex.test(elems[i].className)){a.push(elems[i]);}}
return a;}
function extractImageUrl(image_data){if(image_data!==undefined&&image_data.innerHTML.indexOf('data-srcset')>=0){var data_src=image_data.innerHTML.match(/data-srcset="([A-z0-9%_\.-]+)/i)[0];return decodeURIComponent(data_src).split('"')[1];}}
var twitterFetcher={fetch:function(config){if(config.maxTweets===undefined){config.maxTweets=20;}
if(config.enableLinks===undefined){config.enableLinks=true;}
if(config.showUser===undefined){config.showUser=true;}
if(config.showTime===undefined){config.showTime=true;}
if(config.dateFunction===undefined){config.dateFunction='default';}
if(config.showRetweet===undefined){config.showRetweet=true;}
if(config.customCallback===undefined){config.customCallback=null;}
if(config.showInteraction===undefined){config.showInteraction=true;}
if(config.showImages===undefined){config.showImages=false;}
if(config.useEmoji===undefined){config.useEmoji=false;}
if(config.linksInNewWindow===undefined){config.linksInNewWindow=true;}
if(config.showPermalinks===undefined){config.showPermalinks=true;}
if(config.dataOnly===undefined){config.dataOnly=false;}
if(inProgress){queue.push(config);}else{inProgress=true;domNode=config.domId;maxTweets=config.maxTweets;parseLinks=config.enableLinks;printUser=config.showUser;printTime=config.showTime;showRts=config.showRetweet;formatterFunction=config.dateFunction;customCallbackFunction=config.customCallback;showInteractionLinks=config.showInteraction;showImages=config.showImages;useEmoji=config.useEmoji;targetBlank=config.linksInNewWindow;permalinks=config.showPermalinks;dataOnly=config.dataOnly;var head=document.getElementsByTagName('head')[0];if(script!==null){head.removeChild(script);}
script=document.createElement('script');script.type='text/javascript';if(config.list!==undefined){script.src='https://syndication.twitter.com/timeline/list?'+'callback=__twttrf.callback&dnt=false&list_slug='+
config.list.listSlug+'&screen_name='+config.list.screenName+'&suppress_response_codes=true&lang='+(config.lang||lang)+'&rnd='+Math.random();}else if(config.profile!==undefined){script.src='https://syndication.twitter.com/timeline/profile?'+'callback=__twttrf.callback&dnt=false'+'&screen_name='+config.profile.screenName+'&suppress_response_codes=true&lang='+(config.lang||lang)+'&rnd='+Math.random();}else if(config.likes!==undefined){script.src='https://syndication.twitter.com/timeline/likes?'+'callback=__twttrf.callback&dnt=false'+'&screen_name='+config.likes.screenName+'&suppress_response_codes=true&lang='+(config.lang||lang)+'&rnd='+Math.random();}else{script.src='https://cdn.syndication.twimg.com/widgets/timelines/'+
config.id+'?&lang='+(config.lang||lang)+'&callback=__twttrf.callback&'+'suppress_response_codes=true&rnd='+Math.random();}
head.appendChild(script);}},callback:function(data){if(data===undefined||data.body===undefined){inProgress=false;if(queue.length>0){twitterFetcher.fetch(queue[0]);queue.splice(0,1);}
return;}
if(!useEmoji){data.body=data.body.replace(/(<img[^c]*class="Emoji[^>]*>)|(<img[^c]*class="u-block[^>]*>)/g,'');}
if(!showImages){data.body=data.body.replace(/(<img[^c]*class="NaturalImage-image[^>]*>|(<img[^c]*class="CroppedImage-image[^>]*>))/g,'');}
if(!printUser){data.body=data.body.replace(/(<img[^c]*class="Avatar"[^>]*>)/g,'');}
var div=document.createElement('div');div.innerHTML=data.body;if(typeof(div.getElementsByClassName)==='undefined'){supportsClassName=false;}
function swapDataSrc(element){
	var avatarImg=element.getElementsByTagName('img')[0];avatarImg.src=avatarImg.getAttribute('data-src-2x');return element;
}
var tweets=[];var authors=[];var times=[];var images=[];var rts=[];var tids=[];var permalinksURL=[];var x=0;if(supportsClassName){var tmp=div.getElementsByClassName('timeline-Tweet');while(x<tmp.length){if(tmp[x].getElementsByClassName('timeline-Tweet-retweetCredit').length>0){rts.push(true);}else{rts.push(false);}
if(!rts[x]||rts[x]&&showRts){tweets.push(tmp[x].getElementsByClassName('timeline-Tweet-text')[0]);tids.push(tmp[x].getAttribute('data-tweet-id'));if(printUser){authors.push(swapDataSrc(tmp[x].getElementsByClassName('timeline-Tweet-author')[0]));}
times.push(tmp[x].getElementsByClassName('dt-updated')[0]);permalinksURL.push(tmp[x].getElementsByClassName('timeline-Tweet-timestamp')[0]);if(tmp[x].getElementsByClassName('timeline-Tweet-media')[0]!==undefined){images.push(tmp[x].getElementsByClassName('timeline-Tweet-media')[0]);}else{images.push(undefined);}}
x++;}}else{var tmp=getElementsByClassName(div,'timeline-Tweet');while(x<tmp.length){if(getElementsByClassName(tmp[x],'timeline-Tweet-retweetCredit').length>0){rts.push(true);}else{rts.push(false);}
if(!rts[x]||rts[x]&&showRts){tweets.push(getElementsByClassName(tmp[x],'timeline-Tweet-text')[0]);tids.push(tmp[x].getAttribute('data-tweet-id'));if(printUser){authors.push(swapDataSrc(getElementsByClassName(tmp[x],'timeline-Tweet-author')[0]));}
times.push(getElementsByClassName(tmp[x],'dt-updated')[0]);permalinksURL.push(getElementsByClassName(tmp[x],'timeline-Tweet-timestamp')[0]);if(getElementsByClassName(tmp[x],'timeline-Tweet-media')[0]!==undefined){images.push(getElementsByClassName(tmp[x],'timeline-Tweet-media')[0]);}else{images.push(undefined);}}
x++;}}
if(tweets.length>maxTweets){tweets.splice(maxTweets,(tweets.length-maxTweets));authors.splice(maxTweets,(authors.length-maxTweets));times.splice(maxTweets,(times.length-maxTweets));rts.splice(maxTweets,(rts.length-maxTweets));images.splice(maxTweets,(images.length-maxTweets));permalinksURL.splice(maxTweets,(permalinksURL.length-maxTweets));}
var arrayTweets=[];
var x=tweets.length;var n=0;if(dataOnly){while(n<x){arrayTweets.push({tweet:tweets[n].innerHTML,author:authors[n]?authors[n].innerHTML:'Unknown Author',author_data:{profile_url:authors[n]?authors[n].querySelector('[data-scribe="element:user_link"]').href:null,profile_image:authors[n]?authors[n].querySelector('[data-scribe="element:avatar"]').getAttribute('data-src-1x'):null,profile_image_2x:authors[n]?authors[n].querySelector('[data-scribe="element:avatar"]').getAttribute('data-src-2x'):null,screen_name:authors[n]?authors[n].querySelector('[data-scribe="element:screen_name"]').title:null,name:authors[n]?authors[n].querySelector('[data-scribe="element:name"]').title:null},time:times[n].textContent,timestamp:times[n].getAttribute('datetime').replace('+0000','Z').replace(/([\+\-])(\d\d)(\d\d)/,'$1$2:$3'),image:extractImageUrl(images[n]),rt:rts[n],tid:tids[n],permalinkURL:(permalinksURL[n]===undefined)?'':permalinksURL[n].href});n++;}}else{while(n<x){if(typeof(formatterFunction)!=='string'){var datetimeText=times[n].getAttribute('datetime');var newDate=new Date(times[n].getAttribute('datetime').replace(/-/g,'/').replace('T',' ').split('+')[0]);var dateString=formatterFunction(newDate,datetimeText);times[n].setAttribute('aria-label',dateString);if(tweets[n].textContent){if(supportsClassName){times[n].textContent=dateString;}else{var h=document.createElement('p');var t=document.createTextNode(dateString);h.appendChild(t);h.setAttribute('aria-label',dateString);times[n]=h;}}else{times[n].textContent=dateString;}}
var op='';if(parseLinks){if(targetBlank){targetLinksToNewWindow(tweets[n]);if(printUser){targetLinksToNewWindow(authors[n]);}}
if(printUser){op+='<div class="user">'+strip(authors[n].innerHTML)+'</div>';}
op+='<p class="tweet">'+strip(tweets[n].innerHTML)+'</p>';if(printTime){if(permalinks){op+='<p class="timePosted"><a href="'+permalinksURL[n]+'">'+times[n].getAttribute('aria-label')+'</a></p>';}else{op+='<p class="timePosted">'+
times[n].getAttribute('aria-label')+'</p>';}}}else{if(tweets[n].textContent){if(printUser){op+='<p class="user">'+authors[n].textContent+'</p>';}
op+='<p class="tweet">'+tweets[n].textContent+'</p>';if(printTime){op+='<p class="timePosted">'+times[n].textContent+'</p>';}}else{if(printUser){op+='<p class="user">'+authors[n].textContent+'</p>';}
op+='<p class="tweet">'+tweets[n].textContent+'</p>';if(printTime){op+='<p class="timePosted">'+times[n].textContent+'</p>';}}}

if(showImages&&images[n]!==undefined&&extractImageUrl(images[n])!==undefined){op+='<div class="media">'+'<img src="'+extractImageUrl(images[n])+'" alt="Image from tweet" />'+'</div>';}
if(showImages){arrayTweets.push(op);}else if(!showImages&&tweets[n].textContent.length){arrayTweets.push(op);}
n++;}}
handleTweets(arrayTweets);inProgress=false;if(queue.length>0){twitterFetcher.fetch(queue[0]);queue.splice(0,1);}}};window.__twttrf=twitterFetcher;window.twitterFetcher=twitterFetcher;return twitterFetcher;
}));


var configProfile = {
  "profile": {"screenName": twitername},
  "domId": 'all_tweets',
  "maxTweets": 5,
  "enableLinks": true, 
  "showUser": true,
  "showTime": true,
  "showImages": false,
  "lang": 'en'
};
twitterFetcher.fetch(configProfile);
 
</script>
@endsection


</div>
	
@endsection

@stop



